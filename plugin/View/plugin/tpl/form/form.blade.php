@if(isset($form_tpl) && !empty($form_tpl))


    @if($form_tpl['is_group'])
        <div class="layui-card" style="box-shadow:none">
            <div class="layui-tab layui-tab-brief" lay-filter="form-tab">
                <ul class="layui-tab-title">
                    @foreach($form_tpl['data'] as $form_key=>$form_item)
                        <li class="{{ $form_key==0?'layui-this':'' }}">{{ $form_item['name'] }}</li>
                    @endforeach
                </ul>
                <div class="layui-tab-content">
                    @foreach($form_tpl['data'] as $form_key_t=>$form_item_t)
                        <div class="layui-tab-item {{ $form_key_t==0?'layui-show':'' }}">
                            @foreach($form_item_t['data'] as $form_key=>$form_item)
                                @if(isset($form_item['remove']) && $form_item['remove']==1)
                                    @continue
                                @endif
                                @include('plugin.tpl.form.formSwitchTpl',['form_tpl_item'=>$form_item])
                            @endforeach
                        </div>

                    @endforeach
                    <div class="line {{ $showSubmit??'none' }}"></div>
                    <div class="mt-35 text-center {{ $showSubmit??'none' }}">

                        <button class="layui-btn  " type="button" lay-submit=""
                                lay-filter="LAY-form-submit" id="LAY-form-submit">{{ lang('提交') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @else


        @foreach($form_tpl['data'] as $form_key=>$form_item)
            @if(isset($form_item['remove']) && $form_item['remove']==1)
                @continue
            @endif
            @include('plugin.tpl.form.formSwitchTpl',['form_tpl_item'=>$form_item])
        @endforeach
        <div class="line {{ $showSubmit??'none' }}"></div>
        <div class="mt-35 text-center {{ $showSubmit??'none' }}">
            <button class="layui-btn" type="button" lay-submit="" lay-filter="LAY-form-submit"
                    id="LAY-form-submit">{{ lang('提交') }}</button>
        </div>


    @endif

@endif
