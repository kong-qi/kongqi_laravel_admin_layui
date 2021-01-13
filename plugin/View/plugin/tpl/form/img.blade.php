<div class="upload-area" id="{{ md5($form_item['field']) }}">
    @php

        $form_item['type'] = 'hidden';

    @endphp
    @include('plugin.tpl.form.text',['form_item'=>$form_item])
    <div class="mb-10">
        <img style="width:150px"  ui-event="showImg" src="{{ $form_item['value'] }}" class="iupload-area-img-show {{ $form_item['value']?'':'none' }}"  alt="">
        <button class="layui-btn layui-btn-white layui-btn-sm iupload-area-img-show-btn {{ $form_item['value']?'':'none' }}" type="button">删除</button>

    </div>

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