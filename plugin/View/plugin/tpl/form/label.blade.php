@if(isset($form_item['name']) && !empty($form_item['name'])  )
<div class="layui-form-label">
    @if(isset($form_item['must']) && !empty($form_item['must']) )
        <strong class="layui-item-required">*</strong>
    @endif
    <span class="layui-item-text"> {{ $form_item['name'] }}</span>
    @if(isset($form_item['mark']) && !empty($form_item['mark']) )
        <span class="layui-item-mark">
           ({{ $form_item['mark'] }})
        </span>
    @endif
</div>
 @endif