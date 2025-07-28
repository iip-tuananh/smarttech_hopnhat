<?php

namespace App\Http\Controllers\Front;

use App\Mail\NewOrder;
use App\Model\Admin\Config;
use App\Model\Admin\Order;
use App\Model\Admin\OrderDetail;
use App\Model\Admin\Product;
use App\Model\Common\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Category;
use App\Model\Admin\OrderRevenueDetail;
use App\Model\Admin\Voucher;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Kjmtrue\VietnamZone\Models\Province;
use Vanthao03596\HCVN\Models\District;
use Vanthao03596\HCVN\Models\Province as Vanthao03596Province;
use Vanthao03596\HCVN\Models\Ward;

class CartController extends Controller
{
    // trang giỏ hàng
    public function index()
    {
        $cartCollection = \Cart::getContent();
        $total_price = \Cart::getTotal();
        $total_qty = \Cart::getContent()->sum('quantity');

        $categories = Category::query()->where('show_home_page', 1)->orderBy('sort_order')->get();

        return view('site.orders.cart', compact('cartCollection', 'total_price', 'total_qty', 'categories'));
    }

    public function addItem(Request $request, $productId)
    {
        $product = Product::query()->find($productId);
        $arr_index = [];
        if(isset($request['attributes'])) {
            foreach ($request['attributes'] as $attribute) {
                $arr_index[] = [
                    'index' => intval($attribute['index']),
                    'value' => $attribute['value']
                ];
            }
            sort($arr_index);
        }
        $uniqueId = isset($arr_index) ? $product->id . '-' . json_encode($arr_index) : $product->id;

        \Cart::add([
            'id' => $uniqueId,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $request->qty ? (int)$request->qty : 1,
            'attributes' => [
                'image' => $product->image->path ?? '',
                'slug' => $product->slug,
                'base_price' => $product->base_price,
                'attributes' => $request['attributes']
            ]
        ]);

        $noti_product = [
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_image' => $product->image->path ?? '',
            'product_price' => $product->price,
            'product_qty' => $request->qty ? (int)$request->qty : 1,
        ];

        return \Response::json(['success' => true, 'items' => \Cart::getContent(), 'total' => \Cart::getTotal(),
            'count' => \Cart::getContent()->sum('quantity'), 'noti_product' => $noti_product]);
    }

    public function updateItem(Request $request)
    {
        \Cart::update($request->product_id, array(
            'quantity' => array(
                'relative' => false,
                'value' => $request->qty
            ),
        ));

        return \Response::json(['success' => true, 'items' => \Cart::getContent(), 'total' => \Cart::getTotal(),
            'count' => \Cart::getContent()->sum('quantity')]);

    }

    public function removeItem(Request $request)
    {
        \Cart::remove($request->product_id);

        return \Response::json(['success' => true, 'items' => \Cart::getContent(), 'total' => \Cart::getTotal(),
            'count' => \Cart::getContent()->sum('quantity')]);
    }

    // trang thanh toán
    public function checkout(Request $request) {
        $cartCollection = \Cart::getContent();
        $total = \Cart::getTotal();
        $vouchers = Voucher::query()->where('status', 1)->where('quantity', '>', 0)->where('to_date', '>=', now())->orderBy('created_at', 'desc')->get();
        $provinces = Vanthao03596Province::all();
        $districts = District::all();
        $wards = Ward::all();

        return view('site.orders.checkout', compact('cartCollection', 'total', 'vouchers', 'provinces', 'districts', 'wards'));
    }

    // áp dụng mã giảm giá (boolean)
    public function applyVoucher(Request $request) {
        $cartCollection = \Cart::getContent();
        $arr_voucher_ids = [];
        foreach ($cartCollection as $item) {
            $product = Product::query()->where('slug', $item['attributes']['slug'])->first();
            $voucher_ids = $product->vouchers()->pluck('vouchers.id')->toArray();
            $arr_voucher_ids = array_merge($arr_voucher_ids, Voucher::query()->where('status', 1)->where('quantity', '>', 0)->where('to_date', '>=', now())->where(function ($query) use ($voucher_ids) {
                $query->whereIn('id', $voucher_ids)->orWhere('is_all_product', 1);
            })->pluck('id')->toArray());
        }
        $voucher = Voucher::query()->where('code', $request->code)->whereIn('id', $arr_voucher_ids)->first();
        if(isset($voucher) && (($request->total >= $voucher->limit_bill_value && $voucher->limit_bill_value > 0) || ($voucher->limit_product_qty > 0 && $request->qty >= $voucher->limit_product_qty))) {
            return Response::json(['success' => true, 'voucher' => $voucher, 'message' => 'Áp dụng mã giảm giá thành công']);
        }
        return Response::json(['success' => false, 'message' => 'Không đủ điều kiện áp mã giảm giá']);
    }

