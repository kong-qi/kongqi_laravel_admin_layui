@extends('admin.default.layouts.baseCont')
@section('content')
    <div class="main-warp">
        @include($base_blade_path.'.tpl.table')
    </div>
@endsection
@section('foot_js')
    @include($base_blade_path.'.tpl.listConfig')
    <script>
        //表格排序修改补刷新表格数据
        g_sort_reload=false;
        //树形table，不支持分页，不支持异步,异步这块后续再增加，暂时不加
        layui.use(['treeListTable',], function () {
            var treeListTable = layui.treeListTable;
            var cols = @json($cols);
            treeListTable.render(listConfig.index_url, cols,{treeDefaultClose:1});

        });
    </script>
@endsection