
        @forelse($permissions as $first)

            <dl class="cate-box card shadow mb-4" >
                <dt class="card-header ">
                    <div class="cate-first"><input id="menu{{$first['id']}}" type="checkbox" name="permissions[]"
                                                   value="{{$first['id']}}" title=" {{ lang($first['cn_name']) }} "
                                                   lay-skin="primary" {{$first['own']??''}} ></div>
                </dt>
                @if(isset($first['_child']))
                    @foreach($first['_child'] as $second)
                        <dd class="border-bottom">
                            <div class="cate-second"><input id="menu{{$first['id']}}-{{$second['id']}}" type="checkbox"
                                                            name="permissions[]" value="{{$second['id']}}"
                                                            title="{{ lang($second['cn_name']) }}"
                                                            lay-skin="primary" {{$second['own']??''}}></div>
                            @if(isset($second['_child']))
                                <div class="cate-third">
                                    @foreach($second['_child'] as $thild)
                                        <input type="checkbox"
                                               id="menu{{$first['id']}}-{{$second['id']}}-{{$thild['id']}}"
                                               name="permissions[]" value="{{$thild['id']}}"
                                               title="{{ lang($thild['cn_name']) }}"
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


