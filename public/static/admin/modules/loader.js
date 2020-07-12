layui.define(function (exports) {
  var $ = layui.$;
  var load = {
    show: function (type) {
      $("body").append(this.getHtml(type));
      return this;
    },
    getHtml: function (type) {
      var html = '<div class="ui-loading" id="js-ui-loading"><div class="ui-ball-loader "><span></span><span></span><span></span><span></span></div></div>';
      return html;
    },
    close: function () {
      $("#js-ui-loading").remove();
    }
  };
  layui.link(layui.cache.base + 'loader/loader.css');  // 加载css
  exports('loader', load)
})