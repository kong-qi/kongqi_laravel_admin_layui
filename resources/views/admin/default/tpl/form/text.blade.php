<input ui-event="{{ $form_item['event']??'' }}" {{ $form_item['attr']??'' }} type="{{ $form_item['type']??'text' }}"
       name="{{ $form_item['field']??'' }}" placeholder="{{ $form_item['tips']??'' }}" value="{{ $form_item['value'] }}"
       lay-verify="{{ $form_item['verify']??'' }}" class="layui-input {{ $form_item['addClass'] }}"
       id="input-{{ $form_item['id']??'' }}"
       autocomplete="off" />