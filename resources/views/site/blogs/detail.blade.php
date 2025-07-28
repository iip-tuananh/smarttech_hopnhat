@extends('site.layouts.master')
@section('title')
    {{ $blog_title }}
@endsection
@section('description')
    {{ strip_tags($blog->intro) }}
@endsection
@section('image')
    {{ $blog->image ? $blog->image->path : 'https://placehold.co/600x400' }}
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
                    <a href="{{ route('front.list-blog', $blog->category->slug) }}" title="Tin tức">
                        <span>Tin tức</span>
                    </a>
                </li>
                <li>
                    <strong>{{ $blog_title }}</strong>
                </li>
            </ul>
        </div>
    </section>
    <section class="blogpage">
        <div class="container layout-article">
                <article class="article-main">
                    <div class="row">
                        <div class="right-content col-lg-9 col-12">
                            <div class="bg-article">
                                <div class="article-details clearfix">
                                    <h1 class="title">{{ $blog_title }}</h1>
                                    <div class="posts">
                                        <div class="time-post">
                                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user"
                                                role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                class="svg-inline--fa fa-user fa-w-14">
                                                <path fill="currentColor"
                                                    d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"
                                                    class=""></path>
                                            </svg>
                                            <span>By Admin </span>
                                        </div>
                                        <div class="time-post f">
                                            <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="clock"
                                                role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                class="svg-inline--fa fa-clock fa-w-16">
                                                <path fill="currentColor"
                                                    d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm216 248c0 118.7-96.1 216-216 216-118.7 0-216-96.1-216-216 0-118.7 96.1-216 216-216 118.7 0 216 96.1 216 216zm-148.9 88.3l-81.2-59c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h14c6.6 0 12 5.4 12 12v146.3l70.5 51.3c5.4 3.9 6.5 11.4 2.6 16.8l-8.2 11.3c-3.9 5.3-11.4 6.5-16.8 2.6z"
                                                    class=""></path>
                                            </svg>
                                            <span>Ngày</span>
                                            {{ $blog->created_at->format('d/m/Y') }}
                                        </div>
                                    </div>
                                    <div class="rte">
                                        {!! $blog->body !!}
                                    </div>
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
                </article>
            </div>
        </div>
    </section>
@endsection

@push('script')
@endpush
