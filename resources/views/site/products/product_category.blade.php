@extends('site.layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('description')
    {{ $short_des }}
@endsection
@section('css')
    <link href="/site/css/breadcrumb_style.scss.css?1743048451127" rel="stylesheet" type="text/css" media="all" />
    <link href="/site/css/collection_style.scss.css?1743048451127" rel="stylesheet" type="text/css" media="all" />
@endsection

@section('content')
    <div class="layout-collection" ng-controller="ProductCategoryController">
        <section class="bread-crumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li class="home">
                        <a href="{{ route('front.home-page') }}" title="Trang chủ">
                            <span>Trang chủ</span>
                        </a>
                    </li>
                    <li>
                        <strong>
                            <span>{{ $title }}</span>
                        </strong>
                    </li>
                </ul>
            </div>
        </section>
        <div class="container">
            <div class="row">
                <aside class="dqdt-sidebar sidebar col-lg-3 col-12 padding-10">
                    <div class="aside-filter clearfix">
                        <div class="aside-hidden-mobile">
                            <div class="filter-container">
                                <div class="filter-containers">
                                    <div class="filter-container__selected-filter" style="display: none;">
                                        <div class="filter-container__selected-filter-header">
                                            <span class="filter-container__selected-filter-header-title">Bạn chọn</span>
                                            <a href="javascript:void(0)" onclick="clearAllFiltered()"
                                                class="filter-container__clear-all" title="Bỏ hết">Bỏ hết</a>
                                        </div>
                                        <div class="filter-container__selected-filter-list clearfix">
                                            <ul>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                @foreach ($attributes as $attribute)
                                    @if ($attribute->tags->count() > 0)
                                        <aside class="aside-item filter-tag-style-2 tag-size">
                                            <div class="aside-title">
                                                {{ $attribute->name }}
                                                <span class="nd-svg collapsible-plus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="5"
                                                        viewBox="0 0 10 5" fill="none">
                                                        <path
                                                            d="M0.993164 0.968199L5.0001 4.97514L9.00704 0.968201L8.06423 0.0253911L5.0001 3.08952L1.93597 0.0253906L0.993164 0.968199Z"
                                                            fill="#333333" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="aside-content filter-group">
                                                <ul>
                                                    @foreach ($attribute->tags as $tag)
                                                        <li class="filter-item filter-item--check-box filter-item--green">
                                                            <label for="filter-{{ $tag->code }}">
                                                                <input type="checkbox" id="filter-{{ $tag->code }}"
                                                                    ng-click="onChangeFilter({{ $tag->id }})"
                                                                    data-group="tag2" data-field="tags"
                                                                    data-text="{{ $tag->name }}"
                                                                    value="({{ $tag->code }})" data-operator="OR">
                                                                <i class="fa"></i>
                                                                {{ $tag->name }}
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </aside>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </aside>
                <div class="block-collection col-lg-9 col-12">
                    <div class="collection-title">
                        <h1 class="title-page">{{ $title }}</h1>
                        <div class="sortPagiBar clearfix">
                            <div class="sort-cate clearfix">
                                <div id="sort-by">
                                    <label class="left">Sắp xếp theo</label>
                                    <ul class="ul_col">
                                        <li>
                                            <span>
                                                Mặc định
                                            </span>
                                            <ul class="content_ul">
                                                <li><a href="javascript:;" ng-click="filterSort('default')">Mặc định</a>
                                                </li>
                                                <li><a href="javascript:;" ng-click="filterSort('alpha-asc')">A &rarr; Z</a>
                                                </li>
                                                <li><a href="javascript:;" ng-click="filterSort('alpha-desc')">Z &rarr;
                                                        A</a>
                                                </li>
                                                <li><a href="javascript:;" ng-click="filterSort('price-asc')">Giá tăng
                                                        dần</a>
                                                </li>
                                                <li><a href="javascript:;" ng-click="filterSort('price-desc')">Giá giảm
                                                        dần</a>
                                                </li>
                                                <li><a href="javascript:;" ng-click="filterSort('created-desc')">Hàng mới
                                                        nhất</a></li>
                                                <li><a href="javascript:;" ng-click="filterSort('created-asc')">Hàng cũ
                                                        nhất</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="category-products" id="product-list">
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
                                    {{ $products->links() }}
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="open-filters" class="open-filters d-lg-none d-xl-none">
                <i class="fa fa-filter"></i>
                <span>Lọc</span>
            </div>
        </div>
    </div>
    <div class="opacity_sidebar"></div>
    <script src="/site/js/col.js?1743048451127" type="text/javascript"></script>
@endsection

@push('script')
    <script>
        app.controller('ProductCategoryController', function($scope, $http) {
            $scope.category = @json($category ?? null);
            $scope.filter_sort = 'asc';
            $scope.filterSort = function(sort) {
                $scope.filter_sort = sort;
                $scope.filter();
            }
            $scope.filter_tag = [];
            $scope.onChangeFilter = function(id) {
                if ($scope.filter_tag.includes(id)) {
                    $scope.filter_tag = $scope.filter_tag.filter(function(item) {
                        return item !== id;
                    });
                } else {
                    $scope.filter_tag.push(id);
                }
                $scope.filter();
            }

            $scope.filter = function() {
                $.ajax({
                    url: '{{ route('front.filter-product') }}',
                    type: 'GET',
                    data: {
                        sort: $scope.filter_sort,
                        category: $scope.category.id,
                        cate_slug: $scope.category.slug,
                        tag: $scope.filter_tag,
                    },
                    success: function(response) {
                        $('#product-list').html(response.html);
                    },
                    error: function(response) {
                        console.log(response);
                    },
                    complete: function() {}
                });
            }

            $scope.filterCategory = function(slug) {
                url = '{{ route('front.show-product-category', ['categorySlug' => ':categorySlug']) }}'
                    .replace(
                        ':categorySlug', slug);
                window.location.href = url;
            }
        });
    </script>
@endpush
