layui.define(['layer', 'request', 'utable', 'loader'], function (exports) {
  var $ = layui.$;
  var layer = layui.layer;
  var req = layui.request;
  var table = layui.utable;
  var loader = layui.loader;

  var layerOpen = {
    open: openLayer,
    edit: openEditLayer,
    show: openShow
  };

  function isMobile() {
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      return true;
    }
    return false;
  }

  function layuiPx(w, h) {
    var config = new Array();
    if (isMobile()) {
      var view_w = $(window).width();
      var view_h = $(window).height();

      config[0] = w;
      config[1] = h;

      if (w.indexOf('px') != -1) {
        h = h.replace(/px/g, "");
        //如果存在px单位则进行计算
        config[0] = (view_w * 90 / 100) + 'px';
        var mh = (h * view_h / 960);

        config[1] = (h * view_h / 960) + 'px';
        if (mh > 100) {
          config[0] = '100%';
          config[1] = '100%';
        }

      } else {
        config[0] = '100%';
        config[1] = '100%';
      }

    } else {
      config[0] = w;
      config[1] = h;
    }
    return config;

  }

  function openLayer(config, yesFun, susFuc, cacFun, endFun) {
    var btn = config.btn || [appLang.trans('提交'), appLang.trans('取消')];
    rep_px = layuiPx(config.w, config.h);

    currentLayerIndex = layer.open({

      type: config.type,
      title: config.title,
      content: config.url,
      area: [rep_px[0], rep_px[1]],
      btn: btn,
      btnAlign: 'c',
      yes: function (index, layero) {
        if (typeof(yesFun) == "function") {
          return yesFun(layero, index);
        }
      },
      btn2: function (index, layero) {

        if (typeof(cacFun) == "function") {
          return cacFun(layero, index);
        }
      },
      success: function (index, layero) {
        if (typeof(susFuc) == "function") {
          return susFuc(layero, index);
        }


      },
      cancel: function (index, layero) {

        if (typeof(cacFun) == "function") {
          return cacFun(layero, index);
        }
      },
      end: function () {
        if (typeof(endFun) == "function") {
          return endFun();
        }
      }
    });


  }

  /**
   * 编辑/添加页面监听Iframe 提交
   * @param url
   * @param post_url
   * @param config
   */
  function openEditLayer(url, post_url, config, callFun, tableNameId) {
    tableNameId = tableNameId || 'LAY-list-table';
    var default_config = {
      type: 2,
      btn: config.btn || [appLang.trans('提交'), appLang.trans('取消')],
      url: url,
      w: config.w,
      h: config.h,
      title: config.title
    }
    var configs = $.extend({}, default_config);


    openLayer(configs, function (layero, index) {
      var iframeWindow = window['layui-layer-iframe' + index],
        submit = layero.find('iframe').contents().find("#LAY-form-submit");

      //监听提交
      iframeWindow.layui.uform.on('submit(LAY-form-submit)', function (data) {
        submit.attr('disabled', true);
        var field = data.field; //获取提交的字段
        //如果存在fail这个字段，则不给提交，并弹出这个提示
        if (field.fail) {
          loader.close();
          submit.attr('disabled', false);
          layer.msg(field.fail);
          return false;
        }
        loader.show();// loader.show();
        req.post(post_url, field, function (res) {
          submit.attr('disabled', false);

          layer.msg(res.msg);

          if (res.code == 200) {
            //是否存在不刷新加载
            if (res.data.no_loading) {
              layer.close(index);
            } else {
              table.reload(tableNameId);
            }

            layer.close(index); //关闭弹层
          }
          callFun && callFun(res)
        }, function () {
          submit.attr('disabled', false);
          loader.close();
        }, function () {
          submit.attr('disabled', false);
          loader.close();
        })

      });

      submit.trigger('click');
    })
  }

  function openShow(url, config, yesFun, btn) {
    btn = btn || [appLang.trans('关闭')]
    var default_config = {
      type: 2,
      btn: btn,
      url: url,
      w: config.w,
      h: config.h,
      title: config.title
    }

    openLayer(default_config, yesFun)
  }

  exports('layerOpen', layerOpen);
})