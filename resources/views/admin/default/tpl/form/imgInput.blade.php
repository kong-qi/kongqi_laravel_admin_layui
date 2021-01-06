<div class="upload-area" id="{{ md5($form_item['field']) }}">
    <style>
        .w250{
            width: 250px !important;
        }
    </style>
    @php
        $form_item['type'] = 'text';
        $form_item['addClass']=$form_item['addClass'].' layui-input-inline w250'
    @endphp
    @include('admin.default.tpl.form.text',['form_item'=>$form_item])


    <div class="layui-btn-group">
        <button type="button" {{ $form_item['up_attr']??'' }}
        {{ $form_item['up_attr']??'' }}
        id="upload{{ (md5($form_item['field'])) }}"
                data-target="#{{ (md5($form_item['field'])) }}"
                data-event="upload" data-more="0"
                class="layui-btn layui-btn-sm  mr-10"><i class="layui-icon layui-icon-add-1"></i> {{ lang('点击上传') }}</button>
        <button type="button" data-more="0"   data-event="uploadPlace"
                {{ $form_item['place_attr']??'' }}
                data-target="#{{ (md5($form_item['field']))  }}" class="layui-btn   layui-btn-sm"><i class="layui-icon layui-icon-picture"></i> {{ lang('库选择') }}</button>

    </div>

</div>