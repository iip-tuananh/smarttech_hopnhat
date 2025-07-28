<div class="item_product_main">
    <form
        class="variants product-action "
        data-id="product-actions-32949270" enctype="multipart/form-data">
        <div class="product-thumbnail">
            <a class="image_thumb"
                href="{{ route('front.show-product-detail', $product->slug) }}"
                title="{{$product->name}}">
                <img class="lazyload" width="350" height="350"
                    {{-- src="/site/images/lazy.png" --}}
                    src="{{ $product->image ? $product->image->path : 'https://placehold.co/350x350' }}"
                    alt="{{$product->name}}" loading="lazy"/>
            </a>
            @if ($product->base_price > 0 && $product->price > 0)
            <span class="smart">-
                {{ round(100 - ($product->price / $product->base_price) * 100) }}%
            </span>
            @endif
            <div class="action">
                <div class="actions-secondary">
                    <div class="actions-primary" style="cursor: pointer; padding: 8px; border: 1px solid #0370b8; background-color: #0370b8" ng-click="addToCart({{ $product->id }})">
                        <a class="btn-cart add_to_cart " href="javascript:void(0);"
                            title="Thêm vào giỏ hàng">
                            <span class="icon icon-cart">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="16" height="18"
                                    viewBox="0 0 18 20" fill="none">
                                    <path fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M8.50001 1.75C6.98123 1.75 5.75001 2.98121 5.75001 4.5L5.75 8.83231C5.75 9.24652 5.41421 9.58231 5 9.58231C4.58579 9.58231 4.25 9.24652 4.25 8.8323L4.25001 4.49999C4.25001 2.15279 6.1528 0.25 8.50001 0.25H9.5C11.8472 0.25 13.75 2.15279 13.75 4.5V9C13.75 9.41421 13.4142 9.75 13 9.75C12.5858 9.75 12.25 9.41421 12.25 9V4.5C12.25 2.98122 11.0188 1.75 9.5 1.75H8.50001Z"
                                        fill="#fff" />
                                    <path fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M0.365475 9.71565C-0.271948 7.07673 2.13363 4.83729 4.68971 5.25515C7.6749 5.74315 10.2539 5.75778 13.3285 5.25915C15.8862 4.84435 18.3012 7.08619 17.6626 9.7297L15.8987 17.0323C15.5134 18.6275 14.0839 19.75 12.4423 19.75H5.58922C3.94759 19.75 2.5181 18.6275 2.13279 17.0323L0.365475 9.71565ZM4.44771 6.7355C2.82223 6.46977 1.46793 7.89121 1.82354 9.36346L3.59085 16.6801C3.81308 17.6001 4.63848 18.25 5.58922 18.25H12.4423C13.393 18.25 14.2184 17.6001 14.4407 16.6801L16.2046 9.37751C16.5607 7.90333 15.2 6.47523 13.5686 6.73981C10.3323 7.26466 7.59048 7.24926 4.44771 6.7355Z"
                                        fill="#fff" />
                                    <path fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M6.35724 12.9114C6.36263 12.4972 6.70276 12.1658 7.11694 12.1712L11.0098 12.2219C11.424 12.2273 11.7553 12.5674 11.7499 12.9816C11.7446 13.3958 11.4044 13.7271 10.9902 13.7217L7.09742 13.6711C6.68324 13.6657 6.35185 13.3256 6.35724 12.9114Z"
                                        fill="#fff" />
                                    <path fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M9.08863 10.2501C9.5028 10.2555 9.83419 10.5956 9.8288 11.0098L9.77812 14.9026C9.77273 15.3168 9.4326 15.6482 9.01843 15.6428C8.60425 15.6374 8.27286 15.2972 8.27825 14.8831L8.32893 10.9902C8.33432 10.5761 8.67445 10.2447 9.08863 10.2501Z"
                                        fill="#fff" />
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-info">
            <h3 class="product-name"><a
                    href="{{ route('front.show-product-detail', $product->slug) }}"
                    title="{{$product->name}}">{{$product->name}}</a></h3>
            <div class="price-box">
                @if ($product->base_price > 0 && $product->price > 0)
                <span class="price">{{ formatCurrency($product->price) }}₫</span>
                <span class="compare-price">{{ formatCurrency($product->base_price) }}₫</span>
                @elseif ($product->price > 0 && $product->base_price == 0)
                <span class="price">{{ formatCurrency($product->price) }}₫</span>
                @elseif ($product->price == 0 && $product->base_price > 0)
                <span class="price">{{ formatCurrency($product->base_price) }}₫</span>
                @else
                <span class="price">Liên hệ</span>
                @endif
            </div>
        </div>
    </form>
</div>
