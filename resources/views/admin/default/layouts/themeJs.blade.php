<script src="{{ ___('admin/layui/layui.js',$res_version??'') }}"></script>
<script src="{{ ___('admin/jquery/jquery.min.js',$res_version??'') }}"></script>
<script>
    layui.config({
        v:"{{ env('APP_DEBUG')?time():config_cache_default('config.cache_version','1.0') }}",
        base: '{{ ___('admin/modules/') }}/' //你存放新模块的目录，注意，不是layui的模块目录
    }).use('cacheNav',function(){
      var cacheNav=layui.cacheNav;
      cacheNav.cacheName="admin_nav";//设置导航的缓存名称，如果多个后台应用，更改这个名称即可
    }).use('index');





</script>