<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <link rel="stylesheet" href="{{ asset('assets/back/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link href="{{ asset('assets/back/vendor/fonts/circular-std/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/back/libs/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/back/vendor/fonts/fontawesome/css/fontawesome-all.css') }}">
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
        }
    </style>
</head>
<body>
   <div class="splash-container">
       <div class="card ">
            @yield('content')
       </div>
   </div>

    <script src="{{ asset('assets/back/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/back/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
</body>
</html>
