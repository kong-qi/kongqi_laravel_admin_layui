<div class="layui-inline">
    @php
        $form_item['event'] = 'color';
        $form_item['type'] = 'text';
        $form_item['attr'] =$form_item['attr']. ' data-obj=color-input-'.$form_item['id'];
    @endphp
    @include('admin.default.tpl.form.text',['form_item'=>$form_item])
</div>

<div class="color-warp" style="left: -15px" id="color-input-{{ $form_item['id'] }}"></div>
