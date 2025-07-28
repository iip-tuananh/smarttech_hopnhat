@extends('site.layouts.master')
@section('title')
    {{ $cate_title }}
@endsection
@section('description')
    {{ $cate_des ?? '' }}
@endsection
@section('image')
    {{ url('' . $banners[0]->image->path) }}
@endsection

@section('css')
    <link href="/site/css/breadcrumb_style.scss.css?1743048451127" rel="stylesheet" type="text/css" media="all" />
    <link href="/site/css/blog_article_style.scss.css?1743048451127" rel="stylesheet" type="text/css" media="all" />
    <style>
        .text-limit-3-line {
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
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
                    <strong>{{ $cate_title }}</strong>
                </li>
            </ul>
        </div>
    </section>
    <div class="blog_wrapper layout-blog">
        <div class="container">
            <h1 class="title-page">{{ $cate_title }}</h1>
            <div class="row">
                <div class="right-content col-lg-9 col-12">
                    <div class="list-blogs">
                        <div class="row row-fix">
                            @foreach ($blogs as $blog)
                            <div class="col-12 col-md-6 col-lg-4 col-fix">
                                <div class="item-blog">
                                    <div class="block-thumb">
                                        <a class="thumb" href="{{ route('front.detail-blog', $blog->slug) }}"
                                            title="{{ $blog->name }}">
                                            <img class="lazyload"
                                                src="/site/images/lazy.png"
                                                data-src="{{ $blog->image ? $blog->image->path : 'https://placehold.co/600x400' }}" alt="{{ $blog->name }}">
                                        </a>
                                        <div class="time-post badge">
                                            {{ $blog->created_at->format('d/m/Y') }}
                                        </div>
                                    </div>
                                    <div class="block-content">
                                        <h3><a href="{{ route('front.detail-blog', $blog->slug) }}"
                                                title="{{ $blog->name }}">{{ $blog->name }}</a></h3>
                                        <div class="article-content">
                                            {!! $blog->intro !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="text-center">
                            <nav class="clearfix relative nav_pagi w_100 ">
                                {{$blogs->links()}}
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="blog_left_base col-lg-3 col-12">
                    @include('site.blogs.nav-blog', [
                        'categories' => $categories,
                        'productCategories' => $productCategories,
                        'newBlogs' => $newBlogs,
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
@endpush
