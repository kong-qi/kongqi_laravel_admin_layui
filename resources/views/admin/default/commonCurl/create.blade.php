@extends('admin.default.layouts.baseCont')
@section('content')

    <form class="layui-form layui-form-block">
       @include('admin.default.tpl.form.form')
    </form>

@endsection
@section('foot_js')
    {{-- //监听页面是否有编辑器加载--}}
    @include('admin.default.tpl.listenEditorCreate')

    @if(isset($footAddJavascript) && !empty($footAddJavascript))
        @includeIf($footAddJavascript)
    @endif

@endsection