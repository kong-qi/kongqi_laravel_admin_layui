@extends('plugin.layouts.baseCont')
@section('content')
    <form class="layui-form ui-form layui-form-block">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        @include('plugin.tpl.form.form')
    </form>

@endsection
@section('foot_js')
    {{-- //监听页面是否有编辑器加载--}}
    @include('plugin.tpl.listenEditorCreate')
    @if(isset($footAddJavascript) && !empty($footAddJavascript))
        @includeIf($footAddJavascript)
    @endif
@endsection