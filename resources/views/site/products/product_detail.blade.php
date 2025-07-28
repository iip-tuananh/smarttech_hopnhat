@extends('site.layouts.master')
@section('title')
    {{ $product->name }}
@endsection
@section('description')
    {{ strip_tags($product->intro) }}
@endsection
@section('image')
    {{ $product->image ? $product->image->path : $product->galleries[0]->image->path }}
@endsection

@section('css')
    <link href="/site/css/breadcrumb_style.scss.css?1743048451127" rel="stylesheet" type="text/css" media="all" />
    <link href="/site/css/product_style.scss.css?1743048451127" rel="stylesheet" type="text/css" media="all" />
    <link href="/site/css/onireviews.css?1743048451127" rel="stylesheet" type="text/css" media="all" />
    <style>
        .text-limit-3-line {
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .hidden {
            display: none;
        }

        .product-attributes {
            margin-bottom: 0 !important;
        }

        .product-attributes label {
            font-weight: 600;
            margin-bottom: 0 !important;
        }

        .product-attribute-values {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .product-attribute-values .badge,
        .product-attribute-values .badge+.badge {
            width: auto;
            border: 1px solid #0974ba;
            padding: 2px 10px;
            border-radius: 5px;
            font-size: 14px;
            color: #0974ba;
            height: 30px;
            cursor: pointer;
            pointer-events: auto;
        }

        .product-attribute-values .badge:hover {
            background-color: #0974ba;
            color: #fff;
        }

        .product-attribute-values .badge.active {
            background-color: #0974ba;
            color: #fff;
        }

        .countdown {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            margin-top: 20px;
        }

        .countdown .countdown-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .countdown-item {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 6px 10px;
            border-radius: 2px;
            background: linear-gradient(to bottom, #ff5e00, #f4955e);
        }

        .countdown-item-number {
            font-size: 24px;
            font-weight: 600;
            color: #fff;
        }

        .countdown-item-label {
            font-size: 14px;
            font-weight: 600;
            color: #fff;
        }

        .countdown-item-separator {
            font-size: 14px;
            font-weight: 600;
        }

        .btn-fixed-bottom {
            display: none;
            position: fixed;
            width: 80% !important;
            bottom: 65px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #0974ba;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            font-size: 16px;
            font-weight: 600;
            border-radius: 50px;
            z-index: 1000;
            box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
            border: 1px solid #cccccc;
        }

        @media (max-width: 768px) {
            .btn-fixed-bottom {
                display: block;
            }
        }
    </style>
@endsection

@section('content')
    <section class="bread-crumb">
        <div class="container">
            <ul class="breadcrumb">
                <li class="home">
                    <a href="{{ route('front.home-page') }}" title="Trang chủ">
                        <span>Trang chủ</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('front.show-product-category', $product->category->slug) }}"
                        title="{{ $product->category->name }}">
                        <span>{{ $product->category->name }}</span>
                    </a>
                </li>
                <li>
                    <strong>
                        <span>{{ $product->name }}</span>
                    </strong>
                </li>
            </ul>
        </div>
    </section>
    <section class="product layout-product" ng-controller="ProductDetailController">
        <div class="container">
            <div class="details-product">
                <div class="product-info">
                    <div class="row">
                        <div class="product-detail-left product-images col-12 col-md-12 col-lg-5 col-xl-5 col-left">
                            <div class="product-image-block relative">
                                <div class="swiper-container gallery-top">
                                    <div class="swiper-wrapper" id="lightgallery">
                                        <a class="swiper-slide" data-hash="0"
                                            href="{{ $product->image ? $product->image->path : 'https://placehold.co/600x400' }}"
                                            title="Click để xem">
                                            <img height="540" width="540"
                                                src="{{ $product->image ? $product->image->path : 'https://placehold.co/600x400' }}"
                                                alt="{{ $product->name }}"
                                                data-image="{{ $product->image ? $product->image->path : 'https://placehold.co/600x400' }}"
                                                class="img-responsive mx-auto d-block lazy" />
                                        </a>
                                        @foreach ($product->galleries as $key => $gallery)
                                            <a class="swiper-slide" data-hash="{{ $key + 1 }}"
                                                href="{{ $gallery->image ? $gallery->image->path : 'https://placehold.co/600x400' }}"
                                                title="Click để xem">
                                                <img height="540" width="540"
                                                    src="{{ $gallery->image ? $gallery->image->path : 'https://placehold.co/600x400' }}"
                                                    alt="{{ $product->name }}"
                                                    data-image="{{ $gallery->image ? $gallery->image->path : 'https://placehold.co/600x400' }}"
                                                    class="img-responsive mx-auto d-block lazy" />
                                            </a>
                                        @endforeach
                                    </div>
                                    <div class="swiper-button-next">
                                    </div>
                                    <div class="swiper-button-prev">
                                    </div>
                                </div>
                                <div class="swiper-container gallery-thumbs">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide" data-hash="0">
                                            <div class="p-100">
                                                <img src="{{ $product->image ? $product->image->path : 'https://placehold.co/600x400' }}"
                                                    alt="{{ $product->name }}"
                                                    data-image="{{ $product->image ? $product->image->path : 'https://placehold.co/600x400' }}"
                                                    class="lazy" />
                                            </div>
                                        </div>
                                        @foreach ($product->galleries as $key => $gallery)
                                            <div class="swiper-slide" data-hash="{{ $key + 1 }}">
                                                <div class="p-100">
                                                    <img src="{{ $gallery->image ? $gallery->image->path : 'https://placehold.co/600x400' }}"
                                                        alt="{{ $product->name }}"
                                                        data-image="{{ $gallery->image ? $gallery->image->path : 'https://placehold.co/600x400' }}"
                                                        class="lazy" />
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-button-next">
                                    </div>
                                    <div class="swiper-button-prev">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-7 col-xl-7 col-right">
                            <div class="details-pro">
                                @if ($product->origin_name)
                                    <div class="product-vendor">
                                        <span class="title">Thương hiệu:</span>
                                        <span class="vendor">{{ $product->origin_name }}</span>
                                    </div>
                                @endif
                                <h1 class="title-product">{{ $product->name }}</h1>
                                <form id="add-to-cart-form" class="form-inline">
                                    <div class="price-box clearfix">
                                        @if ($product->base_price > 0 && $product->price > 0)
                                            <span class="special-price">
                                                <span
                                                    class="price product-price">{{ formatCurrency($product->price) }}₫</span>
                                            </span>
                                            <!-- Giá Khuyến mại -->
                                            <span class="old-price">
                                                <del class="price product-price-old">
                                                    {{ formatCurrency($product->base_price) }}₫
                                                </del>
                                            </span>
                                            <!-- Giá gốca -->
                                        @elseif ($product->base_price > 0 && $product->price == 0)
                                            <span class="special-price">
                                                <span
                                                    class="price product-price">{{ formatCurrency($product->base_price) }}₫</span>
                                            </span>
                                        @elseif ($product->base_price == 0 && $product->price > 0)
                                            <span class="special-price">
                                                <span
                                                    class="price product-price">{{ formatCurrency($product->price) }}₫</span>
                                            </span>
                                        @else
                                            <span class="special-price">
                                                <span class="price product-price">Liên hệ</span>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-product">
                                        @if (count($product->attributes) > 0)
                                            <div class="select-swatch">
                                                @foreach ($product->attributes as $index => $attribute)
                                                    <div id="variant-swatch-0" class="swatch clearfix" data-option="option1"
                                                        data-option-index="0">
                                                        <div class="header">{{ $attribute['name'] }}:</div>
                                                        <div class="select-swap">
                                                            @foreach ($attribute['values'] as $key => $value)
                                                                <div data-value="{{ $value }}"
                                                                    class="n-sd swatch-element {{ $value }} ">
                                                                    <input class="variant-{{ $index }}"
                                                                        id="swatch-{{ $index }}-{{ $value }}"
                                                                        type="radio" name="option1"
                                                                        value="{{ $value }}" />
                                                                    <label
                                                                        for="swatch-{{ $index }}-{{ $value }}">
                                                                        {{ $value }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="km-hot">
                                            <div class="box-km">
                                                <h2 class="title_km">
                                                    <span>
                                                        {{-- <svg xmlns:xlink="http://www.w3.org/1999/xlink"
                                                            viewBox="0 0 24 24" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24">
                                                            <path
                                                                d="M21.5299 10.87L20.0099 9.35001C19.7499 9.09 19.5399 8.58001 19.5399 8.22001V6.06C19.5399 5.18 18.8199 4.46 17.9399 4.46H15.7899C15.4299 4.46 14.9199 4.25 14.6599 3.99L13.1399 2.47C12.5199 1.85 11.4999 1.85 10.8799 2.47L9.33988 3.99C9.08988 4.25 8.57988 4.46 8.20988 4.46H6.05988C5.17988 4.46 4.45988 5.18 4.45988 6.06V8.21C4.45988 8.57 4.24988 9.08 3.98988 9.34L2.46988 10.86C1.84988 11.48 1.84988 12.5 2.46988 13.12L3.98988 14.64C4.24988 14.9 4.45988 15.41 4.45988 15.77V17.92C4.45988 18.8 5.17988 19.52 6.05988 19.52H8.20988C8.56988 19.52 9.07988 19.73 9.33988 19.99L10.8599 21.51C11.4799 22.13 12.4999 22.13 13.1199 21.51L14.6399 19.99C14.8999 19.73 15.4099 19.52 15.7699 19.52H17.9199C18.7999 19.52 19.5199 18.8 19.5199 17.92V15.77C19.5199 15.41 19.7299 14.9 19.9899 14.64L21.5099 13.12C22.1599 12.51 22.1599 11.49 21.5299 10.87ZM7.99988 9C7.99988 8.45 8.44988 8 8.99988 8C9.54988 8 9.99988 8.45 9.99988 9C9.99988 9.55 9.55988 10 8.99988 10C8.44988 10 7.99988 9.55 7.99988 9ZM9.52988 15.53C9.37988 15.68 9.18988 15.75 8.99988 15.75C8.80988 15.75 8.61988 15.68 8.46988 15.53C8.17988 15.24 8.17988 14.76 8.46988 14.47L14.4699 8.47001C14.7599 8.18001 15.2399 8.18001 15.5299 8.47001C15.8199 8.76 15.8199 9.24 15.5299 9.53L9.52988 15.53ZM14.9999 16C14.4399 16 13.9899 15.55 13.9899 15C13.9899 14.45 14.4399 14 14.9899 14C15.5399 14 15.9899 14.45 15.9899 15C15.9899 15.55 15.5499 16 14.9999 16Z"
                                                                fill="#F79009"></path>
                                                        </svg> --}}
                                                        Thông số kỹ thuật
                                                    </span>
                                                </h2>
                                                <div class="box-promotion">
                                                    {!! $product->intro !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix form-group ">
                                            <div class="flex-quantity">
                                                <div class="custom custom-btn-number show">
                                                    <label class="sl section">Số lượng:</label>
                                                    <div class="input_number_product form-control">
                                                        <button class="btn_num num_1 button button_qty"
                                                            onClick="var result = document.getElementById('qty'); var qtypro = result.value; if( !isNaN( qtypro ) &amp;&amp; qtypro &gt; 1 ) result.value--;return false;"
                                                            type="button">-</button>
                                                        <input type="text" id="qty" name="quantity"
                                                            value="1" maxlength="3"
                                                            class="form-control prd_quantity"
                                                            onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;"
                                                            onchange="if(this.value == 0)this.value=1;">
                                                        <button class="btn_num num_2 button button_qty"
                                                            onClick="var result = document.getElementById('qty'); var qtypro = result.value; if( !isNaN( qtypro )) result.value++;return false;"
                                                            type="button">+</button>
                                                    </div>
                                                </div>
                                                <div class="btn-mua button_actions clearfix">
                                                    <div class="group-button">
                                                        <button type="submit"
                                                            class="btn btn_base normal_button btn_add_cart add_to_cart btn-cart"
                                                            ng-click="addToCartFromProductDetail()">
                                                            Thêm vào giỏ hàng
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-lg btn-gray btn_buy btn-buyNow"
                                                            ng-click="addToCartCheckoutFromProductDetail()">Mua
                                                            ngay</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-trustbadge">
                                            <span class="title-menu">Phương thức thanh toán</span>
                                            <div class="product-trustbadge my-3">
                                                <ul>
                                                    <li>
                                                        <a href="#" target="_blank" title="Visa">
                                                            <img height="40" class="lazyload"
                                                                src="/site/images/lazy.png?1743048451127"
                                                                data-src="/site/images/trustbadge_1.png?1743048451127"
                                                                alt="" />
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" target="_blank" title="MasterCard">
                                                            <img height="40" class="lazyload"
                                                                src="/site/images/lazy.png?1743048451127"
                                                                data-src="/site/images/trustbadge_2.png?1743048451127"
                                                                alt="" />
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" target="_blank" title="JCB">
                                                            <img height="40" class="lazyload"
                                                                src="/site/images/lazy.png?1743048451127"
                                                                data-src="/site/images/trustbadge_3.png?1743048451127"
                                                                alt="" />
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" target="_blank" title="VNPAY">
                                                            <img height="40" class="lazyload"
                                                                src="/site/images/lazy.png?1743048451127"
                                                                data-src="/site/images/trustbadge_4.png?1743048451127"
                                                                alt="" />
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" target="_blank" title="MoMo">
                                                            <img height="40" class="lazyload"
                                                                src="/site/images/lazy.png?1743048451127"
                                                                data-src="/site/images/trustbadge_5.png?1743048451127"
                                                                alt="" />
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product-policises-wrapper">
                                            <ul class="product-policises list-unstyled row">
                                                <li class="media col-12">
                                                    <div class="mr-3">
                                                        <img width="32" height="32" class="lazyload"
                                                            src="/site/images/lazy.png?1743048451127"
                                                            data-src="/site/images/policises_1.png?1743048451127"
                                                            alt="Giao hàng toàn quốc" />
                                                    </div>
                                                    <div class="media-body">
                                                        Giao hàng toàn quốc
                                                    </div>
                                                </li>
                                                <li class="media col-12">
                                                    <div class="mr-3">
                                                        <img width="32" height="32" class="lazyload"
                                                            src="/site/images/lazy.png?1743048451127"
                                                            data-src="/site/images/policises_2.png?1743048451127"
                                                            alt="Tích điểm tất cả sản phẩm" />
                                                    </div>
                                                    <div class="media-body">
                                                        Tích điểm tất cả sản phẩm
                                                    </div>
                                                </li>
                                                <li class="media col-12">
                                                    <div class="mr-3">
                                                        <img width="32" height="32" class="lazyload"
                                                            src="/site/images/lazy.png?1743048451127"
                                                            data-src="/site/images/policises_3.png?1743048451127"
                                                            alt="Miễn phí vận chuyển đơn từ 80k" />
                                                    </div>
                                                    <div class="media-body">
                                                        Miễn phí vận chuyển đơn từ 80k
                                                    </div>
                                                </li>
                                                <li class="media col-12">
                                                    <div class="mr-3">
                                                        <img width="32" height="32" class="lazyload"
                                                            src="/site/images/lazy.png?1743048451127"
                                                            data-src="/site/images/policises_4.png?1743048451127"
                                                            alt="Cam kết chính hãng" />
                                                    </div>
                                                    <div class="media-body">
                                                        Cam kết chính hãng, bảo hành 3 năm
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="product-hotline">
                                            <img class="img-full" src="/site/images/hotline-product.png?1743048451127"
                                                alt="" />
                                            Hotline & Zalo hỗ trợ 24/7:
                                            <a href="tel:{{ str_replace(' ', '', $config->hotline) }}"
                                                title="{{ $config->hotline }}">{{ $config->hotline }}</a>
                                            liên hệ để được tư vấn thêm
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="product-tab e-tabs not-dqtab">
                        <ul class="tabs tabs-title clearfix">
                            <li class="tab-link current" data-tab="tab-1">
                                <span>Chi tiết sản phẩm</span>
                            </li>
                            {{-- <li class="tab-link" data-tab="tab-3">
                                <span>Đánh giá khách hàng</span>
                            </li> --}}
                        </ul>
                        <div class="tab-1 tab-content content_extab current">
                            <div class="rte product_getcontent">
                                <div class="ba-text-fpt">
                                    {!! $product->body !!}
                                </div>
                                <div class="show-more d-none">
                                    <div class="btn btn-default btn--view-more">
                                        <span class="more-text">Xem thêm <i class="fa fa-chevron-down"></i></span>
                                        <span class="less-text">Thu gọn <i class="fa fa-chevron-up"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="tab-3 tab-content content_extab">
                            @include('site.partials.onireview')
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        @if ($productsRelated->count() > 0)
            <div class="container">
                <div class="productRelate">
                    <div class="block-title">
                        <h2>
                            <a href="javascript:void(0)" title="Sản phẩm cùng loại">Sản phẩm cùng loại</a>
                        </h2>
                    </div>
                    <div class="margin-am">
                        <div class="product-relate-swiper swiper-container">
                            <div class="swiper-wrapper">
                                @foreach ($productsRelated as $relatedProduct)
                                    <div class="swiper-slide">
                                        @include('site.products.product_item', [
                                            'product' => $relatedProduct,
                                        ])
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>
    <script>
        var ww = $(window).width();

        jQuery('.swatch :radio').change(function() {
            var optionIndex = jQuery(this).closest('.swatch').attr('data-option-index');
            var optionValue = jQuery(this).val();
            jQuery(this)
                .closest('form')
                .find('.single-option-selector')
                .eq(optionIndex)
                .val(optionValue)
                .trigger('change');
        });
    </script>
    <script>
        $('.tabs-title li').on('click', function(e) {
            $('.tabs-title li, .tab-content').removeClass('current');
            $(this).addClass('current');
            $('.' + $(this).data('tab') + '').addClass('current');

            var active = $(this);
            var left = active.position().left;
            var currScroll = $(this).parent('.tabs-title').scrollLeft();
            var contWidth = $(this).parent('.tabs-title').width() / 2;
            var activeOuterWidth = active.outerWidth() / 2;
            left = left + currScroll - contWidth + activeOuterWidth;

            $(this).parent('.tabs-title').animate({
                scrollLeft: left
            }, 'slow');
        });

        $(document).ready(function() {
            var galleryThumbs = new Swiper('.gallery-thumbs', {
                spaceBetween: 4,
                slidesPerView: 10,
                freeMode: true,
                lazy: true,
                watchSlidesVisibility: true,
                watchSlidesProgress: true,
                hashNavigation: true,
                slideToClickedSlide: true,
                breakpoints: {
                    300: {
                        slidesPerView: 3,
                        spaceBetween: 10,
                    },
                    500: {
                        slidesPerView: 3,
                        spaceBetween: 10,
                    },
                    640: {
                        slidesPerView: 3,
                        spaceBetween: 10,
                    },
                    768: {
                        slidesPerView: 4,
                        spaceBetween: 10,
                    },
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 10,
                    },
                    1199: {
                        slidesPerView: 4,
                        spaceBetween: 10,
                    },
                },
                navigation: {
                    nextEl: '.gallery-thumbs .swiper-button-next',
                    prevEl: '.gallery-thumbs .swiper-button-prev',
                },
            });
            var galleryTop = new Swiper('.gallery-top', {
                spaceBetween: 0,
                lazy: true,
                hashNavigation: true,
                thumbs: {
                    swiper: galleryThumbs
                },
                navigation: {
                    nextEl: '.gallery-top .swiper-button-next',
                    prevEl: '.gallery-top .swiper-button-prev',
                },
            });
            var swiper = new Swiper('.product-relate-swiper', {
                slidesPerView: 4,
                loop: false,
                grabCursor: true,
                spaceBetween: 20,
                roundLengths: true,
                slideToClickedSlide: false,
                navigation: {
                    nextEl: '.product-relate-swiper .swiper-button-next',
                    prevEl: '.product-relate-swiper .swiper-button-prev',
                },
                autoplay: false,
                breakpoints: {
                    300: {
                        slidesPerView: 1.5,
                        spaceBetween: 10
                    },
                    500: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    },
                    640: {
                        slidesPerView: 3,
                        spaceBetween: 10
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    },
                    991: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    },
                    1200: {
                        slidesPerView: 4,
                        spaceBetween: 20
                    }
                }
            });
        });


        setTimeout(function() {
            var ch = $('.product_getcontent').height(),
                smore = $('.show-more');
            if (ch > 500) {
                $('.ba-text-fpt').addClass('has-height');
                smore.removeClass('d-none');
            }
        }, 200);
        $('.btn--view-more').on('click', function(e) {
            e.preventDefault();
            var $this = $(this);
            $this.parents('.tab-content').find('.product_getcontent').toggleClass('expanded');
            $('html, body').animate({
                scrollTop: $('.product_getcontent').offset().top - 110
            }, 'slow');
            $(this).toggleClass('active');
            return false;
        });
    </script>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('.countdown-content').each(function() {
                const $container = $(this);
                const key = 'countdown_end_time'; // localStorage key
                const timeStr = $container.data('time'); // "HH:MM:SS"
                const timeParts = timeStr.split(':').map(Number);
                const cycleSeconds = timeParts[0] * 3600 + timeParts[1] * 60 + timeParts[2];

                function setNewEndTime() {
                    const newEnd = Date.now() + cycleSeconds * 1000;
                    localStorage.setItem(key, newEnd);
                    return newEnd;
                }

                // Lấy endTime từ localStorage hoặc khởi tạo mới
                let endTime = parseInt(localStorage.getItem(key), 10);
                if (!endTime || isNaN(endTime) || endTime <= Date.now()) {
                    endTime = setNewEndTime();
                }

                function updateDisplay(secondsLeft) {
                    const hrs = String(Math.floor(secondsLeft / 3600)).padStart(2, '0');
                    const mins = String(Math.floor((secondsLeft % 3600) / 60)).padStart(2, '0');
                    const secs = String(secondsLeft % 60).padStart(2, '0');

                    const $numbers = $container.find('.countdown-item-number');
                    $numbers.eq(0).text(hrs);
                    $numbers.eq(1).text(mins);
                    $numbers.eq(2).text(secs);
                }

                updateDisplay(Math.floor((endTime - Date.now()) / 1000)); // Hiển thị ban đầu

                setInterval(function() {
                    const now = Date.now();
                    let remainingSeconds = Math.floor((endTime - now) / 1000);

                    if (remainingSeconds <= 0) {
                        endTime = setNewEndTime(); // Reset lại thời gian mới
                        remainingSeconds = cycleSeconds;
                    }

                    updateDisplay(remainingSeconds);
                }, 1000);
            });
        });

        // Plus number quantiy product detail
        var plusQuantity = function() {
            if (jQuery('input[name="quantity"]').val() != undefined) {
                var currentVal = parseInt(jQuery('input[name="quantity"]').val());
                if (!isNaN(currentVal)) {
                    jQuery('input[name="quantity"]').val(currentVal + 1);
                } else {
                    jQuery('input[name="quantity"]').val(1);
                }
            } else {
                console.log('error: Not see elemnt ' + jQuery('input[name="quantity"]').val());
            }
        }
        // Minus number quantiy product detail
        var minusQuantity = function() {
            if (jQuery('input[name="quantity"]').val() != undefined) {
                var currentVal = parseInt(jQuery('input[name="quantity"]').val());
                if (!isNaN(currentVal) && currentVal > 1) {
                    jQuery('input[name="quantity"]').val(currentVal - 1);
                }
            } else {
                console.log('error: Not see elemnt ' + jQuery('input[name="quantity"]').val());
            }
        }
        app.controller('ProductDetailController', function($scope, $http, $interval, cartItemSync, $rootScope, $compile) {
            $scope.product = @json($product);
            $scope.form = {
                quantity: 1
            };

            $scope.selectedAttributes = [];
            jQuery('.product-attribute-values .badge').click(function() {
                if (!jQuery(this).hasClass('active')) {
                    jQuery(this).parent().find('.badge').removeClass('active');
                    jQuery(this).addClass('active');
                    if ($scope.selectedAttributes.length > 0 && $scope.selectedAttributes.find(item => item
                            .index == jQuery(this).data('index'))) {
                        $scope.selectedAttributes.find(item => item.index == jQuery(this).data('index'))
                            .value = jQuery(this).data('value');
                    } else {
                        let index = jQuery(this).data('index');
                        $scope.selectedAttributes.push({
                            index: index,
                            name: jQuery(this).data('name'),
                            value: jQuery(this).data('value'),
                        });
                    }
                } else {
                    jQuery(this).parent().find('.badge').removeClass('active');
                    jQuery(this).removeClass('active');
                    $scope.selectedAttributes = $scope.selectedAttributes.filter(item => item.index !=
                        jQuery(this).data('index'));
                }
                $scope.$apply();
            });

            $scope.addToCartFromProductDetail = function() {
                let quantity = $('#add-to-cart-form input[name="quantity"]').val();

                url = "{{ route('cart.add.item', ['productId' => 'productId']) }}";
                url = url.replace('productId', $scope.product.id);

                jQuery.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        'qty': parseInt(quantity),
                        'attributes': $scope.selectedAttributes
                    },
                    success: function(response) {
                        if (response.success) {
                            if (response.count > 0) {
                                $scope.hasItemInCart = true;
                            }

                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function() {
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);
                            toastr.success('Thao tác thành công !')
                        }
                    },
                    error: function() {
                        toastr.error('Thao tác thất bại !')
                    },
                    complete: function() {
                        $scope.$applyAsync();
                    }
                });
            }

            $scope.addToCartCheckoutFromProductDetail = function() {
                let quantity = $('#add-to-cart-form input[name="quantity"]').val();
                url = "{{ route('cart.add.item', ['productId' => 'productId']) }}";
                url = url.replace('productId', $scope.product.id);

                jQuery.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        'qty': parseInt(quantity),
                        'attributes': $scope.selectedAttributes
                    },
                    success: function(response) {
                        if (response.success) {
                            if (response.count > 0) {
                                $scope.hasItemInCart = true;
                            }

                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function() {
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);
                            toastr.success('Thao tác thành công !')
                            window.location.href = "{{ route('cart.checkout') }}";
                        }
                    },
                    error: function() {
                        toastr.error('Thao tác thất bại !')
                    },
                    complete: function() {
                        $scope.$applyAsync();
                    }
                });
            }
        });
    </script>
@endpush
