<select lay-search ui-event="{{ $form_item['event']??'' }}" type="{{ $form_item['type']??'text' }}"
       name="{{ $form_item['field']??'' }}" data-tips="{{ $form_item['tips']??'' }}"
       lay-verify="{{ $form_item['verify']??'' }}" class="layui-input {{ $form_item['addClass'] }}"
       id="input-{{ $form_item['id']??'' }}" lay-filter="{{ $form_item['filter']??'' }}" {{ $form_item['attr']??'' }}
        autocomplete="off">
    @if( isset($form_item['data']) && !empty($form_item['data']))
            @foreach($form_item['data'] as $k=>$v)
               @php
                    $v['id'] = (string)$v['id'];
               @endphp
                <option value="{{ $v['id'] }}" {{ ($v['id'] == $form_item['value'] ? 'selected' : '') }}
                data-value="{{ $form_item['value'] }}">{{ lang($v['name']) }}</option>
            @endforeach
        @endif


</select>