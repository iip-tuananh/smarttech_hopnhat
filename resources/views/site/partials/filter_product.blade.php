<div class="products-view products-view-grid list_hover_pro">
    <div class="row">
        @foreach ($products as $product)
        <div class="col-6 col-xl-4 col-lg-4 col-md-4">
            @include('site.products.product_item', [
                'product' => $product,
            ])
        </div>
        @endforeach
    </div>
    <div class="text-center">
        <nav class="clearfix relative nav_pagi w_100 ">
            {{$products->links()}}
        </nav>
    </div>
</div>