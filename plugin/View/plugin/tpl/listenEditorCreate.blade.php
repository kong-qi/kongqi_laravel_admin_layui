
@if(isset($editor_create))
    @if(!empty($editor_create))
        @php
            $editors=array_column($editor_create,'type');
            //过滤掉重复
            $editors=array_unique($editors);

        @endphp
        @foreach($editors as $k=>$v)
            @include('plugin.tpl.editor.'.$v)
        @endforeach
        @foreach($editor_create as $k=>$v)

            <script>
                {{$v['type']}}("{{ $v['id'] }}")
            </script>
        @endforeach
    @endif
@endif