<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>
    <link rel="stylesheet" href="{{ asset('/assets/vendor/fonts/boxicons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/assets/vendor/css/core.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/assets/vendor/css/theme-default.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/assets/css/custom.css') }}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    @stack('styles')
</head>
<body style="margin:0;padding:0;overflow:hidden;">
    @yield('content')
    <script src="{{ asset('/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('/assets/vendor/js/bootstrap.js') }}"></script>
    @stack('script')
</body>
</html>
