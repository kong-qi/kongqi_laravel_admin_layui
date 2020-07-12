@extends('admin.default.layouts.base')

@section('body')
    <body class="layui-layout-body">

    @endsection

    @section('content')
        <div id="LAY_app">
            <div class="layui-layout layui-layout-admin">
            @include('admin.default.layouts.top')
            @include('admin.default.layouts.sidebar')
            @include('admin.default.layouts.tab')

            <!-- 主体内容 -->
                <div class="layui-body" id="LAY_app_body">
                    <div class="layadmin-tabsbody-item layui-show">
                        <iframe src="{{ nroute('admin.home') }}" frameborder="0" class="layadmin-iframe"></iframe>
                    </div>
                </div>

                <!-- 辅助元素，一般用于移动设备下遮罩 -->
                <div class="layadmin-body-shade" layadmin-event="shade"></div>


            </div>

        </div>
@endsection



