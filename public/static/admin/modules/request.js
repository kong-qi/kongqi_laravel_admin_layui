layui.define(['layer', 'loader'], function (exports) {
  var $ = layui.jquery;
  var layer = layui.layer;
  var loader = layui.loader;
  var request = {
    /**
     *
     * @param url 提交地址
     * @param data 数据
     * @param success 成功回调
     * @param fail 失败回调
     * @param complete 完成回调
     * @param method 请求方式
     * @param header 请求头
     * @param async 是否异步
     * @param isLoding 是否需要加载条
     * @returns {*}
     */
    ajax: function ajax(url, data, success, fail, complete, method, header, async, isLoding) {
      data = data || {}
      header = header || {};
      method = method || 'post';
      async = async == 0 ? 0 : 1;
      data._token = $("[name='csrf-token']").attr('content');
      isLoding = isLoding == 0 ? 0 : 1;

      let headerObj = {};
      for (let i in header) {
        headerObj[i] = header[i];
      }
      if (isLoding) {
        loader.show();
      }

      $.ajax({
        data: data,
        headers: headerObj,
        async: async,    //表示请求是否异步处理
        type: method,    //请求类型
        url: url,//请求的 URL地址
        dataType: "json",//返回的数据类型
        success: function (res) {
          if (isLoding) {
            setTimeout(function () {
              loader.close();
            }, 500)
          }
          return success && success(res)
        },
        error: function (res) {
          if (isLoding) {
            setTimeout(function () {
              loader.close();
            }, 500)
          }
          return fail && fail(res)
        },
        complete(res) {

          return complete && complete(res)
        }
      });

    },
    get: function (url, data, success, fail, complete, header, async, isLoading) {

      if (isLoading == undefined) {
        isLoading = 1;
      }
      data = data || {};
      return this.ajax(url, data, success, fail, complete, 'get', header, async, isLoading);
    },
    post: function (url, data, success, fail, complete, header, async, isLoading) {

      if (isLoading == undefined) {
        isLoading = 1;
      }
      data = data || {};
      return this.ajax(url, data, success, fail, complete, 'post', header, async, isLoading);
    }

  };

  //输出接口
  exports('request', request);
});