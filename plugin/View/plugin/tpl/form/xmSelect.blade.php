@php
    $form_item['type'] = 'hidden';
@endphp
@include('admin.default.tpl.form.text',['form_item'=>$form_item])
<div id="form-{{ $form_item['id']??'' }}"
     data-more="{{ $form_item['more']??'0' }}"
     data-config="{{ json_encode($form_item['config']??[]) }}"
     data-value="{{ isset($form_item['selectValue'])?(is_array($form_item['selectValue'])?(implode(",",($form_item['selectValue']??[]))):$form_item['selectValue']):'' }}"
     {{ $form_item['attr']??'' }} data-tips="{{ $form_item['tips']??'' }}"
     data-data="{{ json_encode($form_item['data']) }}"
     data-to="input-{{ $form_item['id']??'' }}"
     ui-event="xmSelect" class="ew-xmselect-tree"></div>
