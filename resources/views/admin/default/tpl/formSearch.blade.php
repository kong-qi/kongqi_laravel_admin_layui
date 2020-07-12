<div class="layui-card shadow panel ">
    <div class="layui-card-header ">
        {{ lang('搜索') }}
        <div class="panel-action">
            <a href="#" data-perform="panel-collapse"><i title="点击可折叠"
                                                         class="layui-icon layui-icon-subtraction"></i></a>
        </div>
    </div>

    <div class="layui-card-body" id="collapseSearch">

        <div class="layui-form layui-form-pane layui-search-warp ">

            @if(isset($search_form_tpl) && !empty($search_form_tpl))
                @foreach($search_form_tpl as $form_key=>$form_item)
                    @include('admin.default.tpl.form.formSwitchTpl',['form_tpl_item'=>$form_item])
                @endforeach
            @endif


            <div class="layui-form-item">
                <div class="layui-input-block " style="margin-left: 0 " >
                    <button class="layui-btn layuiadmin-btn-admin" lay-submit lay-filter="LAY-list-search">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>
            </div>


        </div>

    </div>

</div>