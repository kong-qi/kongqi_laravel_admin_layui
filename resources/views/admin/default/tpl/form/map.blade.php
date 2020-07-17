<input ui-event="{{ $form_item['event']??'' }}" {{ $form_item['attr']??'' }} type="{{ $form_item['type']??'text' }}"
       name="{{ $form_item['field']??'' }}" placeholder="{{ $form_item['tips']??'' }}" value="{{ $form_item['value'] }}"
       lay-verify="{{ $form_item['verify']??'' }}" class="layui-input {{ $form_item['addClass'] }} layui-input-inline"
       id="input-{{ $form_item['id']??'' }}"
       autocomplete="off" />
<div class="layui-btn-group">
<button data-target="#{{ "input-".$form_item['id'] }}" data-btn="选择" ui-event="openMap" data-w="80%" data-h="80%" data-title="百度坐标" data-url="{{ nroute('admin.map',['type'=>'baidu']) }}" class="layui-btn layui-btn" type="button">百度坐标选择器</button>
<button data-target="#{{ "input-".$form_item['id'] }}" data-btn="选择" ui-event="openMap" data-w="80%" data-h="80%" data-title="高德坐标" data-url="{{ nroute('admin.map',['type'=>'gaode']) }}" class="layui-btn layui-btn" type="button">高德坐标选择器</button><button data-target="#{{ "input-".$form_item['id'] }}" data-btn="选择" ui-event="openMap" data-w="80%" data-h="80%" data-title="腾讯坐标" data-url="{{ nroute('admin.map',['type'=>'tengXun']) }}" class="layui-btn layui-btn" type="button">腾讯坐标选择器</button>
</div>