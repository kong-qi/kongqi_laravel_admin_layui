
<select name="parent_id" class="layui-select">
    <option value="0">{{ lang('根级') }}</option>
    @if(!empty($permissions))
        @foreach($permissions as $perm)
            <option value="{{$perm['id']}}" {{ isset($permission->id) && $perm['id'] == $permission->parent_id ? 'selected' : '' }} >{{lang($perm['cn_name'])}}</option>
            @if(isset($perm['_child']))
                @foreach($perm['_child'] as $childs)
                    <option value="{{$childs['id']}}" {{ isset($show->id) && $childs['id'] == $show->parent_id ? 'selected' : '' }} >
                        ┗━━{{lang($childs['cn_name'])}}</option>
                    @if(isset($childs['_child']))
                        @foreach($childs['_child'] as $lastChilds)
                            <option value="{{$lastChilds['id']}}" {{ isset($show->id) && $lastChilds['id'] == $show->parent_id ? 'selected' : '' }} >
                                ┗━━━━{{lang($lastChilds['cn_name'])}}</option>
                        @endforeach
                    @endif
                @endforeach
            @endif
        @endforeach
    @endif
</select>

