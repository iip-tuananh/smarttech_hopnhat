<header id="header">
    <div class="header-top-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="logo-position-header">
                        <a href="{{ route('front.home-page') }}" class="logo " title="{{ $config->web_title }}">
                            <img src="{{ $config->image ? $config->image->path : 'https://placehold.co/100x100' }}"
                                alt="{{ $config->web_title }}" class="img-fluid" loading="lazy">
                        </a>
                    </div>
                </div>
                <div class="col-lg-9 col-6">
                    <div class="header-top-top-content">
                        <div class="marquee">
                            <div class="marquee-content">
                                @foreach (explode("\n", $config->text_top_header) as $text)
                                    <span>{{ $text }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .header-top-top .logo-position-header {
            position: relative;
            top: -15px;
            left: 0;
            width: 100%;
        }

        .header-top-top .logo-position-header .logo {
            position: absolute;
            top: 0;
            left: 0;
            height: 126px;
            width: 100%;
        }

        @media (max-width: 768px) {
            .header-top-top .logo-position-header .logo {
                height: 110px;
            }
        }

        @media (max-width: 480px) {
            .header-top-top .logo-position-header .logo {
                height: 110px;
            }
            #header .header-top-top .logo-position-header .logo img {
                padding: 10px !important;
            }
        }

        #header .header-top-top .logo-position-header .logo img {
            background-color: #343434;
            padding: 10px 20px;
            /* width: 100%; */
            height: 100%;
            border: 1px solid #0570b8;
            border-top: none;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
        }

        .header-top-top .marquee {
            width: 100%;
            overflow: hidden;
            white-space: nowrap;
            box-sizing: border-box;
            padding: 4px 0;
            position: relative;
        }

        .header-top-top .marquee-content {
            display: inline-block;
            padding-left: 100%;
            animation: marquee 20s linear infinite;
        }

        .header-top-top .marquee-content span {
            display: inline-block;
            margin-right: 200px;
            font-weight: bold;
        }

        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .header-top-top {
            background-color: #0370b8;
            color: #fff;
            padding: 10px 0;
            background-image: url('/site/images/bg_cate.jpg');
            /* background-size: cover;
            background-position: center;
            background-repeat: no-repeat; */
        }

        .header-top-top-content {
            font-size: 14px;
            font-weight: 600;
        }
    </style>
    <div class="header-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-6">
                    <a href="{{ route('front.home-page') }}" class="logo d-lg-none d-none" title="{{ $config->web_title }}">
                        <img src="{{ $config->image ? $config->image->path : 'https://placehold.co/100x100' }}"
                            alt="{{ $config->web_title }}" class="img-fluid" loading="lazy">
                    </a>
                </div>
                <div class="col-lg-6 col-12 search-header">
                    <div class="search-smart">
                        <form action="{{ route('front.search') }}" method="get" class="search-form header-search-form"
                            role="search">
                            <input type="text" name="keyword" required
                                class="input-group-field auto-search search-auto form-control"
                                placeholder="Nhập tên sản phẩm..." autocomplete="off">
                            <button class="btn btn-default" type="submit" aria-label="Tìm kiếm" title="Tìm kiếm">
                                Tìm kiếm
                            </button>
                            {{-- <div class="search-suggest">
                                <div class="list-search list-search-style">
                                </div>
                                <div class="list-search2 list-search-style">
                                </div>
                            </div> --}}
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 col-6 header-control">
                    <ul class="ul-control">
                        {{-- <li class="header-lang d-lg-block d-none" id="box-lang-desktop">
                            <a href="javascript:;" class="ae-icon">
                                <img class="ae-flag"
                                    src="//bizweb.dktcdn.net/100/496/216/themes/921741/assets/vn.png?1743048451127"
                                    alt="multilangauge">
                            </a>
                            <ul class="drop-account">
                                <li data-lang="vi" title="Tiếng Việt" class="ae-item-lang ae-active"><a
                                        href="#"><img class="ae-icon-left"
                                            src="//bizweb.dktcdn.net/100/496/216/themes/921741/assets/vn.png?1743048451127"
                                            alt="ap multilangauge"><span>Tiếng Việt</span></a></li>
                                <li data-lang="us" title="English" class="ae-item-lang"><a href="#"><img
                                            class="ae-icon-left"
                                            src="//bizweb.dktcdn.net/100/496/216/themes/921741/assets/en.png?1743048451127"
                                            alt="ap multilangauge"><span>English</span></a></li>
                            </ul>
                        </li> --}}
                        {{-- <li class="header-store d-lg-block d-none">
                            <a href="/account" title="Tài khoản">
                                <img src="//bizweb.dktcdn.net/100/496/216/themes/921741/assets/user-icon.png?1743048451127"
                                    alt="Lofi Decor" width="24" height="24">
                            </a>
                        </li> --}}
                        <li class="header-wish">
                            <a href="tel:{{ str_replace(' ', '', $config->phone) }}" class="wishlist_header"
                                title="Hotline">
                                <img src="/site/images/phone.png" alt="Hotline" width="24" height="24">
                                <span class="title" style="color: #fff; margin-right: 5px;">Hotline</span>
                            </a>
                        </li>
                        <style>
                            @media (max-width: 768px) {
                                .header-wish .title {
                                    display: none;
                                }
                            }
                        </style>
                        <li class="header-cart block-cart">
                            <a href="/cart" class="icon" aria-label="Giỏ hàng" title="Giỏ hàng">
                                <img src="/site/images/shopping-cart.png" alt="Giỏ hàng" width="24" height="24">
                                <span class="title">Giỏ hàng</span>
                                <span class="count_item_pr count-item" ng-if="cart.count > 0"><% cart.count %></span>
                            </a>
                            <div class="top-cart-content">
                                <div class="CartHeaderContainer">
                                    <form class="cart ajaxcart cartheader" ng-if="cart.count > 0">
                                        <div class="ajaxcart__inner ajaxcart__inner--has-fixed-footer cart_body items">
                                            <div class="ajaxcart__row" ng-repeat="item in cart.items">
                                                <div class="ajaxcart__product cart_product" data-line="1">
                                                    <a ng-href="/san-pham/<% item.attributes.slug %>.html"
                                                        class="ajaxcart__product-image cart_image"
                                                        title="<% item.name %>">
                                                        <img width="80" height="80"
                                                            ng-src="<% item.attributes.image %>" alt="<% item.name %>">
                                                    </a>
                                                    <div class="grid__item cart_info">
                                                        <div class="ajaxcart__product-name-wrapper cart_name">
                                                            <a ng-href="/san-pham/<% item.attributes.slug %>.html"
                                                                class="ajaxcart__product-name h4"
                                                                title="<% item.name %>"><% item.name %></a>
                                                            <div class="cart_attribute">
                                                                <div ng-repeat="attribute in item.attributes.attributes"
                                                                    style="line-height: 1;">
                                                                    <span class="cart_attribute_name"
                                                                        style="margin-left: 8px; font-weight: 600; font-size: 14px;"><% attribute.name %>
                                                                        :</span>
                                                                    <span class="cart_attribute_value"
                                                                        style="font-size: 14px;"><% attribute.value %></span>
                                                                </div>
                                                            </div>
                                                            <a title="Xóa"
                                                                class="cart__btn-remove remove-item-cart ajaxifyCart--remove"
                                                                href="javascript:;" data-line="1"
                                                                ng-click='removeItem(item.id)'></a>
                                                        </div>
                                                        <div class="grid">
                                                            <div class="grid__item one-half cart_select cart_item_name">
                                                                <div class="ajaxcart__qty input-group-btn">
                                                                    <button type="button"
                                                                        class="ajaxcart__qty-adjust ajaxcart__qty--minus items-count"
                                                                        data-id="" data-qty="1" data-line="1"
                                                                        aria-label="-"
                                                                        ng-click="decrementQuantity(item); changeQty(item.quantity, item.id)">
                                                                        -
                                                                    </button>
                                                                    <input type="text" name=""
                                                                        class="ajaxcart__qty-num number-sidebar"
                                                                        maxlength="3" ng-model="item.quantity"
                                                                        value="<%item.quantity%>" min="0"
                                                                        data-id="" data-line="1"
                                                                        aria-label="quantity" pattern="[0-9]*"
                                                                        ng-change="changeQty(item.quantity, item.id)">
                                                                    <button type="button"
                                                                        class="ajaxcart__qty-adjust ajaxcart__qty--plus items-count"
                                                                        data-id="" data-line="1" data-qty="3"
                                                                        aria-label="+"
                                                                        ng-click="incrementQuantity(item); changeQty(item.quantity, item.id)">
                                                                        +
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="grid__item one-half text-right cart_prices">
                                                                <span
                                                                    class="cart-price"><% item.price | number %>₫</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ajaxcart__footer ajaxcart__footer--fixed cart-footer"
                                            ng-if="cart.count > 0">
                                            <div class="ajaxcart__subtotal">
                                                <div class="cart__subtotal">
                                                    <div class="cart__col-6">Tổng tiền:</div>
                                                    <div class="text-right cart__totle"><span
                                                            class="total-price"><% cart.total | number %>₫</span></div>
                                                </div>
                                            </div>
                                            <div class="cart__btn-proceed-checkout-dt ">
                                                <button onclick="location.href='{{ route('cart.checkout') }}'"
                                                    type="button"
                                                    class="button btn btn-default cart__btn-proceed-checkout"
                                                    id="btn-proceed-checkout" title="Xem giỏ hàng">Xem giỏ
                                                    hàng</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="cart--empty-message" ng-if="!cart.items || cart.count == 0">
                                        <img width="32" height="32"
                                            src="/site/images/no-cart.png?1677998172667">
                                        <p>Không có sản phẩm nào trong giỏ hàng của bạn</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="menu-bar d-lg-none d-block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0.958984 1C0.958984 0.516751 1.35074 0.125 1.83398 0.125H12.334C12.8172 0.125 13.209 0.516751 13.209 1C13.209 1.48325 12.8172 1.875 12.334 1.875H1.83398C1.35074 1.875 0.958984 1.48325 0.958984 1Z"
                                fill="white"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0.958984 15C0.958984 14.5168 1.35074 14.125 1.83398 14.125H8.83399C9.31723 14.125 9.70899 14.5168 9.70899 15C9.70899 15.4832 9.31723 15.875 8.83399 15.875H1.83398C1.35074 15.875 0.958984 15.4832 0.958984 15Z"
                                fill="white"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0.958984 8C0.958984 7.51675 1.35074 7.125 1.83398 7.125H18.1673C18.6506 7.125 19.0423 7.51675 19.0423 8C19.0423 8.48325 18.6506 8.875 18.1673 8.875H1.83398C1.35074 8.875 0.958984 8.48325 0.958984 8Z"
                                fill="white"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <div class="header-menu">
                <div class="header-menu-des">
                    <nav class="header-nav">
                        <div class="user-menu d-lg-none">
                            <div class="user-icon">
                                <img src="{{ $config->image ? $config->image->path : 'https://placehold.co/100x100' }}"
                                    alt="{{ $config->web_title }}" loading="lazy">
                            </div>
                        </div>
                        <ul class="item_big">
                            <li class="nav-item active ">
                                <a class="a-img" href="{{ route('front.home-page') }}" title="Trang chủ">
                                    Trang chủ
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="a-img" href="{{ route('front.about-us') }}" title="Giới thiệu">
                                    Giới thiệu
                                </a>
                            </li>
                            <li class="nav-item   has-mega">
                                <a class="a-img caret-down" href="javascript:void(0);" title="Sản phẩm">
                                    Sản phẩm
                                </a>
                                <i class="fa fa-caret-down"></i>
                                <div class="mega-content d-lg-block d-none">
                                    <div class="container">
                                        <ul class="level0">
                                            @foreach ($productCategories as $category)
                                                <li class="level1 parent item fix-navs "
                                                    data-title="{{ $category->name }}"
                                                    data-link="{{ route('front.show-product-category', ['categorySlug' => $category->slug]) }}">
                                                    <a class="hmega"
                                                        href="{{ route('front.show-product-category', ['categorySlug' => $category->slug]) }}"
                                                        title="{{ $category->name }}">{{ $category->name }}</a>
                                                    @if ($category->childs->count() > 0)
                                                        <ul class="level1">
                                                            @foreach ($category->childs as $child)
                                                                <li class="level2 ">
                                                                    <a href="{{ route('front.show-product-category', ['categorySlug' => $child->slug]) }}"
                                                                        title="{{ $child->name }}">{{ $child->name }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <ul class="item_small d-lg-none d-block">
                                    @foreach ($productCategories as $category)
                                        <li>
                                            <a class="caret-down"
                                                href="{{ route('front.show-product-category', ['categorySlug' => $category->slug]) }}"
                                                title="{{ $category->name }}">
                                                {{ $category->name }}
                                            </a>
                                            @if ($category->childs->count() > 0)
                                                <i class="fa fa-caret-down"></i>
                                                <ul>
                                                    @foreach ($category->childs as $child)
                                                        <li>
                                                            <a href="{{ route('front.show-product-category', ['categorySlug' => $child->slug]) }}"
                                                                title="{{ $child->name }}"
                                                                class="a3">{{ $child->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            @foreach ($postCategories as $postCategory)
                                <li class="nav-item ">
                                    <a class="a-img"
                                        href="{{ route('front.list-blog', ['slug' => $postCategory->slug]) }}"
                                        title="{{ $postCategory->name }}">
                                        {{ $postCategory->name }}
                                    </a>
                                </li>
                            @endforeach
                            <li class="nav-item ">
                                <a class="a-img" href="{{ route('front.contact-us') }}" title="Liên hệ">
                                    Liên hệ
                                </a>
                            </li>
                        </ul>
                    </nav>
                    @if ($categorySpecialFlashsale)
                        <div class="flash-scroll">
                            <a href="{{ route('front.show-product-category', ['categorySlug' => $categorySpecialFlashsale->slug]) }}"
                                class="scroll-down">
                                <img width="12" src="/site/images/menu_icon_3.png"
                                    alt="{{ $categorySpecialFlashsale->name }}">
                                {{ $categorySpecialFlashsale->name }}
                            </a>
                        </div>
                    @endif
                    <div class="control-menu">
                        <a href="#" id="prev">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                <path fill="#000"
                                    d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 278.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z" />
                            </svg>
                        </a>
                        <a href="#" id="next">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                <path fill="#000"
                                    d="M342.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L274.7 256 105.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
