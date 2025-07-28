<!DOCTYPE html>
<html lang="vi">

<head>
    @include('site.partials.head')
    <script src="/site/js/jquery.js?1743048451127" type="text/javascript"></script>
    <script src="/site/js/swiper.js?1743048451127" type="text/javascript"></script>
    <script src="/site/js/lazy.js?1743048451127" type="text/javascript"></script>
    <style>
        :root {
            --mainColor: #0570b8;
            --mainColor2: #0570b8;
            --hover: #23aae1;
            --priceColor: #ca9236;
            --textColor: #181818;
            --gradient1: #e8cb9d;
            --gradient2: #ca9236;
        }
    </style>
    <link rel="stylesheet" href="/site/css/bootstrap-4-3-min.css?1743048451127">
    <link href="/site/css/swiper.scss.css?1743048451127" rel="stylesheet" type="text/css" media="all" />
    <link href="/site/css/main.scss.css?1743048451127" rel="stylesheet" type="text/css" media="all" />
    <link href="/site/css/paginate.scss.css?1743048451127" rel="stylesheet" type="text/css" media="all" />
    {{-- <link href="/site/css/quickviews_popup_cart.scss.css?1743048451127" rel="stylesheet" type="text/css"
        media="all" /> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="/site/css/callbutton.css?1743048451127" rel="stylesheet" type="text/css" media="all" />

    <script>
        (function() {
            function asyncLoad() {
                var urls = [];
                for (var i = 0; i < urls.length; i++) {
                    var s = document.createElement('script');
                    s.type = 'text/javascript';
                    s.async = true;
                    s.src = urls[i];
                    var x = document.getElementsByTagName('script')[0];
                    x.parentNode.insertBefore(s, x);
                }
            };
            window.attachEvent ? window.attachEvent('onload', asyncLoad) : window.addEventListener('load', asyncLoad,
                false);
        })();
    </script>

    @yield('css')

    <!-- Angular Js -->
    <script src="{{ asset('libs/angularjs/angular.js?v=222222') }}"></script>
    <script src="{{ asset('libs/angularjs/angular-resource.js') }}"></script>
    <script src="{{ asset('libs/angularjs/sortable.js') }}"></script>
    <script src="{{ asset('libs/dnd/dnd.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.9/angular-sanitize.js"></script>
    <script src="{{ asset('libs/angularjs/select.js') }}"></script>
    <script src="{{ asset('js/angular.js') }}?version={{ env('APP_VERSION', '1') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    @stack('script')
    <script>
        app.controller('AppController', function($rootScope, $scope, cartItemSync, $interval, $compile) {
            $scope.currentUser = @json(Auth::guard('client')->user());
            $scope.isAdminClient = @json(Auth::guard('client')->check());
            // $scope.showMenuAdminClient = localStorage.getItem('showMenuAdminClient') ? localStorage.getItem('showMenuAdminClient') : false;

            // const currentUrl = window.location.href;
            // if (currentUrl != "{{ route('front.client-account') }}" && currentUrl != "{{ route('front.user-order') }}" && currentUrl != "{{ route('front.user-revenue') }}" && currentUrl != "{{ route('front.user-level') }}") {
            //     $scope.showMenuAdminClient = false;
            //     localStorage.removeItem('showMenuAdminClient');
            // }

            // $scope.changeMenuClient = function($event, url){
            //     $event.preventDefault();
            //     $scope.showMenuAdminClient = !$scope.showMenuAdminClient;
            //     if(url == '{{ route('front.user-order') }}' || url == '{{ route('front.user-revenue') }}' || url == '{{ route('front.user-level') }}') {
            //         $scope.showMenuAdminClient = true;
            //     }

            //     if($scope.showMenuAdminClient){
            //         localStorage.setItem('showMenuAdminClient', $scope.showMenuAdminClient);
            //         window.location.href = url;
            //     }else{
            //         localStorage.removeItem('showMenuAdminClient');
            //         window.location.href = '{{ route('front.home-page') }}';
            //     }
            // }

            // Biên dịch lại nội dung bên trong container
            var container = angular.element(document.getElementsByClassName('item_product_main'));
            $compile(container.contents())($scope);

            var popup = angular.element(document.getElementById('popup-cart-mobile'));
            $compile(popup.contents())($scope);

            // var quickView = angular.element(document.getElementById('quick-view-product'));
            // $compile(quickView.contents())($scope);

            // Đặt mua hàng
            $scope.hasItemInCart = false;
            $scope.cart = cartItemSync;
            $scope.item_qty = 1;
            $scope.quantity_quickview = 1;
            $scope.noti_product = {};

            $scope.addToCart = function(productId, quantity = 1) {
                url = "{{ route('cart.add.item', ['productId' => 'productId']) }}";
                url = url.replace('productId', productId);
                let item_qty = quantity;

                jQuery.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        'qty': parseInt(item_qty)
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
                            // toastr.success('Thao tác thành công !')
                            $scope.noti_product = response.noti_product;
                            $scope.$applyAsync();

                            $('#popup-cart-mobile').addClass('active');
                            $('.backdrop__body-backdrop___1rvky').addClass('active');
                            $('#quick-view-product.quickview-product').hide();
                        }
                    },
                    error: function() {
                        toastr.error('Thao tác thất bại !')
                    },
                    complete: function() {
                        $scope.$applyAsync();
                    }
                });
                // if ($scope.isAdminClient) {
                // } else {
                //     window.location.href = "{{ route('front.login-client') }}";
                // }
            }

            $scope.changeQty = function(qty, product_id) {
                updateCart(qty, product_id)
            }

            $scope.incrementQuantity = function(product) {
                product.quantity = Math.min(product.quantity + 1, 9999);
            };

            $scope.decrementQuantity = function(product) {
                product.quantity = Math.max(product.quantity - 1, 0);
            };

            function updateCart(qty, product_id) {
                jQuery.ajax({
                    type: 'POST',
                    url: "{{ route('cart.update.item') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        product_id: product_id,
                        qty: qty
                    },
                    success: function(response) {
                        if (response.success) {
                            $scope.items = response.items;
                            $scope.total = response.total;
                            $scope.total_qty = response.count;
                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function() {
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);

                            $scope.$applyAsync();
                        }
                    },
                    error: function(e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function() {
                        $scope.$applyAsync();
                    }
                });
            }

            // xóa item trong giỏ
            $scope.removeItem = function(product_id) {
                jQuery.ajax({
                    type: 'GET',
                    url: "{{ route('cart.remove.item') }}",
                    data: {
                        product_id: product_id
                    },
                    success: function(response) {
                        if (response.success) {
                            $scope.cart.items = response.items;
                            $scope.cart.count = Object.keys($scope.cart.items).length;
                            $scope.cart.totalCost = response.total;

                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function() {
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);

                            if ($scope.cart.count == 0) {
                                $scope.hasItemInCart = false;
                            }
                            $scope.$applyAsync();
                        }
                    },
                    error: function(e) {
                        jQuery.toast.error('Đã có lỗi xảy ra');
                    },
                    complete: function() {
                        $scope.$applyAsync();
                    }
                });
            }

            // Xem nhanh
            $scope.quickViewProduct = {};
            $scope.showQuickView = function(productId) {
                $.ajax({
                    url: "{{ route('front.get-product-quick-view') }}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        product_id: productId
                    },
                    success: function(response) {
                        $('#quick-view-product .quick-view-product').html(response.html);
                        var quickView = angular.element(document.getElementById(
                            'quick-view-product'));
                        $compile(quickView.contents())($scope);
                        $scope.$applyAsync();
                    },
                    error: function(e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function() {
                        $scope.$applyAsync();
                    }
                });
            }

            // Search product
            jQuery('#live-search').keyup(function() {
                var keyword = jQuery(this).val();
                jQuery.ajax({
                    type: 'post',
                    url: '{{ route('front.auto-search-complete') }}',
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        keyword: keyword
                    },
                    success: function(data) {
                        jQuery('.live-search-results').html(data.html);
                    }
                })
            });
        })
        app.factory('cartItemSync', function($interval) {
            var cart = {
                items: null,
                total: null
            };

            cart.items = @json($cartItems);
            cart.count = {{ $cartItems->sum('quantity') }};
            cart.total = {{ $totalPriceCart }};

            return cart;
        });

        @if (Session::has('token'))
            localStorage.setItem('{{ env('prefix') }}-token', "{{ Session::get('token') }}")
        @endif
        @if (Session::has('logout'))
            localStorage.removeItem('{{ env('prefix') }}-token');
        @endif
        var CSRF_TOKEN = "{{ csrf_token() }}";
        @if (Auth::guard('client')->check())
            const DEFAULT_CLIENT_USER = {
                id: "{{ Auth::guard('client')->user()->id }}",
                fullname: "{{ Auth::guard('client')->user()->name }}"
            };
        @else
            const DEFAULT_CLIENT_USER = null;
        @endif
    </script>
