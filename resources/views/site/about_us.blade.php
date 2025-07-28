@extends('site.layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('description')
    {{ $config->web_des }}
@endsection
@section('image')
    {{ url('' . $banners[0]->image->path) }}
@endsection

@section('css')
    <link href="/site/css/breadcrumb_style.scss.css?1743048451127" rel="stylesheet" type="text/css" media="all" />
    <link href="/site/css/style_page.scss.css?1743048451127" rel="stylesheet" type="text/css" media="all" />
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
                    <strong>{{ $title }}</strong>
                </li>
            </ul>
        </div>
    </section>
    <section class="page">
        <div class="container">
            <div class="pg_page">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title category-title">
                            <h1 class="title-head">{{ $title }}</h1>
                        </div>
                        <div class="content-page rte">
                            {!! $content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
@endpush
