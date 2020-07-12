<div class="upload-area" >
    @php

        $form_item['type'] = 'hidden';

    @endphp

    <div class="mb-10 upload-area-more {{ (!isset($form_item['data']) && empty($form_item['data']))?'none':'' }}" id="{{ (md5($form_item['field'])) }}">
        @include('admin.default.tpl.form.text',['form_item'=>$form_item])
       <div class="file-choose-list">

           @if(!empty($form_item['data']))
                @foreach ($form_item['data'] as $k => $v)
               @php
                  $v['type'] = $v['type'] ?? '';
                  $v['origin_path'] = $v['origin_path'] ?? '';
               @endphp
            <div class="file-choose-list-item upload-area-more-item"
                 data-tmp_name="{{ ($v['tmp_name'] ?? '') }}"
                 data-ext="{{ ($v['ext'] ?? '') }}"
                 data-oss_type="{{ ($v['oss_type'] ?? '') }}"
                 data-path="{{ $v['path'] }}" data-view_src="{{ ($v['view_src'] ?? '') }}"
                  data-origin_path="{{ $v['origin_path'] }}">
                <div class="file-choose-list-item-img " ui-event="viewImg" data-src="{{ $v['view_src']??'' }}" style="background-image: url('{{ $v['view_src']??'' }}') ">

                </div>
                <div class=" handle ">
                    <button type="button" class="layui-btn layui-btn-primary layui-btn-sm js_left_pic" data-tips="tooltip" title="{{ lang('左移') }}" >
                        <i class="layui-icon layui-icon-left"></i></button>
                    <button type="button" class="layui-btn layui-btn-primary layui-btn-sm js_right_pic" data-tips="tooltip" title="{{ lang('右移') }}">
                        <i class="layui-icon layui-icon-right"></i></button>
                    <button type="button" class="layui-btn layui-btn-primary layui-btn-sm js_remove_pic" data-tips="tooltip" title="{{ lang('移除') }}" >
                        <i class="layui-icon layui-icon-delete"></i></button>
                </div>

            </div>
           @endforeach
            @endif
       </div>
    </div>

    <button type="button" {{ $form_item['up_attr']??'' }}
    {{ $form_item['up_attr']??'' }}
    id="upload{{ (md5($form_item['field'])) }}"
            data-target="#{{ (md5($form_item['field'])) }}"
            data-event="upload" data-more="1"
            class="layui-btn layui-btn-sm  mr-10"><i class="layui-icon layui-icon-add-1"></i> {{ lang('点击上传') }}</button>
    <button type="button" data-more="1"   data-event="uploadPlace"
            {{ $form_item['place_attr']??'' }}
            data-target="#{{ (md5($form_item['field']))  }}" class="layui-btn   layui-btn-sm"><i class="layui-icon layui-icon-picture"></i> {{ lang('库选择') }}</button>

</div>