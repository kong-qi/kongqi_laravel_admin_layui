@if(isset($index_handle_btn_number) && ($index_handle_btn_number)>0)

        <div class="mb-15 ">
            <div class="layui-btn-group">
                @if(!empty($index_handle_btn_tpl))
                    @foreach($index_handle_btn_tpl as $k=>$v)
                        @if(isset($v['custom']) && !empty($v['custom']))
                            {{--自定义模板--}}
                            @include('admin.default.'.$v['custorm'],['handle_btn_tpl'=>$v])
                        @else
                            @include('admin.default.tpl.form.button',['handle_btn_tpl'=>$v])
                        @endif

                    @endforeach
                @endif
            </div>
        </div>

@endif