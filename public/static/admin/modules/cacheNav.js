layui.define(function (exports) {

  var cacheNav = {
    //设置缓存
    set: function (key, text, href) {
      var cache_navs = localStorage.getItem("admin_navs");
      cache_navs = JSON.parse(cache_navs);
      cache_navs = cache_navs || {};

      cache_navs[key] = {
        title: text.replace(/(^\s*)|(\s*$)|'ဆ'/g, "") || '',
        href: href
      }
      localStorage.setItem("admin_navs", JSON.stringify(cache_navs));
      //后续再补充
      return localStorage.setItem("admin_on_nav", (key));

    },
    //取得
    get: function () {
      cache_navs = localStorage.getItem("admin_navs");
      cache_navs = JSON.parse(cache_navs);
      return cache_navs || {};
    },
    setOn: function (key) {
      return localStorage.setItem("admin_on_nav", (key));
    },
    getOn: function () {
      return localStorage.getItem("admin_on_nav");
    },
    deleteKey: function (key) {
      try {
        var navs = this.get();
        if (navs[key]) {
          //删除
          delete navs[key];
          //写入
          localStorage.setItem("admin_navs", JSON.stringify(navs));
        }
      } catch (e) {

      }


    },
    //
    clearAll: function () {
      localStorage.setItem("admin_navs", JSON.stringify({}));
    },
    //其他
    clearOther: function (key, text, href) {
      localStorage.setItem("admin_navs", JSON.stringify({}));
      cache_navs = {};
      this.set(key, text, href);
    }
  }
  exports('cacheNav', cacheNav);
});