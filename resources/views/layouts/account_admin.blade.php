<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | {{ $page }}</title>

    <link rel="stylesheet" href="{{ asset('assets/back/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link href="{{ asset('assets/back/vendor/fonts/circular-std/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/back/libs/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/back/vendor/fonts/fontawesome/css/fontawesome-all.css') }}">
</head>
<body>
    <div class="dashboard-main-wrapper">
        @include('account_admin.partials.header')
        @include('account_admin.partials.sidebar')

        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content">
                @include('flash::message')
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        @yield('content')
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            Copyright © {{ date('Y') }} {{ config('app.name') }} {{ config('app.version') }}. All rights reserved. Brewed <i class="fas fa-coffee"></i> in Nepal by <a href="https://cmbs.com.np" target="_blank">CMBS</a>.
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
    </div>
    <script src="{{ asset('assets/back/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/back/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('assets/back/vendor/slimscroll/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/back/libs/js/main-js.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/back/libs/css/select2.css') }}">
    <script src="{{ asset('assets/back/libs/js/select2.js') }}"></script>
    <script>
        $(".select2").select2({
            placeholder: "Please Select",
            allowClear:true,
        });
    </script>
    @yield('customScript')
</body>
</html>
