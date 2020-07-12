@extends('admin.default.layouts.baseCont')
@section('content')
    <div class="main-warp">
        @include($base_blade_path.'.tpl.table')
    </div>
@endsection
@section('foot_js')
    @include($base_blade_path.'.tpl.listConfig')
    <script>
        layui.use(['listTable'], function () {
            var listTable = layui.listTable;
            var cols = @json($cols);

            //渲染
            listTable.render(listConfig.index_url, cols, {
                where: {
                    query_type: 1
                }
            });
            //监听搜索
            listTable.search();
            //开启排序
            listTable.sort();
        });
    </script>
@endsection