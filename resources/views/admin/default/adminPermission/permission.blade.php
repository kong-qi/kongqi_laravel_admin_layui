<div class="form-group">
    <label>{{ lang('权限分配') }}</label>
    <div class="form-control">
        @forelse($permissions as $first)
            <dl class="cate-box" style="border: 1px dotted #e2e2e2">
                <dt>
                    <div class="cate-first"><input id="menu{{$first['id']}}" type="checkbox" name="permissions[]"
                                                   value="{{$first['id']}}" title="{{$first['cn_name']}}"
                                                   lay-skin="primary" {{$first['own']??''}} ></div>
                </dt>
                @if(isset($first['_child']))
                    @foreach($first['_child'] as $second)
                        <dd>
                            <div class="cate-second"><input id="menu{{$first['id']}}-{{$second['id']}}" type="checkbox"
                                                            name="permissions[]" value="{{$second['id']}}"
                                                            title="{{$second['cn_name']}}"
                                                            lay-skin="primary" {{$second['own']??''}}></div>
                            @if(isset($second['_child']))
                                <div class="cate-third">
                                    @foreach($second['_child'] as $thild)
                                        <input type="checkbox"
                                               id="menu{{$first['id']}}-{{$second['id']}}-{{$thild['id']}}"
                                               name="permissions[]" value="{{$thild['id']}}"
                                               title="{{$thild['cn_name']}}"
                                               lay-skin="primary" {{$thild['own']??''}}>
                                    @endforeach
                                </div>
                            @endif
                        </dd>
                    @endforeach
                @endif
            </dl>
        @empty

            {{ lang('请添加权限规则') }}

        @endforelse
    </div>
</div>

