<textarea ui-event="{{ $form_item['event']??'' }}" type="{{ $form_item['type']??'text' }}"
       name="{{ $form_item['field']??'' }}" placeholder="{{ $form_item['tips']??'' }}"
       lay-verify="{{ $form_item['verify']??'' }}"  class="layui-textarea {{ $form_item['addClass'] }}"
       id="input-{{ $form_item['id']??'' }}" {{ $form_item['attr']??'' }}
       rows="{{ $form_item['rows']??'5' }}"
          autocomplete="off">{{ $form_item['value'] }}</textarea>