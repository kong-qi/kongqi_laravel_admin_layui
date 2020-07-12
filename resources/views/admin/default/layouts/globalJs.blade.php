<script>
    //图片上传全局地址
    var g_upload_url = '{{ admin_url('FileUpload','handle',['type'=>'upload']) }}';
    //文件空間
    var g_upload_place = '{{ admin_url('FileUpload','handle',['type'=>'list']) }}';

    //导入模板弹出全局地址
    var g_import_url = '{{ admin_url('Excel','index',['type'=>'import']) }}';

    //图标地址
    var g_icon_url = '{{ admin_url('FileUpload','handle',['type'=>'icon']) }}';

    //排序自动重载入表格数据
    var g_sort_reload=1;

    //當前
    var currentLayerIndex='';
</script>