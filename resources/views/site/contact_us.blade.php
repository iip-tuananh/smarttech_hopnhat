@extends('site.layouts.master')
@section('title')
    Liên hệ
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
    <link href="/site/css/contact_style.scss.css?1743048451127" rel="stylesheet" type="text/css" media="all" />

    <style>
        .error {
            color: red;
            font-size: 12px;
            margin-left: 10px;
        }

        .layout-contact .form-contact .group_contact input.has-error,
        .layout-contact .form-contact .group_contact textarea.has-error {
            border: 1px solid red;
            border-radius: 5px;
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
                    <strong>Liên hệ</strong>
                </li>
            </ul>
        </div>
    </section>
    <h1 class="title-head-contact a-left d-none">Liên hệ</h1>
    <div class="layout-contact" ng-controller="ContactUsController" ng-cloak>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div id="contact_map" class="map">
                        {!! $config->location !!}
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="contact">
                        <h4>{{ $config->web_title }}</h4>
                        <div class="time_work">
                            <div class="item">
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="map-marker-alt"
                                    role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"
                                    class="svg-inline--fa fa-map-marker-alt fa-w-12">
                                    <path fill="currentColor"
                                        d="M172.268 501.67C26.97 291.031 0 269.413 0 192 0 85.961 85.961 0 192 0s192 85.961 192 192c0 77.413-26.97 99.031-172.268 309.67-9.535 13.774-29.93 13.773-39.464 0zM192 272c44.183 0 80-35.817 80-80s-35.817-80-80-80-80 35.817-80 80 35.817 80 80 80z"
                                        class=""></path>
                                </svg>
                                <b>Địa chỉ:</b>

                                {{ $config->address_company }}

                            </div>
                            <div class="item">
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope"
                                    role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                    class="svg-inline--fa fa-envelope fa-w-16">
                                    <path fill="currentColor"
                                        d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"
                                        class=""></path>
                                </svg>
                                <b>Email:</b> <a href="mailto:{{ $config->email }}"
                                    title="{{ $config->email }}">{{ $config->email }}</a>
                            </div>
                            <div class="item">
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone-alt"
                                    role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                    class="svg-inline--fa fa-phone-alt fa-w-16">
                                    <path fill="currentColor"
                                        d="M497.39 361.8l-112-48a24 24 0 0 0-28 6.9l-49.6 60.6A370.66 370.66 0 0 1 130.6 204.11l60.6-49.6a23.94 23.94 0 0 0 6.9-28l-48-112A24.16 24.16 0 0 0 122.6.61l-104 24A24 24 0 0 0 0 48c0 256.5 207.9 464 464 464a24 24 0 0 0 23.4-18.6l24-104a24.29 24.29 0 0 0-14.01-27.6z"
                                        class=""></path>
                                </svg>
                                <b>Hotline:</b> <a class="fone" href="tel:{{ str_replace(' ', '', $config->hotline) }}"
                                    title="{{ $config->hotline }}">{{ $config->hotline }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-contact">
                        <h4>Liên hệ với chúng tôi</h4>
                        <span class="content-form">
                            Nếu bạn có thắc mắc gì, có thể gửi yêu cầu cho chúng tôi, và chúng tôi sẽ liên lạc lại với bạn
                            sớm nhất có thể .
                        </span>
                        <div id="pagelogin">
                            <form id="contact">
                                <div class="group_contact">
                                    <div class="form-group" style="margin-bottom: 10px;">
                                        <input placeholder="Họ và tên" type="text" class="form-control  form-control-lg"
                                            ng-class="{'has-error': errors && errors.your_name}" required
                                            ng-model="your_name" style="margin-bottom: 0px;">
                                        <div class="invalid-feedback d-block error" role="alert">
                                            <span ng-if="errors && errors.your_name">
                                                <% errors.your_name[0] %>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 10px;">
                                        <input placeholder="Email" type="email"
                                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required id="email1"
                                            class="form-control form-control-lg"
                                            ng-class="{'has-error': errors && errors.your_email}" ng-model="your_email"
                                            style="margin-bottom: 0px;">
                                        <div class="invalid-feedback d-block error" role="alert">
                                            <span ng-if="errors && errors.your_email">
                                                <% errors.your_email[0] %>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 10px;">
                                        <input type="number" placeholder="Điện thoại*"
                                            class="form-control form-control-lg" required
                                            ng-class="{'has-error': errors && errors.your_phone}" ng-model="your_phone"
                                            style="margin-bottom: 0px;">
                                        <div class="invalid-feedback d-block error" role="alert">
                                            <span ng-if="errors && errors.your_phone">
                                                <% errors.your_phone[0] %>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 10px;">
                                        <textarea placeholder="Nội dung" id="comment" class="form-control content-area form-control-lg" rows="5"
                                            ng-class="{'has-error': errors && errors.your_message}" ng-model="your_message" style="margin-bottom: 0px;"></textarea>
                                        <div class="invalid-feedback d-block error" role="alert">
                                            <span ng-if="errors && errors.your_message">
                                                <% errors.your_message[0] %>
                                            </span>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn-lienhe" ng-click="submitContact()"
                                        ng-disabled="loading">Gửi thông
                                        tin</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        app.controller('ContactUsController', function($scope, $http) {
            $scope.loading = false;
            $scope.errors = {};
            $scope.submitContact = function() {
                $scope.loading = true;
                let data = {
                    your_name: $scope.your_name,
                    your_email: $scope.your_email,
                    your_phone: $scope.your_phone,
                    your_message: $scope.your_message
                };
                jQuery.ajax({
                    url: '{{ route('front.post-contact') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Thao tác thành công !')
                        } else {
                            $scope.errors = response.errors;
                            toastr.error('Thao tác thất bại !')
                        }
                    },
                    error: function() {
                        toastr.error('Thao tác thất bại !')
                    },
                    complete: function() {
                        $scope.$applyAsync();
                        $scope.loading = false;
                    }
                });
            };
        });
    </script>
@endpush
