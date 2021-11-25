@extends('layouts.app')

@section('css')
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto:300,400,700&display=swap);

        body {
            font-family: "Roboto", sans-serif;
            background: #EFF1F3;
            min-height: 100vh;
            position: relative;
        }

        .section-50 {
            padding: 50px 0;
        }

        .m-b-50 {
            margin-bottom: 50px;
        }

        .dark-link {
            color: #333;
        }

        .heading-line {
            position: relative;
            padding-bottom: 5px;
        }

        .heading-line:after {
            content: "";
            height: 4px;
            width: 75px;
            background-color: #29B6F6;
            position: absolute;
            bottom: 0;
            left: 0;
        }

        .notification-ui_dd-content {
            margin-bottom: 30px;
        }

        .notification-list {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            padding: 20px;
            margin-bottom: 7px;
            background: #fff;
            -webkit-box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
        }

        .notification-list--unread {
            border-left: 2px solid #29B6F6;
        }

        .notification-list .notification-list_content {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }

        .notification-list .notification-list_content .notification-list_img img {
            height: 48px;
            width: 48px;
            border-radius: 50px;
            margin-right: 20px;
        }

        .notification-list .notification-list_content .notification-list_detail p {
            margin-bottom: 5px;
            margin-right: 5px;
            line-height: 1.2;
        }

        .notification-list .notification-list_feature-img img {
            height: 48px;
            width: 48px;
            border-radius: 5px;
            margin-left: 20px;
        }

    </style>
@endsection

@section('content')

    <section class="section-50">
        <div class="container">
            <h3 class="m-b-50 heading-line "> <i class="fa fa-bell text-muted"></i> {{ __('app.Notifications') }}</h3>

            <div class="notification-ui_dd-content">

                <div class="notification-list notification-list--unread">
                    <div class="notification-list_content">
                        <div class="notification-list_img">
                            <img src="{{ asset('assets/media/avatars/blank.png') }}" alt="user">
                        </div>
                        <div class="notification-list_detail">
                            <p><b>عنوان الاشعار</b> </p>
                            <p class="text-muted">بعض التفاصيل....</p>
                            <p class="text-muted"><small>منذ8 دقائق </small></p>
                        </div>
                    </div>
                    <div class="notification-list_feature-img">
                        <a href="#">عرض التفاصيل</a>
                    </div>
                </div>
                <div class="notification-list notification-list--unread">
                    <div class="notification-list_content">
                        <div class="notification-list_img">
                            <img src="{{ asset('assets/media/avatars/blank.png') }}" alt="user">
                        </div>
                        <div class="notification-list_detail">
                            <p><b>عنوان الاشعار</b> </p>
                            <p class="text-muted">بعض التفاصيل....</p>
                            <p class="text-muted"><small>منذ8 دقائق </small></p>
                        </div>
                    </div>
                    <div class="notification-list_feature-img">
                        <a href="#">عرض التفاصيل</a>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="#!" class="dark-link">{{ __('app.Load more activity') }}</a>
            </div>

        </div>
    </section>


@endsection
