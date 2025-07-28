@extends('site.layouts.master')
@section('title')
    Giỏ hàng
@endsection

@section('css')
    <link href="/site/css/breadcrumb.scss.css?1749442635129" rel="stylesheet" type="text/css" media="all" />
    <link href="/site/css/cart_style.scss.css?1749442635129" rel="stylesheet" type="text/css" media="all" />
@endsection

@section('content')
    <div class="breadcrumb">
        <div class="container">
            <ul>
                <li class="home">
                    <a href="{{ route('front.home-page') }}"><span>Trang chủ</span></a>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                        <path fill="#fff"
                            d="M342.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L274.7 256 105.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z">
                        </path>
                    </svg>
                </li>
                <li><strong><span>Giỏ hàng</span></strong></li>
            </ul>
        </div>
    </div>
    <section class="page-cart" ng-controller="CartController">
        <div class="container">
            <div class="wrap_background_aside">
                <h1>Giỏ hàng của bạn</h1>
                <div class="cart-page">
                    <div class="drawer__inner">
                        <div class="CartPageContainer">
                            <div class="cart-content">
                                <div class="cart-item d-flex" ng-repeat="item in cart.items">
                                    <img src="<% item.attributes.image %>" alt="<% item.name %>">
                                    <div class="item-details">
                                        <h3><a href="/san-pham/<% item.attributes.slug %>.html"><% item.name %></a></h3>
                                        <p class="variant-title" ng-repeat="attribute in item.attributes.attributes">
                                            <% attribute.name %>: <span class="value-roperties"><% attribute.value %></span>
                                        </p>
                                        <div class="qty-price align-items-center d-flex flex-wrap justify-content-between">
                                            <div class="ajaxcart__qty d-flex align-items-center">
                                                <button type="button"
                                                    class="ajaxcart__qty-adjust ajaxcart__qty--minus items-count"
                                                    ng-click="decrementQuantity(item); changeQty(item.quantity, item.id)"
                                                    data-id="<% item.id %>" aria-label="-"></button>
                                                <input type="text" ng-model="item.quantity"
                                                    ng-change="changeQty(item.quantity, item.id)"
                                                    class="ajaxcart__qty-num number-sidebar" maxlength="3"
                                                    value="<% item.quantity %>" min="0" data-id="<% item.id %>"
                                                    aria-label="quantity" pattern="[0-9]*">
                                                <button type="button"
                                                    class="ajaxcart__qty-adjust ajaxcart__qty--plus items-count"
                                                    ng-click="incrementQuantity(item); changeQty(item.quantity, item.id)"
                                                    data-id="<% item.id %>" aria-label="+"></button>
                                            </div>
                                            <p class="line-price"><% item.price | number %>₫</p>
                                        </div>
                                        <a class="remove-item-cart" href="javascript:;"
                                            ng-click="removeItem(item.id)">Xóa</a>
                                    </div>
                                </div>
                            </div>
                            <div class="cart-bottom">
                                <div class="cart-footer d-flex justify-content-end align-items-center">
                                    <div class="text-total">Tổng tiền:</div>
                                    <div class="total-price"><% cart.total | number %>₫</div>
                                </div>
                                <div class="cart__btn-proceed-checkout-dt"><button
                                        onclick="location.href='{{ route('front.home-page') }}'" type="button"
                                        class="cart-continue-shopping" id="btn-continue-shopping"
                                        title="Tiếp tục mua hàng">Tiếp tục mua hàng</button><button
                                        onclick="location.href='{{ route('cart.checkout') }}'" type="button"
                                        class="cart-checkout" id="btn-proceed-checkout" title="Thanh toán ngay">Thanh toán
                                        ngay</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        app.controller('CartController', function($scope, cartItemSync, $interval, $rootScope) {
            $scope.items = @json($cartCollection);
            Object.keys($scope.items).forEach(function(item) {
                $scope.items[item].selected = false;
            });
            $scope.total_selected = 0;
            $scope.total_qty = "{{ $total_qty }}";
            $scope.checkCart = true;
            $scope.cart_items_selected = [];

            $scope.countItem = Object.keys($scope.items).length;

            jQuery(document).ready(function() {
                if ($scope.total == 0) {
                    $scope.checkCart = false;
                    $scope.$applyAsync();
                }
            })

            $scope.selectAllItems = function() {
                $scope.total_selected = 0;
                $scope.cart_items_selected = [];
                Object.keys($scope.items).forEach(function(item) {
                    $scope.items[item].selected = $scope.selectAll;
                    if ($scope.items[item].selected) {
                        $scope.cart_items_selected.push($scope.items[item]);
                    } else {
                        $scope.cart_items_selected.splice($scope.cart_items_selected.indexOf($scope
                            .items[item].id), 1);
                    }
                });
                $scope.total_selected = $scope.cart_items_selected.reduce(function(total, item) {
                    return total + item.price * item.quantity;
                }, 0);
                $scope.$applyAsync();
            }

            $scope.selectItem = function(item) {
                const existingItemIndex = $scope.cart_items_selected.findIndex(selectedItem => selectedItem
                    .id === item.id);
                if (existingItemIndex == -1 && item.selected) {
                    $scope.cart_items_selected.push(item);
                } else {
                    $scope.cart_items_selected.splice(existingItemIndex, 1);
                }
                $scope.total_selected = $scope.cart_items_selected.reduce(function(total, item) {
                    return total + item.price * item.quantity;
                }, 0);

                let check = true;
                Object.keys($scope.items).forEach(function(item) {
                    if (!$scope.items[item].selected) {
                        check = false;
                        return;
                    }
                });
                $scope.selectAll = check;

                $scope.$applyAsync();
            }

            $scope.submitCart = function() {
                if ($scope.cart_items_selected.length == 0 || $scope.total_selected == 0) {
                    toastr.warning('Chọn sản phẩm thanh toán');
                    return;
                }
                localStorage.setItem('cart_items_selected', JSON.stringify($scope.cart_items_selected));
                localStorage.setItem('total_selected', $scope.total_selected);
                window.location.href = "{{ route('cart.checkout') }}";
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
                            $scope.total_selected = 0;
                            $scope.cart_items_selected = [];
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

            $scope.removeItem = function(product_id) {
                jQuery.ajax({
                    type: 'GET',
                    url: "{{ route('cart.remove.item') }}",
                    data: {
                        product_id: product_id
                    },
                    success: function(response) {
                        if (response.success) {
                            $scope.items = response.items;
                            $scope.total = response.total;
                            $scope.total_qty = response.count;
                            $scope.total_selected = 0;
                            $scope.cart_items_selected = [];
                            if ($scope.total == 0) {
                                $scope.checkCart = false;
                            }

                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function() {
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);

                            $scope.countItem = Object.keys($scope.items).length;

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
        });
    </script>
@endpush
