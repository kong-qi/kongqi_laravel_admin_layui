layui.define(function (exports) {

  var cacheNav = {
    cacheName:'admin_navs',
    //设置缓存
    set: function (key, text, href) {
      var cache_navs = localStorage.getItem(this.cacheName);
      cache_navs = JSON.parse(cache_navs);
      cache_navs = cache_navs || {};

      cache_navs[key] = {
        title: text.replace(/(^\s*)|(\s*$)|'ဆ'/g, "") || '',
        href: href
      }
      localStorage.setItem(this.cacheName, JSON.stringify(cache_navs));
      //后续再补充
      return localStorage.setItem(this.cacheName+"_on", (key));

    },
    //取得
    get: function () {
      cache_navs = localStorage.getItem(this.cacheName);
      cache_navs = JSON.parse(cache_navs);
      return cache_navs || {};
    },
    setOn: function (key) {
      return localStorage.setItem(this.cacheName+"_on", (key));
    },
    getOn: function () {
      return localStorage.getItem(this.cacheName+"_on");
    },
    deleteKey: function (key) {
      try {
        var navs = this.get();
        if (navs[key]) {
          //删除
          delete navs[key];
          //写入
          localStorage.setItem(this.cacheName, JSON.stringify(navs));
        }
      } catch (e) {

      }


    },
    //
    clearAll: function () {
      localStorage.setItem(this.cacheName, JSON.stringify({}));
    },
    //其他
    clearOther: function (key, text, href) {
      localStorage.setItem(this.cacheName, JSON.stringify({}));
      cache_navs = {};
      this.set(key, text, href);
    }
  }
  exports('cacheNav', cacheNav);
});