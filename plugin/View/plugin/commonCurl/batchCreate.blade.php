@extends('plugin.layouts.baseCont')
@section('content')

    <form class="layui-form layui-form-block">
        @include('plugin.tpl.form.form')
    </form>

@endsection
@section('foot_js')
    @if(isset($footAddJavascript) && !empty($footAddJavascript))
        @includeIf($footAddJavascript)
    @endif

@endsection