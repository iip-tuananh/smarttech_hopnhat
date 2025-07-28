<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Model\Common\File;
use App\Helpers\FileHelper;

class ProductRate extends Model
{
    const STATUS_WAITING = 1;
    const STATUS_APPROVED = 2;
    const STATUS_UNAPPROVED = 0;

    const STATUSES = [
        ['id' => self::STATUS_WAITING, 'name' => 'Chờ duyệt', 'type' => 'warning'],
        ['id' => self::STATUS_APPROVED, 'name' => 'Đã duyệt', 'type' => 'success'],
        ['id' => self::STATUS_UNAPPROVED, 'name' => 'Không duyệt', 'type' => 'danger'],
    ];

    protected $table = 'product_rates';

    protected $fillable = [
        'product_id',
        'name',
        'email',
        'phone',
        'rating',
        'title',
        'desc',
    ];

    public function galleries()
    {
        return $this->hasMany(ProductRateGallery::class, 'product_rate_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function removeFromDB() {
        foreach ($this->images as $image) $image->removeFromDB();
        $this->delete();
    }

    public static function searchByFilter($request)
    {
        $result = self::query();

        if (!empty($request->name)) {
            $result = $result->where('name', 'like', '%' . $request->name . '%');
        }
        if (!empty($request->code)) {
            $result = $result->where('code', 'like', '%' . $request->code . '%');
        }

        $result = $result->orderBy('created_at', 'desc')->get();
        return $result;
    }

    public static function getDataForEdit($id)
    {
        return self::with([
            'product',
            'galleries' => function ($q) {
                $q->select(['id', 'product_rate_id', 'sort'])
                    ->with(['image'])
                    ->orderBy('sort', 'ASC');
            }
            ])->where('id', $id)
            ->firstOrFail();
    }

    public function syncGalleries($galleries)
    {
        if ($galleries) {
            $exist_ids = [];
            foreach ($galleries as $g) {
                if (isset($g['id'])) array_push($exist_ids, $g['id']);
            }

            $deleted = ProductRateGallery::where('product_rate_id', $this->id)->whereNotIn('id', $exist_ids)->get();
            foreach ($deleted as $item) {
                if ($item->image) {
                    FileHelper::forceDeleteFiles($item->image->id, $item->id, ProductRateGallery::class, null);
                    $item->image->removeFromDB();
                }
                $item->removeFromDB();
            }

            for ($i = 0; $i < count($galleries); $i++) {
                $g = $galleries[$i];

                if (isset($g['id'])) $gallery = ProductRateGallery::find($g['id']);
                else $gallery = new ProductRateGallery();

                $gallery->product_rate_id = $this->id;
                $gallery->sort = $i;
                $gallery->save();

                if (isset($g['image'])) {
                    if ($gallery->image) $gallery->image->removeFromDB();
                    $file = $g['image'];
                    FileHelper::uploadFile($file, 'product_rate', $gallery->id, ProductRateGallery::class, null, 1);
                }
            }
        } else {
            $galleries = $this->galleries;
            foreach ($galleries as $gallery) {
                if ($gallery->image) {
                    FileHelper::forceDeleteFiles($gallery->image->id, $gallery->id, ProductRateGallery::class, null);
                    $gallery->image->removeFromDB();
                }
            }
            $this->galleries()->delete();
        }
    }
}