    // submit đặt hàng
    public function checkoutSubmit(Request $request)
    {
        DB::beginTransaction();
        try {
            $translate = [
                'customer_name.required' => 'Vui lòng nhập họ tên',
                'customer_phone.required' => 'Vui lòng nhập số điện thoại',
                'customer_phone.regex' => 'Số điện thoại không đúng định dạng',
                'customer_address.required' => 'Vui lòng nhập địa chỉ',
                'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
            ];

            $validate = Validator::make(
                $request->all(),
                [
                    'customer_name' => 'required',
                    'customer_phone' => 'required|regex:/^(0)[0-9]{9,11}$/',
                    'customer_address' => 'required',
                    'customer_email' => 'nullable|email|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                    'customer_province' => 'required',
                    'customer_district' => 'required',
                    'customer_ward' => 'required',
                    'discount_code' => 'nullable',
                    'discount_value' => 'nullable',
                    'point' => 'nullable',
                    'point_value' => 'nullable',
                ],
                $translate
            );

            $json = new \stdClass();

            if ($validate->fails()) {
                $json->success = false;
                $json->errors = $validate->errors();
                $json->message = "Thao tác thất bại!";
                return Response::json($json);
            }

            $ward = Ward::query()->find($request->customer_ward);

            $customer_address = $request->customer_address . ', ' . $ward->path_with_type;

            $lastId = Order::query()->latest('id')->first()->id ?? 1;
            $total_price = $request->total;

            $order = Order::query()->create([
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'customer_address' => $customer_address,
                'customer_required' => $request->customer_required,
                'discount_code' => $request->discount_code,
                'discount_value' => $request->discount_value,
                'point' => $request->point,
                'point_value' => $request->point_value,
                'total_before_discount' => $total_price,
                'total_after_discount' => $total_price - $request->discount_value - $request->point_value,
                'code' => 'ORDER' . date('Ymd') . '-' . $lastId
            ]);

            $config = \App\Model\Admin\Config::where('id',1)->select('revenue_percent_1')->first();
            $arr_voucher_ids = [];
            foreach ($request->items as $item) {
                $product = Product::query()->where('slug', $item['attributes']['slug'])->first();
                $detail = new OrderDetail();
                $detail->order_id = $order->id;
                $detail->product_id = $product->id;
                $detail->qty = $item['quantity'];
                $detail->price = $item['price'];
                $detail->attributes = isset($item['attributes']['attributes']) ? json_encode($item['attributes']['attributes']) : null;
                $detail->save();

                $voucher_ids = $product->vouchers()->pluck('vouchers.id')->toArray();
                $arr_voucher_ids = array_merge($arr_voucher_ids, Voucher::query()->where('status', 1)->where('quantity', '>', 0)->where('to_date', '>=', now())->where(function ($query) use ($voucher_ids) {
                    $query->whereIn('id', $voucher_ids)->orWhere('is_all_product', 1);
                })->pluck('id')->toArray());

                \Cart::remove($item['id']);
            }

            $current_user = User::query()->where('email', $request->customer_email)->where('status', 1)->where('type', 10)->first();

            if($current_user) {
                $current_user->point -= $request->point;
                $current_user->save();

                // TODO: Tính điểm thưởng khi admin duyệt đơn hàng
                // $new_point = ($order->total_after_discount * $config->revenue_percent_1 / 100) / 1000;
                // $current_user->point += floor($new_point);
                // $current_user->save();
            }

            if(\Cart::getContent()->sum('quantity') == 0) {
                \Cart::clear();
            }

            $voucher = Voucher::query()->where('code', $request->discount_code)->whereIn('id', $arr_voucher_ids)->first();
            if ($voucher) {
                $voucher->quantity -= 1;
                $voucher->save();
            }

            session(['order_id' => $order->id]);

            $config = Config::query()->first();

            // gửi mail thông báo có đơn hàng mới cho admin
            $users = User::query()->where('type', 1)->where('status', 1)->get();
            // Mail::to('nguyentienvu4897@gmail.com')->send(new NewOrder($order, $config, 'admin'));


            if($users->count()) {
                foreach ($users as $user) {
                    Mail::to($user->email)->send(new NewOrder($order, $config, 'admin'));
                }
            }

            DB::commit();
            return Response::json(['success' => true, 'order_code' => $order->code, 'message' => 'Đặt hàng thành công']);
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }

    }

    // trả về trang đặt hàng thành công
    public function checkoutSuccess(Request $request)
    {
        if (!session()->has('order_id')) {
            return redirect()->route('front.home-page');
        }

        $orderId = session('order_id') ?? 39;
        $order = Order::query()->with('details', 'details.product', 'details.product.image')->find($orderId);
        session()->forget('order_id');
        return view('site.orders.checkout_success', compact('order'));
    }

}
