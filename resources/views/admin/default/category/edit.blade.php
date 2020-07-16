@extends('admin.default.layouts.baseCont')
@section('content')
    <form class="layui-form ui-form">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        @include('admin.default.tpl.form.form')

    </form>
@endsection
@section('foot_js')
    <script>
      layui.use(['xmSelect'], function () {
        var xmSelect = layui.xmSelect;
        var data = @json($category);
        var insXmSel = xmSelect.render({
          el: '#menuEditParentSel',
          height: '250px',
          data: data,
          initValue: [{{ $show->parent_id }}],
          model: {label: {type: 'text'}},
          prop: {
            name: 'name',
            value: 'id'
          },
          tips: '请选择上级',
          searchTips: '请选择上级',
          language: '{{ env('LANG') }}',
          filterable: true,
          radio: true,
          clickClose: true,
          tree: {
            show: true,
            indent: 15,
            strict: false,
            expandedKeys: true
          },
          //重写搜索方法
          filterMethod: function (val, item, index, prop) {

            if (val == item.cn_name) {//把value相同的搜索出来
              return true;
            }
            if (item.cn_name.indexOf(val) != -1) {//名称中包含的搜索出来
              return true;
            }
            return false;//不知道的就不管了
          },
          on: function (data) {
            //arr:  当前多选已选中的数据
            var arr = data.arr;
            console.log(arr);
            $("#parent_id").val(arr[0].id)
          }
        });
      });

    </script>

@endsection