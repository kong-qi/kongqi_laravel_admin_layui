@if(isset($form_search_self) && $form_search_self==1)
    @include($origin_current_base_blade_path.'form')
@elseif($origin_current_base_blade_path==$current_base_blade_path && view()->exists($current_base_blade_path.'form'))
    @include($current_base_blade_path.'form')
@elseif($origin_current_base_blade_path==$current_base_blade_path)
    @include($base_blade_path.'.commonCurl.form')
@else
    @include($current_base_blade_path.'form')
@endif
@include('admin.default.tpl.indexTips')
<div class="layui-card panel">
    <div class="layui-card-header">{{ lang($page_name) }} {{ lang('列表') }}   <div class="panel-action"  >
            <a href="#" data-perform="panel-collapse"><i  title="点击可折叠" class="layui-icon layui-icon-subtraction"></i></a>
        </div></div>

    <div class="layui-card-body ">
        <table id="LAY-list-table" class="hide" style="display: none" lay-filter="LAY-list-table"></table>
    </div>

</div>