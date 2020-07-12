<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @section('title')
        <title>{{ $title ?? '' }}</title>
        <meta name="keywords" content="{{ $keyword ??'' }}">
        <meta name="description" content="{{ $description??'' }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @show
    @section('theme_css')
        <link rel="stylesheet" href="{{ plugin_res('blog/css/bootstrap.min.css',$res_version??'') }}">
        <link rel="stylesheet" href="{{ plugin_res('blog/css/app.css',$res_version??'') }}">
    @show
    @yield('add_css')
</head>
<body>
@include('plugin.blog.front.layouts.header')
@yield('content')
@section('bss_js')
    <script src="{{ plugin_res('blog/js/jquery.min.js',$res_version??'') }}"></script>
    <script src="{{ plugin_res('blog/js/bootstrap.bundle.min.js',$res_version??'') }}"></script>
@show
@yield('foot_js')
</body>
</html>