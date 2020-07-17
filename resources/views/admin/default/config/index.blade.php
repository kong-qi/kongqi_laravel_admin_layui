@extends('admin.default.layouts.baseCont')
@section('content')

        <form class="layui-form layui-form-block">
            @include('admin.default.tpl.form.form',['showSubmit'=>''])
        </form>


@endsection
@section('foot_js')
    {{--监听页面是否存在编辑器类，存在就加载它--}}
    @include('admin.default.tpl.listenEditorCreate')
    <script>

        layui.use(['uform', 'layer', 'request'], function () {
            var form = layui.uform;
            var req = layui.request;
            var layer = layui.layer;
            form.on('submit(LAY-form-submit)', function (obj) {
                req.post('{{ action($controller_name.'@store') }}', obj.field, function (res) {
                    layer.msg(res.msg);
                })

            });


        });
    </script>


@endsection