</head>

<body ng-app="App" ng-controller="AppController" ng-cloak>
    <div class="opacity_menu"></div>
    @include('site.partials.header')
    <div class="bg-home">
        @yield('content')
        @include('site.partials.footer')
        @include('site.partials.mobile_menu')
    </div>
    <link rel="preload" as="style" href="/site/css/ajaxcart.scss.css?1743048451127" type="text/css">
    <link href="/site/css/ajaxcart.scss.css?1743048451127" rel="stylesheet" type="text/css" media="all" />
    <div class="backdrop__body-backdrop___1rvky"></div>
    <div id="popup-cart-mobile" class="popup-cart-mobile">
        <div class="header-popcart">
            <div class="top-cart-header">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" height="682.66669pt" viewBox="-21 -21 682.66669 682.66669"
                        width="682.66669pt">
                        <path
                            d="m322.820312 387.933594 279.949219-307.273438 36.957031 33.671875-314.339843 345.023438-171.363281-162.902344 34.453124-36.238281zm297.492188-178.867188-38.988281 42.929688c5.660156 21.734375 8.675781 44.523437 8.675781 68.003906 0 148.875-121.125 270-270 270s-270-121.125-270-270 121.125-270 270-270c68.96875 0 131.96875 26.007812 179.746094 68.710938l33.707031-37.113282c-58.761719-52.738281-133.886719-81.597656-213.453125-81.597656-85.472656 0-165.835938 33.285156-226.273438 93.726562-60.441406 60.4375-93.726562 140.800782-93.726562 226.273438s33.285156 165.835938 93.726562 226.273438c60.4375 60.441406 140.800782 93.726562 226.273438 93.726562s165.835938-33.285156 226.273438-93.726562c60.441406-60.4375 93.726562-140.800782 93.726562-226.273438 0-38.46875-6.761719-75.890625-19.6875-110.933594zm0 0">
                        </path>
                    </svg>
                    Mua hàng thành công
                </span>
            </div>
            <div class="media-content bodycart-mobile">
                <div class="thumb-1x1">
                    <img ng-src="<% noti_product.product_image %>" alt="<% noti_product.product_name %>">
                </div>
                <div class="body_content">
                    <h4 class="product-title"><% noti_product.product_name %></h4>
                    <div class="product-new-price">
                        <b><% noti_product.product_price | number %>₫</b>
                    </div>
                </div>
            </div>
            <a class="noti-cart-count" href="javascript:void(0)" title="Giỏ hàng"> Giỏ hàng của bạn hiện có <span
                    class="count_item_pr"><% cart.count %></span> sản phẩm </a>
            <a title="Đóng" class="cart_btn-close iconclose">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                    x="0px" y="0px" viewBox="0 0 512.001 512.001" style="enable-background:new 0 0 512.001 512.001;"
                    xml:space="preserve">
                    <g>
                        <g>
                            <path
                                d="M284.286,256.002L506.143,34.144c7.811-7.811,7.811-20.475,0-28.285c-7.811-7.81-20.475-7.811-28.285,0L256,227.717    L34.143,5.859c-7.811-7.811-20.475-7.811-28.285,0c-7.81,7.811-7.811,20.475,0,28.285l221.857,221.857L5.858,477.859    c-7.811,7.811-7.811,20.475,0,28.285c3.905,3.905,9.024,5.857,14.143,5.857c5.119,0,10.237-1.952,14.143-5.857L256,284.287    l221.857,221.857c3.905,3.905,9.024,5.857,14.143,5.857s10.237-1.952,14.143-5.857c7.811-7.811,7.811-20.475,0-28.285    L284.286,256.002z">
                            </path>
                        </g>
                    </g>
                </svg>
            </a>
            <div class="bottom-action">
                <div class="cart_btn-close tocontinued">
                    Tiếp tục mua hàng
                </div>
                <a href="{{ route('cart.checkout') }}" class="checkout">
                    Thanh toán ngay
                </a>
            </div>
        </div>
    </div>
    <link rel="preload" as="script" href="/site/js/quickview.js?1743048451127" />
    <script src="/site/js/quickview.js?1743048451127" type="text/javascript"></script>
    <link rel="preload" as="script" href="/site/js/placeholdertypewriter.js?1743048451127" />
    <script src="/site/js/placeholdertypewriter.js?1743048451127" type="text/javascript"></script>
    <link rel="preload" as="script" href="/site/js/index.js?1743048451127" />
    <script src="/site/js/index.js?1743048451127" type="text/javascript"></script>
    <link rel="preload" as="script" href="/site/js/main.js?1743048451127" />
    <script src="/site/js/main.js?1743048451127" type="text/javascript"></script>
    <div id="popupCartModal" class="modal fade" role="dialog"></div>
    <div id="sidebar-all" class="d-none">
        <div class="sidebar-all-wrap-right container" data-type="wishlist">
            <div class="sidebar-all-wrap-right-main">
                <div class="sidebar-all-wrap-right-main-list row">
                </div>
            </div>
        </div>
    </div>
    <div style="visibility:hidden; position: absolute; z-index: -1; bottom: 0; left: 0;">
        <svg xmlns="http://www.w3.org/2000/svg">
            <symbol id="icon-quickview">
                <svg width="20" height="16" viewBox="0 0 20 16" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12.7 7.99995C12.7 9.49112 11.4912 10.7 10 10.7C8.50883 10.7 7.3 9.49112 7.3 7.99995C7.3 6.50878 8.50883 5.29995 10 5.29995C11.4912 5.29995 12.7 6.50878 12.7 7.99995Z"
                        stroke="var(--mainColor)" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path
                        d="M1 7.99995C2.44012 4.31233 5.80243 1.69995 10 1.69995C14.1976 1.69995 17.5599 4.31233 19 7.99995C17.5599 11.6876 14.1976 14.3 10 14.3C5.80243 14.3 2.44012 11.6876 1 7.99995Z"
                        stroke="var(--mainColor)" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </symbol>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg">
            <symbol id="icon-wishlist">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 20 18"
                    fill="none">
                    <path
                        d="M1.39174 9.25109C0.246485 6.09414 1.67809 2.07624 4.82753 1.21525C6.54541 0.64126 8.83588 1.21522 9.98114 2.9372C11.1264 1.21522 13.4169 0.64126 15.1347 1.21525C18.5705 2.36323 19.7158 6.09414 18.5705 9.25109C17.139 14.13 11.4127 17 9.98114 17C8.54957 16.713 3.10962 14.417 1.39174 9.25109Z"
                        stroke="var(--mainColor)" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </symbol>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg">
            <symbol id="icon-compare">
                <svg x="0" y="0" viewBox="0 0 459 459.648" style="enable-background:new 0 0 512 512">
                    <path xmlns="http://www.w3.org/2000/svg"
                        d="m416.324219 293.824219c0 26.507812-21.492188 48-48 48h-313.375l63.199219-63.199219-22.625-22.625-90.511719 90.511719c-6.246094 6.25-6.246094 16.375 0 22.625l90.511719 90.511719 22.625-22.625-63.199219-63.199219h313.375c44.160156-.054688 79.945312-35.839844 80-80v-64h-32zm0 0"
                        fill="#7B7B7B" data-original="#000000" style=""></path>
                    <path xmlns="http://www.w3.org/2000/svg"
                        d="m32.324219 165.824219c0-26.511719 21.488281-48 48-48h313.375l-63.199219 63.199219 22.625 22.625 90.511719-90.511719c6.246093-6.25 6.246093-16.375 0-22.625l-90.511719-90.511719-22.625 22.625 63.199219 63.199219h-313.375c-44.160157.050781-79.949219 35.839843-80 80v64h32zm0 0"
                        fill="#7B7B7B" data-original="#000000" style=""></path>
                </svg>
            </symbol>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg">
            <symbol id="icon-viewmore">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19 11" fill="none">
                    <path
                        d="M12.9764 9.08131C12.7355 9.31672 12.7355 9.70421 12.9764 9.93962C13.2096 10.1675 13.5821 10.1675 13.8153 9.93962L17.8089 6.03635C18.1099 5.74213 18.1099 5.25784 17.8089 4.96362L13.8153 1.06038C13.5821 0.832464 13.2096 0.832464 12.9764 1.06038C12.7355 1.29579 12.7355 1.68328 12.9764 1.91869L15.592 4.47507C15.7522 4.63172 15.6413 4.90386 15.4172 4.90386L1.34615 4.90385C1.01691 4.90385 0.75 5.17076 0.75 5.50001C0.75 5.82925 1.01691 6.09616 1.34615 6.09616L15.4172 6.09617C15.6413 6.09617 15.7522 6.36831 15.5919 6.52496L12.9764 9.08131Z"
                        fill="url(#paint0_linear_158_2937)" stroke="url(#paint1_linear_158_2937)"
                        stroke-width="0.5" />
                    <defs>
                        <linearGradient id="paint0_linear_158_2937" x1="9.5" y1="10" x2="9.5"
                            y2="0.999999" gradientUnits="userSpaceOnUse">
                            <stop offset="0.786458" stop-color="#3A529B" />
                        </linearGradient>
                    </defs>
                </svg>
            </symbol>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg">
            <symbol id="icon-cart">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 18 20"
                    fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M8.50001 1.75C6.98123 1.75 5.75001 2.98121 5.75001 4.5L5.75 8.83231C5.75 9.24652 5.41421 9.58231 5 9.58231C4.58579 9.58231 4.25 9.24652 4.25 8.8323L4.25001 4.49999C4.25001 2.15279 6.1528 0.25 8.50001 0.25H9.5C11.8472 0.25 13.75 2.15279 13.75 4.5V9C13.75 9.41421 13.4142 9.75 13 9.75C12.5858 9.75 12.25 9.41421 12.25 9V4.5C12.25 2.98122 11.0188 1.75 9.5 1.75H8.50001Z"
                        fill="var(--mainColor)" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0.365475 9.71565C-0.271948 7.07673 2.13363 4.83729 4.68971 5.25515C7.6749 5.74315 10.2539 5.75778 13.3285 5.25915C15.8862 4.84435 18.3012 7.08619 17.6626 9.7297L15.8987 17.0323C15.5134 18.6275 14.0839 19.75 12.4423 19.75H5.58922C3.94759 19.75 2.5181 18.6275 2.13279 17.0323L0.365475 9.71565ZM4.44771 6.7355C2.82223 6.46977 1.46793 7.89121 1.82354 9.36346L3.59085 16.6801C3.81308 17.6001 4.63848 18.25 5.58922 18.25H12.4423C13.393 18.25 14.2184 17.6001 14.4407 16.6801L16.2046 9.37751C16.5607 7.90333 15.2 6.47523 13.5686 6.73981C10.3323 7.26466 7.59048 7.24926 4.44771 6.7355Z"
                        fill="var(--mainColor)" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M6.35724 12.9114C6.36263 12.4972 6.70276 12.1658 7.11694 12.1712L11.0098 12.2219C11.424 12.2273 11.7553 12.5674 11.7499 12.9816C11.7446 13.3958 11.4044 13.7271 10.9902 13.7217L7.09742 13.6711C6.68324 13.6657 6.35185 13.3256 6.35724 12.9114Z"
                        fill="var(--mainColor)" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.08863 10.2501C9.5028 10.2555 9.83419 10.5956 9.8288 11.0098L9.77812 14.9026C9.77273 15.3168 9.4326 15.6482 9.01843 15.6428C8.60425 15.6374 8.27286 15.2972 8.27825 14.8831L8.32893 10.9902C8.33432 10.5761 8.67445 10.2447 9.08863 10.2501Z"
                        fill="var(--mainColor)" />
                </svg>
            </symbol>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg">
            <symbol id="icon-outsock">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 18 20"
                    fill="none">
                    <path
                        d="M5 8.83231L5.00001 4.49999C5.00001 2.567 6.56701 1 8.50001 1H9.5C11.433 1 13 2.567 13 4.5V5.66667V9"
                        stroke="var(--mainColor)" stroke-width="1.5" stroke-linecap="round" />
                    <path
                        d="M15.1693 16.8563C14.8656 18.1139 13.7381 19.0001 12.4419 19.0001H5.58885C4.29267 19.0001 3.16522 18.1139 2.86145 16.8563L1.09414 9.53967C0.59762 7.48409 2.47756 5.65365 4.56834 5.99544C7.63232 6.49632 10.2927 6.51134 13.4482 5.99959C15.5427 5.65991 17.4306 7.49487 16.9332 9.55372L16.0513 13.205"
                        stroke="var(--mainColor)" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M11.0003 12.9718L7.10742 12.9211" stroke="var(--mainColor)" stroke-width="1.5"
                        stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </symbol>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg">
            <symbol id="icon-settings">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 20 18"
                    fill="none">
                    <path d="M1 3H4" stroke="var(--mainColor)" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M1 15H4" stroke="var(--mainColor)" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M12 3L19 3" stroke="var(--mainColor)" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M12 15L19 15" stroke="var(--mainColor)" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M1 9H2.5H3.25M13 9H7" stroke="var(--mainColor)" stroke-width="1.5"
                        stroke-linecap="round" />
                    <rect x="6" y="1" width="4" height="4" rx="1.5" stroke="var(--mainColor)"
                        stroke-width="1.5" />
                    <rect x="6" y="13" width="4" height="4" rx="1.5" stroke="var(--mainColor)"
                        stroke-width="1.5" />
                    <rect x="15" y="7" width="4" height="4" rx="1.5" stroke="var(--mainColor)"
                        stroke-width="1.5" />
                </svg>
            </symbol>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg">
            <symbol id="icon-detail">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="12" viewBox="0 0 22 14"
                    fill="none">
                    <path
                        d="M2.01893 6.83862C4.49682 3.78685 7.34662 1.7 11 1.7V0.3C6.73344 0.3 3.52547 2.76213 0.932078 5.95615L2.01893 6.83862ZM11 1.7C14.6534 1.7 17.5032 3.78685 19.9811 6.83862L21.0679 5.95615C18.4745 2.76213 15.2666 0.3 11 0.3V1.7ZM19.9811 7.16138C17.5032 10.2131 14.6534 12.3 11 12.3V13.7C15.2666 13.7 18.4745 11.2379 21.0679 8.04385L19.9811 7.16138ZM11 12.3C7.34662 12.3 4.49682 10.2131 2.01893 7.16138L0.932078 8.04385C3.52547 11.2379 6.73344 13.7 11 13.7V12.3ZM19.9811 6.83862C20.0577 6.93295 20.0577 7.06705 19.9811 7.16138L21.0679 8.04385C21.562 7.43529 21.562 6.56471 21.0679 5.95615L19.9811 6.83862ZM0.932078 5.95615C0.437953 6.56471 0.437952 7.43529 0.932078 8.04385L2.01893 7.16138C1.94234 7.06705 1.94234 6.93295 2.01893 6.83862L0.932078 5.95615Z"
                        fill="var(--mainColor)" />
                    <path
                        d="M12.8 7C12.8 7.99411 11.9942 8.8 11 8.8V10.2C12.7674 10.2 14.2 8.76731 14.2 7H12.8ZM11 8.8C10.0059 8.8 9.20005 7.99411 9.20005 7H7.80005C7.80005 8.76731 9.23273 10.2 11 10.2V8.8ZM9.20005 7C9.20005 6.00589 10.0059 5.2 11 5.2V3.8C9.23273 3.8 7.80005 5.23269 7.80005 7H9.20005ZM11 5.2C11.9942 5.2 12.8 6.00589 12.8 7H14.2C14.2 5.23269 12.7674 3.8 11 3.8V5.2Z"
                        fill="var(--mainColor)" />
                </svg>
            </symbol>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg">
            <symbol id="icon-wishlist">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 20 18"
                    fill="none">
                    <path
                        d="M1.39174 9.25109C0.246485 6.09414 1.67809 2.07624 4.82753 1.21525C6.54541 0.64126 8.83588 1.21522 9.98114 2.9372C11.1264 1.21522 13.4169 0.64126 15.1347 1.21525C18.5705 2.36323 19.7158 6.09414 18.5705 9.25109C17.139 14.13 11.4127 17 9.98114 17C8.54957 16.713 3.10962 14.417 1.39174 9.25109Z"
                        stroke="var(--mainColor)" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </symbol>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg">
            <symbol id="icon-wishlist-active">
                <svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="m12 5.72c-2.624-4.517-10-3.198-10 2.461 0 3.725 4.345 7.727 9.303 12.54.194.189.446.283.697.283s.503-.094.697-.283c4.977-4.831 9.303-8.814 9.303-12.54 0-5.678-7.396-6.944-10-2.461z"
                        fill-rule="nonzero" />
                </svg>
            </symbol>
        </svg>
    </div>
    <div class="addThis_listSharing" style="display: none;">
        <div class="listSharing_action">
            <button type="button" class="addThis_close" data-dismiss="modal">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g stroke="none" stroke-width="1" fill-rule="evenodd">
                        <g transform="translate(-1341.000000, -90.000000)">
                            <g transform="translate(1341.000000, 90.000000)">
                                <polygon
                                    points="19 6.4 17.6 5 12 10.6 6.4 5 5 6.4 10.6 12 5 17.6 6.4 19 12 13.4 17.6 19 19 17.6 13.4 12">
                                </polygon>
                            </g>
                        </g>
                    </g>
                </svg>
            </button>
            <ul class="addThis_listing">
                <li class="addThis_item">
                    <a class="addThis_item--icon" href="tel:{{ str_replace(' ', '', $config->hotline) }}" rel="nofollow" aria-label="phone"
                        title="Gọi ngay cho chúng tôi">
                        <svg width="44" height="44" viewBox="0 0 44 44" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="22" cy="22" r="22" fill="url(#paint2_linear)" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M14.0087 9.35552C14.1581 9.40663 14.3885 9.52591 14.5208 9.61114C15.3315 10.148 17.5888 13.0324 18.3271 14.4726C18.7495 15.2949 18.8903 15.9041 18.758 16.3558C18.6214 16.8415 18.3953 17.0971 17.384 17.9109C16.9786 18.239 16.5988 18.5756 16.5391 18.6651C16.3855 18.8866 16.2617 19.3212 16.2617 19.628C16.266 20.3395 16.7269 21.6305 17.3328 22.6232C17.8021 23.3944 18.6428 24.3828 19.4749 25.1413C20.452 26.0361 21.314 26.6453 22.2869 27.1268C23.5372 27.7488 24.301 27.9064 24.86 27.6466C25.0008 27.5826 25.1501 27.4974 25.1971 27.4591C25.2397 27.4208 25.5683 27.0202 25.9268 26.5772C26.618 25.7079 26.7759 25.5674 27.2496 25.4055C27.8513 25.201 28.4657 25.2563 29.0844 25.5716C29.5538 25.8145 30.5779 26.4493 31.2393 26.9095C32.1098 27.5187 33.9703 29.0355 34.2221 29.3381C34.6658 29.8834 34.7427 30.5821 34.4439 31.3534C34.1281 32.1671 32.8992 33.6925 32.0415 34.3444C31.2649 34.9323 30.7145 35.1581 29.9891 35.1922C29.3917 35.222 29.1442 35.1709 28.3804 34.8556C22.3893 32.3887 17.6059 28.7075 13.8081 23.65C11.8239 21.0084 10.3134 18.2688 9.28067 15.427C8.67905 13.7696 8.64921 13.0495 9.14413 12.2017C9.35753 11.8438 10.2664 10.9575 10.9278 10.4633C12.0288 9.64524 12.5365 9.34273 12.9419 9.25754C13.2193 9.19787 13.7014 9.24473 14.0087 9.35552Z"
                                fill="white" />
                            <defs>
                                <linearGradient id="paint2_linear" x1="22" y1="-7.26346e-09" x2="22.1219"
                                    y2="40.5458" gradientUnits="userSpaceOnUse">
                                    <stop offset="50%" stop-color="#e8434c" />
                                    <stop offset="100%" stop-color="#d61114" />
                                </linearGradient>
                            </defs>
                        </svg>
                        <span class="tooltip-text">Gọi ngay cho chúng tôi</span>
                    </a>
                </li>
                <li class="addThis_item">
                    <a class="addThis_item--icon" href="{{ str_replace(' ', '', $config->zalo) }}" target="_blank" rel="nofollow noreferrer"
                        aria-label="zalo" title="Chat với chúng tôi qua Zalo">
                        <svg width="44" height="44" viewBox="0 0 44 44" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="22" cy="22" r="22" fill="url(#paint4_linear)" />
                            <g clip-path="url(#clip0)">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M15.274 34.0907C15.7773 34.0856 16.2805 34.0804 16.783 34.0804C16.7806 34.0636 16.7769 34.0479 16.7722 34.0333C16.777 34.0477 16.7808 34.0632 16.7832 34.0798C16.8978 34.0798 17.0124 34.0854 17.127 34.0965H25.4058C26.0934 34.0965 26.7809 34.0977 27.4684 34.0989C28.8434 34.1014 30.2185 34.1039 31.5935 34.0965H31.6222C33.5357 34.0798 35.0712 32.5722 35.0597 30.7209V27.4784C35.0597 27.4582 35.0612 27.4333 35.0628 27.4071C35.0676 27.3257 35.0731 27.2325 35.0368 27.2345C34.9337 27.2401 34.7711 27.2757 34.7138 27.3311C34.2744 27.6145 33.8483 27.924 33.4222 28.2335C32.57 28.8525 31.7179 29.4715 30.7592 29.8817C27.0284 31.0993 23.7287 31.157 20.2265 30.3385C20.0349 30.271 19.9436 30.2786 19.7816 30.292C19.6773 30.3007 19.5436 30.3118 19.3347 30.3068C19.3093 30.3077 19.2829 30.3085 19.2554 30.3093C18.9099 30.3197 18.4083 30.3348 17.8088 30.6877C16.4051 31.1034 14.5013 31.157 13.5175 31.0147C13.522 31.0245 13.5247 31.0329 13.5269 31.0407C13.5236 31.0341 13.5204 31.0275 13.5173 31.0208C13.5036 31.0059 13.4864 30.9927 13.4696 30.98C13.4163 30.9393 13.3684 30.9028 13.46 30.8268C13.4867 30.8102 13.5135 30.7929 13.5402 30.7757C13.5937 30.7412 13.6472 30.7067 13.7006 30.6771C14.4512 30.206 15.1559 29.6905 15.6199 28.9311C16.2508 28.1911 15.9584 27.9025 15.4009 27.3524L15.3799 27.3317C12.6639 24.6504 11.8647 21.8054 12.148 17.9785C12.486 15.8778 13.4829 14.0708 14.921 12.4967C15.7918 11.5433 16.8288 10.7729 17.9632 10.1299C17.9796 10.1198 17.9987 10.1116 18.0182 10.1032C18.0736 10.0793 18.1324 10.0541 18.1408 9.98023C18.1475 9.92191 18.0507 9.90264 18.0163 9.90264C17.3698 9.90264 16.7316 9.89705 16.0964 9.89148C14.8346 9.88043 13.5845 9.86947 12.3041 9.90265C10.465 9.95254 8.78889 11.1779 8.81925 13.3614C8.82689 17.2194 8.82435 21.0749 8.8218 24.9296C8.82053 26.8567 8.81925 28.7835 8.81925 30.7104C8.81925 32.5007 10.2344 34.0028 12.085 34.0749C13.1465 34.1125 14.2107 34.1016 15.274 34.0907ZM13.5888 31.1403C13.5935 31.1467 13.5983 31.153 13.6032 31.1594C13.7036 31.2455 13.8031 31.3325 13.9021 31.4202C13.8063 31.3312 13.7072 31.2423 13.6035 31.1533C13.5982 31.1487 13.5933 31.1444 13.5888 31.1403ZM16.5336 33.8108C16.4979 33.7885 16.4634 33.7649 16.4337 33.7362C16.4311 33.7358 16.4283 33.7352 16.4254 33.7345C16.4281 33.7371 16.4308 33.7397 16.4335 33.7423C16.4632 33.7683 16.4978 33.79 16.5336 33.8108Z"
                                    fill="white" />
                                <path
                                    d="M17.6768 21.6754C18.5419 21.6754 19.3555 21.6698 20.1633 21.6754C20.6159 21.6809 20.8623 21.8638 20.9081 22.213C20.9597 22.6509 20.6961 22.9447 20.2034 22.9502C19.2753 22.9613 18.3528 22.9558 17.4247 22.9558C17.1554 22.9558 16.8919 22.9669 16.6226 22.9502C16.2903 22.9336 15.9637 22.8671 15.8033 22.5345C15.6429 22.2019 15.7575 21.9026 15.9752 21.631C16.8575 20.5447 17.7455 19.4527 18.6336 18.3663C18.6851 18.2998 18.7367 18.2333 18.7883 18.1723C18.731 18.0781 18.6508 18.1224 18.582 18.1169C17.9633 18.1114 17.3388 18.1169 16.72 18.1114C16.5768 18.1114 16.4335 18.0947 16.296 18.067C15.9695 17.995 15.7689 17.679 15.8434 17.3686C15.895 17.158 16.0669 16.9862 16.2846 16.9363C16.4221 16.903 16.5653 16.8864 16.7085 16.8864C17.7284 16.8809 18.7539 16.8809 19.7737 16.8864C19.9571 16.8809 20.1347 16.903 20.3123 16.9474C20.7019 17.0749 20.868 17.4241 20.7133 17.7899C20.5758 18.1058 20.3581 18.3774 20.1404 18.649C19.3899 19.5747 18.6393 20.4948 17.8888 21.4093C17.8258 21.4814 17.7685 21.5534 17.6768 21.6754Z"
                                    fill="white" />
                                <path
                                    d="M24.3229 18.7604C24.4604 18.5886 24.6036 18.4279 24.8385 18.3835C25.2911 18.2948 25.7151 18.5775 25.7208 19.021C25.738 20.1295 25.7323 21.2381 25.7208 22.3467C25.7208 22.6349 25.526 22.8899 25.2453 22.973C24.9588 23.0783 24.6322 22.9952 24.4432 22.7568C24.3458 22.6404 24.3057 22.6183 24.1682 22.7236C23.6468 23.1338 23.0567 23.2058 22.4207 23.0063C21.4009 22.6848 20.9827 21.9143 20.8681 20.9776C20.7478 19.9632 21.0973 19.0986 22.0369 18.5664C22.816 18.1175 23.6067 18.1563 24.3229 18.7604ZM22.2947 20.7836C22.3061 21.0275 22.3863 21.2603 22.5353 21.4543C22.8447 21.8534 23.4348 21.9365 23.8531 21.6372C23.9218 21.5873 23.9848 21.5263 24.0421 21.4543C24.363 21.033 24.363 20.3402 24.0421 19.9189C23.8817 19.7027 23.6296 19.5752 23.3603 19.5697C22.7301 19.5309 22.289 20.002 22.2947 20.7836ZM28.2933 20.8168C28.2474 19.3923 29.2157 18.3281 30.5907 18.2893C32.0517 18.245 33.1174 19.1928 33.1632 20.5785C33.209 21.9808 32.321 22.973 30.9517 23.106C29.4563 23.2502 28.2704 22.2026 28.2933 20.8168ZM29.7313 20.6838C29.7199 20.961 29.8058 21.2326 29.9777 21.4598C30.2928 21.8589 30.8829 21.9365 31.2955 21.6261C31.3585 21.5818 31.41 21.5263 31.4616 21.4709C31.7939 21.0496 31.7939 20.3402 31.4673 19.9189C31.3069 19.7083 31.0548 19.5752 30.7855 19.5697C30.1668 19.5364 29.7313 19.991 29.7313 20.6838ZM27.7891 19.7138C27.7891 20.573 27.7948 21.4321 27.7891 22.2912C27.7948 22.6848 27.474 23.0118 27.0672 23.0229C26.9985 23.0229 26.924 23.0174 26.8552 23.0007C26.5688 22.9287 26.351 22.6349 26.351 22.2857V17.8791C26.351 17.6186 26.3453 17.3636 26.351 17.1031C26.3568 16.6763 26.6375 16.3992 27.0615 16.3992C27.4969 16.3936 27.7891 16.6708 27.7891 17.1142C27.7948 17.9789 27.7891 18.8491 27.7891 19.7138Z"
                                    fill="white" />
                                <path
                                    d="M22.2947 20.7828C22.289 20.0013 22.7302 19.5302 23.3547 19.5634C23.6239 19.5745 23.876 19.702 24.0364 19.9181C24.3573 20.3339 24.3573 21.0322 24.0364 21.4535C23.7271 21.8526 23.1369 21.9357 22.7187 21.6364C22.65 21.5865 22.5869 21.5255 22.5296 21.4535C22.3864 21.2595 22.3062 21.0267 22.2947 20.7828ZM29.7314 20.683C29.7314 19.9957 30.1668 19.5357 30.7856 19.569C31.0549 19.5745 31.307 19.7075 31.4674 19.9181C31.794 20.3394 31.794 21.0544 31.4617 21.4701C31.1408 21.8636 30.545 21.9302 30.1382 21.6198C30.0752 21.5754 30.0236 21.52 29.9778 21.459C29.8059 21.2318 29.7257 20.9602 29.7314 20.683Z"
                                    fill="#0068FF" />
                            </g>
                            <defs>
                                <linearGradient id="paint4_linear" x1="22" y1="0" x2="22"
                                    y2="44" gradientUnits="userSpaceOnUse">
                                    <stop offset="50%" stop-color="#3985f7" />
                                    <stop offset="100%" stop-color="#1272e8" />
                                </linearGradient>
                                <clipPath id="clip0">
                                    <rect width="26.3641" height="24.2" fill="white"
                                        transform="translate(8.78906 9.90234)" />
                                </clipPath>
                            </defs>
                        </svg>
                        <span class="tooltip-text">Chat với chúng tôi qua Zalo</span>
                    </a>
                </li>
                <li class="addThis_item">
                    <a class="addThis_item--icon" href="{{route('front.contact-us')}}" aria-label="Liên hệ" title="Thông tin cửa hàng">
                        <svg width="44" height="44" viewBox="0 0 44 44" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="22" cy="22" r="22" fill="url(#paint5_linear)" />
                            <path
                                d="M22 10C17.0374 10 13 13.7367 13 18.3297C13 24.0297 21.0541 32.3978 21.397 32.7512C21.7191 33.0832 22.2815 33.0826 22.603 32.7512C22.9459 32.3978 31 24.0297 31 18.3297C30.9999 13.7367 26.9626 10 22 10ZM22 22.5206C19.5032 22.5206 17.4719 20.6406 17.4719 18.3297C17.4719 16.0188 19.5032 14.1388 22 14.1388C24.4968 14.1388 26.528 16.0189 26.528 18.3297C26.528 20.6406 24.4968 22.5206 22 22.5206Z"
                                fill="white" />
                            <defs>
                                <linearGradient id="paint5_linear" x1="22" y1="0" x2="22"
                                    y2="44" gradientUnits="userSpaceOnUse">
                                    <stop offset="50%" stop-color="#70f3ff" />
                                    <stop offset="100%" stop-color="#00dcf0" />
                                </linearGradient>
                            </defs>
                        </svg>
                        <span class="tooltip-text">Thông tin cửa hàng</span>
                    </a>
                </li>
                <li class="addThis_item">
                    <a class="addThis_item--icon" href="mailto:{{ $config->email }}"
                        aria-label="email" title="Email">
                        <svg width="44" height="44" viewBox="0 0 44 44" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="22" cy="22" r="22" fill="url(#paint1_linear)"></circle>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.4589 11.6667H32.5414C33.1621 11.6667 33.6993 11.8861 34.153 12.3245C34.6062 12.7634 34.8332 13.2904 34.8332 13.9064C34.8332 14.6435 34.599 15.3481 34.1319 16.0197C33.6639 16.6914 33.0816 17.2655 32.3846 17.7413C30.0672 19.3131 28.3185 20.4998 27.1311 21.3061C26.4785 21.7489 25.9931 22.0787 25.6817 22.2905C25.6355 22.3222 25.5634 22.3723 25.4675 22.4396C25.3643 22.5117 25.2337 22.6037 25.0729 22.7174C24.7625 22.9368 24.5048 23.114 24.2994 23.2495C24.0938 23.3846 23.8457 23.5363 23.5545 23.7043C23.2631 23.8724 22.9887 23.9983 22.7309 24.0823C22.4731 24.1661 22.2344 24.2082 22.0148 24.2082H22.0006H21.9863C21.7667 24.2082 21.5281 24.1661 21.2702 24.0823C21.0125 23.9983 20.7378 23.8721 20.4466 23.7043C20.1552 23.5363 19.9068 23.385 19.7017 23.2495C19.4964 23.114 19.2386 22.9368 18.9284 22.7174C18.7672 22.6037 18.6366 22.5118 18.5334 22.4393L18.5233 22.4323C18.4325 22.3688 18.3638 22.3208 18.3195 22.2905C17.9197 22.0157 17.4354 21.6846 16.8739 21.3022C16.2152 20.8532 15.4486 20.3329 14.5671 19.7359C12.9342 18.6303 11.9554 17.9654 11.6308 17.7413C11.0388 17.3494 10.4802 16.8107 9.95513 16.1248C9.43011 15.4387 9.16748 14.8018 9.16748 14.214C9.16748 13.4864 9.36539 12.8796 9.76184 12.3944C10.158 11.9095 10.7234 11.6667 11.4589 11.6667ZM33.4002 19.2392C31.4494 20.5296 29.7913 21.6405 28.4258 22.5725L34.8324 28.8337V18.0213C34.4217 18.4695 33.9443 18.8752 33.4002 19.2392ZM9.1665 18.0214C9.58659 18.4788 10.0691 18.8848 10.6132 19.2393C12.6414 20.5863 14.2935 21.6952 15.5757 22.5701L9.1665 28.8335V18.0214ZM34.0421 30.8208C33.6172 31.1883 33.1173 31.3745 32.5403 31.3745H11.4578C10.8809 31.3745 10.3807 31.1883 9.95575 30.8208L17.2287 23.7122C17.4107 23.8399 17.5789 23.9592 17.7306 24.0679C18.2751 24.4597 18.7165 24.7654 19.0556 24.9845C19.3944 25.2041 19.8455 25.4279 20.4091 25.6564C20.9726 25.8853 21.4976 25.9993 21.9847 25.9993H21.9989H22.0132C22.5002 25.9993 23.0253 25.8852 23.5888 25.6564C24.152 25.4279 24.6032 25.2041 24.9423 24.9845C25.2814 24.7654 25.7231 24.4597 26.2672 24.0679C26.427 23.955 26.5961 23.8362 26.7705 23.7141L34.0421 30.8208Z"
                                fill="white"></path>
                            <defs>
                                <linearGradient id="paint1_linear" x1="22" y1="0" x2="22"
                                    y2="44" gradientUnits="userSpaceOnUse">
                                    <stop offset="50%" stop-color="#e8434c"></stop>
                                    <stop offset="100%" stop-color="#d61114"></stop>
                                </linearGradient>
                            </defs>
                        </svg>
                        <span class="tooltip-text">Email</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="addThis_iconContact">
        <div class="box-item item-contact">
            <div class="svgico">
                <svg width="34" height="35" viewBox="0 0 34 35" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M4.35522 31V25.416H5.41122V30.064H7.61122V31H4.35522ZM8.97509 26.216C8.76176 26.216 8.60709 26.168 8.51109 26.072C8.42043 25.976 8.37509 25.8533 8.37509 25.704V25.544C8.37509 25.3947 8.42043 25.272 8.51109 25.176C8.60709 25.08 8.76176 25.032 8.97509 25.032C9.18309 25.032 9.33509 25.08 9.43109 25.176C9.52709 25.272 9.57509 25.3947 9.57509 25.544V25.704C9.57509 25.8533 9.52709 25.976 9.43109 26.072C9.33509 26.168 9.18309 26.216 8.97509 26.216ZM8.46309 26.824H9.48709V31H8.46309V26.824ZM12.834 24.712L13.842 25.944L13.33 26.344L12.37 25.424L11.41 26.344L10.898 25.944L11.906 24.712H12.834ZM12.362 31.096C12.0527 31.096 11.7754 31.0453 11.53 30.944C11.29 30.8373 11.0847 30.6907 10.914 30.504C10.7487 30.312 10.6207 30.0827 10.53 29.816C10.4394 29.544 10.394 29.24 10.394 28.904C10.394 28.5733 10.4367 28.2747 10.522 28.008C10.6127 27.7413 10.7407 27.5147 10.906 27.328C11.0714 27.136 11.274 26.9893 11.514 26.888C11.754 26.7813 12.026 26.728 12.33 26.728C12.6554 26.728 12.938 26.784 13.178 26.896C13.418 27.008 13.6154 27.16 13.77 27.352C13.9247 27.544 14.0394 27.768 14.114 28.024C14.194 28.2747 14.234 28.544 14.234 28.832V29.168H11.458V29.272C11.458 29.576 11.5434 29.8213 11.714 30.008C11.8847 30.1893 12.138 30.28 12.474 30.28C12.73 30.28 12.938 30.2267 13.098 30.12C13.2634 30.0133 13.41 29.8773 13.538 29.712L14.09 30.328C13.9194 30.568 13.6847 30.7573 13.386 30.896C13.0927 31.0293 12.7514 31.096 12.362 31.096ZM12.346 27.496C12.074 27.496 11.858 27.5867 11.698 27.768C11.538 27.9493 11.458 28.184 11.458 28.472V28.536H13.17V28.464C13.17 28.176 13.098 27.944 12.954 27.768C12.8154 27.5867 12.6127 27.496 12.346 27.496ZM15.135 31V26.824H16.159V27.52H16.199C16.2843 27.296 16.4176 27.1093 16.599 26.96C16.7856 26.8053 17.0416 26.728 17.367 26.728C17.799 26.728 18.1296 26.8693 18.359 27.152C18.5883 27.4347 18.703 27.8373 18.703 28.36V31H17.679V28.464C17.679 28.1653 17.6256 27.9413 17.519 27.792C17.4123 27.6427 17.2363 27.568 16.991 27.568C16.8843 27.568 16.7803 27.584 16.679 27.616C16.583 27.6427 16.495 27.6853 16.415 27.744C16.3403 27.7973 16.279 27.8667 16.231 27.952C16.183 28.032 16.159 28.128 16.159 28.24V31H15.135ZM21.7287 25.08H22.7527V27.52H22.7927C22.8781 27.296 23.0114 27.1093 23.1927 26.96C23.3794 26.8053 23.6354 26.728 23.9607 26.728C24.3927 26.728 24.7234 26.8693 24.9527 27.152C25.1821 27.4347 25.2967 27.8373 25.2967 28.36V31H24.2727V28.464C24.2727 28.1653 24.2194 27.9413 24.1127 27.792C24.0061 27.6427 23.8301 27.568 23.5847 27.568C23.4781 27.568 23.3741 27.584 23.2727 27.616C23.1767 27.6427 23.0887 27.6853 23.0087 27.744C22.9341 27.7973 22.8727 27.8667 22.8247 27.952C22.7767 28.032 22.7527 28.128 22.7527 28.24V31H21.7287V25.08ZM28.5918 24.712L29.5998 25.944L29.0878 26.344L28.1278 25.424L27.1678 26.344L26.6558 25.944L27.6638 24.712H28.5918ZM28.1198 31.096C27.8105 31.096 27.5332 31.0453 27.2878 30.944C27.0478 30.8373 26.8425 30.6907 26.6718 30.504C26.5065 30.312 26.3785 30.0827 26.2878 29.816C26.1972 29.544 26.1518 29.24 26.1518 28.904C26.1518 28.5733 26.1945 28.2747 26.2798 28.008C26.3705 27.7413 26.4985 27.5147 26.6638 27.328C26.8292 27.136 27.0318 26.9893 27.2718 26.888C27.5118 26.7813 27.7838 26.728 28.0878 26.728C28.4132 26.728 28.6958 26.784 28.9358 26.896C29.1758 27.008 29.3732 27.16 29.5278 27.352C29.6825 27.544 29.7972 27.768 29.8718 28.024C29.9518 28.2747 29.9918 28.544 29.9918 28.832V29.168H27.2158V29.272C27.2158 29.576 27.3012 29.8213 27.4718 30.008C27.6425 30.1893 27.8958 30.28 28.2318 30.28C28.4878 30.28 28.6958 30.2267 28.8558 30.12C29.0212 30.0133 29.1678 29.8773 29.2958 29.712L29.8478 30.328C29.6772 30.568 29.4425 30.7573 29.1438 30.896C28.8505 31.0293 28.5092 31.096 28.1198 31.096ZM28.1038 27.496C27.8318 27.496 27.6158 27.5867 27.4558 27.768C27.2958 27.9493 27.2158 28.184 27.2158 28.472V28.536H28.9278V28.464C28.9278 28.176 28.8558 27.944 28.7118 27.768C28.5732 27.5867 28.3705 27.496 28.1038 27.496ZM28.1038 32.552C27.8958 32.552 27.7465 32.5067 27.6558 32.416C27.5705 32.3307 27.5278 32.2213 27.5278 32.088V31.912C27.5278 31.7787 27.5705 31.6667 27.6558 31.576C27.7465 31.4907 27.8958 31.448 28.1038 31.448C28.3118 31.448 28.4585 31.4907 28.5438 31.576C28.6345 31.6667 28.6798 31.7787 28.6798 31.912V32.088C28.6798 32.2213 28.6345 32.3307 28.5438 32.416C28.4585 32.5067 28.3118 32.552 28.1038 32.552Z">
                    </path>
                    <path
                        d="M27.2212 0H10.7532C9.76511 0 8.97461 0.834345 8.97461 1.82643V12.334C8.97461 13.3487 9.78701 14.1604 10.7532 14.1604H22.1051L24.6741 16.8211C24.7839 16.9338 24.9157 17.0015 25.0693 17.0015C25.3768 17.0015 25.6402 16.7535 25.6402 16.4153V14.1604H27.2212C28.2092 14.1604 28.9997 13.3261 28.9997 12.334V1.82643C28.9997 0.811779 28.1873 0 27.2212 0ZM13.2783 9.04195C12.378 9.04195 11.6315 8.2753 11.6315 7.35077C11.6315 6.42631 12.378 5.65966 13.2783 5.65966C14.1785 5.65966 14.925 6.42631 14.925 7.35077C14.925 8.2753 14.2005 9.04195 13.2783 9.04195ZM19.0531 9.04195C18.1528 9.04195 17.4062 8.2753 17.4062 7.35077C17.4062 6.42631 18.1528 5.65966 19.0531 5.65966C19.9533 5.65966 20.6998 6.42631 20.6998 7.35077C20.6998 8.2753 19.9533 9.04195 19.0531 9.04195ZM24.8059 9.04195C23.9056 9.04195 23.1591 8.2753 23.1591 7.35077C23.1591 6.42631 23.9056 5.65966 24.8059 5.65966C25.7061 5.65966 26.4526 6.42631 26.4526 7.35077C26.4526 8.2753 25.7061 9.04195 24.8059 9.04195Z">
                    </path>
                    <path
                        d="M7.9649 12.3782V8.79297H6.16437C5.52762 8.79297 5.00066 9.33418 5.00066 9.98807V16.8878C4.97869 17.5868 5.50564 18.128 6.16437 18.128H7.19637V19.6162C7.19637 19.8192 7.37202 19.9995 7.56964 19.9995C7.67944 19.9995 7.76727 19.9544 7.83312 19.8868L9.52385 18.1505H16.9894C17.6261 18.1505 18.1531 17.6094 18.1531 16.9555V15.2418H10.7535C9.2165 15.2418 7.9649 13.9566 7.9649 12.3782Z">
                    </path>
                </svg>
                <span class="svgico--close">
                    <svg viewBox="0 0 19 19" role="presentation">
                        <path
                            d="M9.1923882 8.39339828l7.7781745-7.7781746 1.4142136 1.41421357-7.7781746 7.77817459 7.7781746 7.77817456L16.9705627 19l-7.7781745-7.7781746L1.41421356 19 0 17.5857864l7.7781746-7.77817456L0 2.02943725 1.41421356.61522369 9.1923882 8.39339828z"
                            fill-rule="evenodd"></path>
                    </svg>
                </span>
            </div>
        </div>
    </div>
    <style>
        @media (max-width: 768px) {

            .addThis_iconContact,
            .livechat-mes {
                display: none !important;
            }
        }
    </style>
    <div id="azt-contact-footer-outer">
        <div id="azt-contact-footer">
            <a href="javascript:void(0)" class="mr_menu_toggle_mobile">
                <span>
                    <img src="/site/images/menu.png" alt="menu">
                    <span class="azt-contact-footer-btn-label">Menu</span>
                </span>
            </a>
            <a href="#">
                <span>
                    <img src="/site/images/map.png" alt="Map">
                    <span class="azt-contact-footer-btn-label">Map</span>
                </span>
            </a>
            <a id="azt-contact-footer-btn-center" href="tel:{{ str_replace(' ', '', $config->hotline) }}">
                <span class="azt-contact-footer-btn-center-icon">
                    <span class="phone-vr-circle-fill"></span>
                    <img src="/site/images/phone.png" alt="Call Now">
                </span>
                <span>
                    <span class="azt-contact-footer-btn-label">
                        <span>Call Now</span>
                    </span>
                </span>
            </a>
            <a href="{{ $config->facebook }}" target="_blank">
                <span>
                    <img src="/site/images/messenger-icon.png" alt="Messenger">
                    <span class="azt-contact-footer-btn-label">Messenger</span>
                </span>
            </a>
            <a href="https://zalo.me/{{ str_replace(' ', '', $config->zalo) }}" target="_blank">
                <span>
                    <img class="zalo-icon" src="/site/images/zalo.png" alt="Zalo">
                    <span class="azt-contact-footer-btn-label">Zalo</span>
                </span>
            </a>
        </div>
    </div>
    <script>
        $('.addThis_iconContact .item-contact,.addThis_listSharing .addThis_close').on('click', function(e) {
            if ($('.addThis_listSharing').hasClass('active')) {
                $('.addThis_listSharing').removeClass('active');
                $('.addThis_listSharing').fadeOut(150);
            } else {
                $('.addThis_listSharing').fadeIn(100);
                $('.addThis_listSharing').addClass('active');
            }
        });
        $('.mr_menu_toggle_mobile').on('click', function() {
            $('.opacity_menu').addClass('current');
            $('.header-nav').addClass('current');
            $('body').addClass('modal-open');
        })
        $('.img_hover_cart').click(function() {
            $('.cart-sidebar, .backdrop__body-backdrop___1rvky').addClass('active');
        });

        $(document).on('click', '.backdrop__body-backdrop___1rvky, .cart_btn-close', function() {
            $('.backdrop__body-backdrop___1rvky, .cart-sidebar, #popup-cart-desktop, .popup-cart-mobile, .search-wrap-popup')
                .removeClass('active');
            $('body').removeClass('search-active');
            return false;
        })
    </script>
    <a target="_blank" class="livechat-mes" href="{{ $config->facebook }}">
        <img src="/site/images/messenger.svg" alt="Messenger">
    </a>
</body>

</html>
