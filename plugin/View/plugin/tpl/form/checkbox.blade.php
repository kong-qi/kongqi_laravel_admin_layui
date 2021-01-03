<div class="checkbox-tips" data-tips="{{ $form_item['tips']??'' }}">
    @if( isset($form_item['data']) && !empty($form_item['data']))
        @foreach($form_item['data'] as $k=>$v)


            <input lay-filter="{{ $form_item['filter']??'' }}" type="checkbox"
                   name="{{ $form_item['field']??'' }}[]" {{  (in_array($v['id'],$form_item['value']) ? 'checked' : '') }}
                   lay-verify="{{ $form_item['verify']??'' }}" class=" {{ $form_item['addClass'] }}"
                   value="{{ $v['id'] }}"  {{ $form_item['attr']??'' }}
                   id="{{ $form_item['field'] }}{{ $v['id']??'' }}" title="{{ lang($v['name']) }}"
                   autocomplete="off">
        @endforeach
    @endif



</div>