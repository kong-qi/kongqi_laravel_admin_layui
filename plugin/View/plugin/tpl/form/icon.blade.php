<div class="open-icon" id="{{ md5($form_item['field']) }}">

        @php
            $form_item['type'] = 'hidden';
            $form_item['attr'] = $form_item['attr']. ' readonly';
            $form_item['addClass']= $form_item['addClass'].' upload-area-input';
        @endphp
        @include('admin.default.tpl.form.text',['form_item'=>$form_item])

    <div class="layui-inline iupload-area-img-show {{ ($form_item['value'] ? '' : 'd-none') }}">
        <i class="{{ $form_item['value'] }}"></i>
    </div>
    <div class="layui-inline">
        <button type="button" data-event="iconPlace" class="layui-btn layui-btn-primary"
                data-target="#{{( md5($form_item['field'])) }} "><i class="layui-icon layui-icon-theme"></i> {{ lang('选择图标') }}</button>
    </div>
</div>
