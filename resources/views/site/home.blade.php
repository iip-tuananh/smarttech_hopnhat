@extends('site.layouts.master')
@section('title')
    {{ $config->meta_title ?? $config->web_title }}
@endsection
@section('description')
    {{ $config->web_des }}
@endsection
@section('image')
    {{ url('' . $banners[0]->image->path) }}
@endsection
@section('css')
    <link href="/site/css/index.scss.css?1743048451127" rel="stylesheet" type="text/css" media="all" />
@endsection
@section('content')
    <section class="section_slider">
        <div class="home-slider swiper-container gallery-top">
            <div class="swiper-wrapper">
                @foreach ($banners as $banner)
                    <div class="swiper-slide">
                        <a href="{{ $banner->link }}" class="clearfix" title="{{ $banner->name }}">
                            <picture>
                                <source media="(min-width: 1200px)"
                                    srcset="{{ $banner->image ? $banner->image->path : 'https://placehold.co/1903x694' }}">
                                <source media="(min-width: 992px)"
                                    srcset="{{ $banner->image ? $banner->image->path : 'https://placehold.co/1903x694' }}">
                                <source media="(min-width: 569px)"
                                    srcset="{{ $banner->image ? $banner->image->path : 'https://placehold.co/1903x694' }}">
                                <source media="(max-width: 567px)"
                                    srcset="{{ $banner->image ? $banner->image->path : 'https://placehold.co/1903x694' }}">
                                <img width="1903" height="694"
                                    src="{{ $banner->image ? $banner->image->path : 'https://placehold.co/1903x694' }}"
                                    alt="{{ $banner->name }}" class="img-responsive lazyload" />
                            </picture>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            var swiper = new Swiper('.home-slider', {
                autoplay: true,
                pagination: {
                    el: '.home-slider .swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.home-slider .swiper-button-next',
                    prevEl: '.home-slider .swiper-button-prev',
                },
            });
        });
    </script>
    <section class="section_service">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <div class="service-sec">
                        @foreach ($smallBanners as $smallBanner)
                            <div class="item">
                                <div class="icon">
                                    <img width="100%" class="lazyload" src="/site/images/lazy.png"
                                        data-src="{{ $smallBanner->image ? $smallBanner->image->path : 'https://placehold.co/100x100' }}"
                                        alt="{{ $smallBanner->name }}" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <style>
            .section_service .service-sec {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                justify-content: space-between;
            }

            .section_service .service-sec .item .info h3 {
                font-size: 16px;
                font-weight: 600;
                color: var(--textColor);
            }

            .section_category_home {
                padding-top: 30px;
                padding-bottom: 30px;
            }

            .section_category_home .category-home-list {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                justify-content: space-between;
            }


            .section_category_home .category-home-list .item {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 10px 20px;
                border: 1px solid #0570b8;
                background-color: #0570b8;
                border-radius: 10px;
                box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
                width: 32%;
                background-image: url('/site/images/bg_cate.jpg');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }

            @media (max-width: 1200px) {
                .section_category_home .category-home-list .item {
                    width: 31.33%;
                    padding: 10px 15px;
                }
                .section_category_home .category-home-list .item .icon {
                    width: 100px !important;
                    height: 100px !important;
                }
                .section_category_home .category-home-list .item .info {
                    width: calc(100% - 100px) !important;
                }
            }

            @media (max-width: 992px) {
                .section_category_home .category-home-list .item {
                    width: 31.33%;
                    padding: 6px;
                }
                .section_category_home .category-home-list .item .icon {
                    width: 90px !important;
                    height: 90px !important;
                }
                .section_category_home .category-home-list .item .info {
                    width: calc(100% - 90px) !important;
                }
            }

            @media (max-width: 768px) {
                .section_category_home .category-home-list .item {
                    width: 47%;
                    padding: 6px;
                }
                .section_category_home .category-home-list .item .icon {
                    width: 70px !important;
                    height: 70px !important;
                }
                .section_category_home .category-home-list .item .info {
                    width: calc(100% - 70px) !important;
                }
            }

            .section_category_home .category-home-list .item .icon {
                width: 140px;
                height: 140px;
                overflow: hidden;
                transition: all .4s linear;
            }

            .section_category_home .category-home-list .item .info {
                width: calc(100% - 140px);
            }

            .section_category_home .category-home-list .item .icon img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: all .4s linear;
            }

            .section_category_home .category-home-list .item .info h3 {
                font-size: 15px;
                font-weight: 600;
                margin-bottom: 0;
                color: #fff;
                text-transform: uppercase;
            }

            .section_category_home .title {
                font-size: 20px;
                font-weight: 600;
                color: var(--textColor);
                margin-bottom: 20px;
                text-align: center;
                text-transform: uppercase;
            }
        </style>
    </section>
    <section class="section_category_home">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="title">Danh mục sản phẩm</h2>
                </div>
                <div class="col-12">
                    <div class="category-home-list">
                        @foreach ($productCategories as $category)
                            <a href="{{ route('front.show-product-category', ['categorySlug' => $category->slug]) }}"
                                class="item">
                                <div class="icon">
                                    <img width="140" height="140" class="lazyload" src="/site/images/lazy.png"
                                        data-src="{{ $category->image ? $category->image->path : 'https://placehold.co/100x100' }}"
                                        alt="{{ $category->name }}" />
                                </div>
                                <div class="info">
                                    <h3>{{ $category->name }}</h3>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <link rel="preload" as="script" href="/site/js/count-down.js?1743048451127" />
    <script src="/site/js/count-down.js?1743048451127" type="text/javascript"></script>
    <div class="section_flash_sale">
        <div class="container">
            <div class="thumb-flasale">
                <div class="block-title">
                    <h2>
                        <a href="{{ route('front.show-product-category', ['categorySlug' => $categorySpecialFlashsale->slug]) }}"
                            title="{{ $categorySpecialFlashsale->name }}">
                            {{ $categorySpecialFlashsale->name }}
                        </a>
                    </h2>
                    <div class="timer">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 7V12H17" stroke="#14181F" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20Z"
                                stroke="#14181F" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M6.06418 2.00024L3 4.57139" stroke="#14181F" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M21.0041 4.57115L17.9399 2" stroke="#14181F" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <span class="text">Kết thúc sau:</span>
                        <div class="time" data-countdown="countdown"
                            data-date="{{ \Carbon\Carbon::parse($categorySpecialFlashsale->end_date)->format('m-d-Y-H-i-s') }}">
                        </div>
                    </div>
                </div>
                <div class="block-content">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-12">
                            <div class="flash-sale-swiper swiper-container">
                                <div class="swiper-wrapper">
                                    @foreach ($categorySpecialFlashsale->products as $product)
                                        <div class="swiper-slide flashsale__item" data-pdid="{{ $product->id }}"
                                            data-management="true">
                                            @include('site.products.product_item', ['product' => $product])
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.falshSale = {
            type: "hours",
            dateStart: "",
            dateFinish: "",
            hourStart: "00:00",
            hourFinish: "24",
            activeDay: "7",
            finishAction: "show",
            percentMin: "40",
            percentMax: "80",
            maxInStock: "300",
            useSoldQuantity: false,
            quantityType: "sold",
            timestamp: new Date().getTime(),
        }
    </script>
    <script src="/site/js/flashsale.js?1743048451127" defer></script>
    @foreach ($categorySpecial as $category)
        @if ($category->products->count() > 0)
            <div class="section_product_new section_product">
                <div class="container">
                    <div class="block-title">
                        <h2><a href="{{ route('front.show-product-category', ['categorySlug' => $category->slug]) }}"
                                title="{{ $category->name }}">{{ $category->name }}</a></h2>
                        <div class="block-view">
                            <a href="{{ route('front.show-product-category', ['categorySlug' => $category->slug]) }}"
                                class="cta-view" title="Xem thêm">Xem thêm</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-right col-lg-12 col-12">
                            <div class="block-product relative">
                                <div class="product-new-swiper swiper-container">
                                    <div class="swiper-wrapper">
                                        @foreach ($category->products as $item)
                                            <div class="swiper-slide">
                                                @include('site.products.product_item', [
                                                    'product' => $item,
                                                ])
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
    @foreach ($categorySpecialPost as $postCategory)
        <section class="section_blog">
            <div class="container">
                <div class="block-title">
                    <h2>
                        <a href="{{ route('front.list-blog', $postCategory->slug) }}"
                            title="{{ $postCategory->name }}">{{ $postCategory->name }}</a>
                    </h2>
                </div>
                <div class="block-blog relative">
                    <div class="blog-swiper swiper-container">
                        <div class="swiper-wrapper">
                            @foreach ($postCategory->posts as $post)
                                <div class="swiper-slide">
                                    <div class="item-blog">
                                        <div class="block-thumb">
                                            <a class="thumb" href="{{ route('front.detail-blog', $post->slug) }}"
                                                title="{{ $post->name }}">
                                                <img class="lazyload d-block" src="/site/images/lazy.png"
                                                    data-src="{{ $post->image ? $post->image->path : 'https://placehold.co/350x350' }}"
                                                    alt="{{ $post->name }}">
                                            </a>
                                            <div class="time-post badge">
                                                {{ date('d/m/Y', strtotime($post->created_at)) }}
                                            </div>
                                        </div>
                                        <div class="block-content">
                                            <h3><a href="{{ route('front.detail-blog', $post->slug) }}"
                                                    title="{{ $post->name }}">{{ $post->name }}</a>
                                            </h3>
                                            <div class="article-content">
                                                {!! $post->intro !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach
@endsection
@push('script')
@endpush
