<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @section('title')
        <title>{{ $title ?? config('copyright.system_name') }}</title>
        <meta name="keywords" content="{{ $keyword ?? config('copyright.system_name') }}">
        <meta name="description" content="{{ $description??config('copyright.system_name') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @show
    @include('lang.lang')
    @include('admin.default.layouts.globalJs')
    @section('theme_css')
        @include('admin.default.layouts.themeCss')
    @show
    @yield('add_css')
    @section('font_css')
    @show
</head>
@section('body')
    <body >
    @show
    @section('content-fluid')
        <div class="layui-fluid {{ $body_bg??'' }} " >
    @show

        @yield('content')
    @section('content-fluid-end')
        </div>
    @show

    @section('base_js')
        @include('admin.default.layouts.themeJs')
    @show

    @yield('foot_js')
    </body>
</html>