layui.define(['layerOpen', 'request', 'utable', 'uploader', 'laydate', 'colorpicker','xmSelect'], function (exports) {
  var layerOpen = layui.layerOpen; //弹窗
  var req = layui.request;
  var layer = layui.layer;
  var table = layui.utable;//修改过的utable
  var uploader = layui.uploader;//上传
  var laydate = layui.laydate;
  var colorpicker = layui.colorpicker;
    var xmSelect=layui.xmSelect;//引入xmSelect,使用率蛮高
  var custormEvent = {
    openIframePost: function (url, postUrl, w, h, title, btn, tableNameId, callFun) {
      title = appLang.trans(title);
      layerOpen.edit(url, postUrl, {
        w: w,
        h: h,
        title: title,
        btn: btn || [appLang.trans('确定'), appLang.trans('取消')]
      }, callFun, tableNameId);
    },
    //确认框是否操作回调
    confirmDo: function (title, btn, yesFun) {
      title = appLang.trans(title);
      var btns = btn || [appLang.trans('确定'), appLang.trans('取消')];
      layer.confirm('<p style="text-align: center;color: #1E9FFF;font-weight: bold;font-size: 16px">' + title + '</p>', {
        closeBtn: false,
        title: false,
        btn: btns,
        btnAlign: 'c'
      }, function (index) {

        yesFun && yesFun(index)

      });
    },
    //点击弹出是否提交到POST url里面
    confirmPost: function (title, postUrl, data, btn, isReload, tableNameId, callFun) {
      tableNameId = tableNameId || 'LAY-list-table';
      data = data || {};
      var that = this;
      this.confirmDo(title, btn, function (index) {
        that.postData(postUrl, data, isReload, tableNameId, callFun, index)
      });
    },
    openIframe: function (w, h, title, url, callFun, btn) {
      title = appLang.trans(title);
      var config = {
        title: title,
        h: h,
        w: w
      };
      var yesFun = function (layero, index) {
        layer.close(index); //关闭弹层
      };
      if (callFun) {
        yesFun = callFun;
      }
      layerOpen.show(url, config, yesFun, btn);
    },

    viewImg: function (src) {
      layer.photos({
        photos: {
          "title": appLang.trans("查看")
          ,
          "data": [{
            "src": src
          }]
        },
        shade: 0.01,
        closeBtn: 1,
        anim: 5
      });
    },
    /**
     *
     * @param url  提交地址
     * @param data 数据
     * @param isReload 是否重载入表格列表刷新数据
     * @param tableNameId 表格ID
     * @param callFun 回调方法
     * @param index 弹窗layer index
     * @param updateEvent 执行的操作事件名称
     */
    postData: function (url, data, isReload, tableNameId, callFun, index, updateEvent) {
      tableNameId = tableNameId || 'LAY-list-table';

      req.post(url, data, function (res) {
        layer.msg(res.msg);


        if (isReload == 1) {

          if (res.code == 200) {
            table.reload('' + tableNameId + '');
            if (index) {
              layer.close(index); //关闭弹层
            }

          }

        }

        if (updateEvent == 'sort') {
          if (g_sort_reload == true) {
            callFun && callFun(res)
          }
        } else {
          callFun && callFun(res)
        }

      });
    }
  }

  //文件上传监听开启
  uploadListen();
  //文件空间开启
  uploadPlaceListen();

  //上传批量监听
  function uploadListen() {
    $('[ data-event="upload"]').each(function () {
      var thatObj = $(this).attr('id');
      var more = $(this).data('more');
      if (more == 1) {
        uploader.more("#" + thatObj);
      } else {
        uploader.one("#" + thatObj);
      }

    })
  }

  //文件空间
  function uploadPlaceListen() {
    $(document).on('click', '[data-event="uploadPlace"]', function () {

      var file_type = $(this).data('file_type');
      var is_more = $(this).data('more');
      var group_id = $(this).data('group_id');

      uploader.place($(this), file_type, is_more, group_id)
    })

  }

  //图标空间
  $(document).on('click', '[data-event="iconPlace"]', function () {
    uploader.icon($(this), 0)
  });

  $(document).on('click', '[data-event="link"]', function () {
    var url = $(this).data('url');
    if (url) {
      window.location.href = url;
    }
  });

  //提示关闭
  $(document).on('click','[data-dismiss="alert"]',function(){
    $(this).parents('.alert').remove();
  });

  //颜色选择器
  $('[ui-event="color"]').each(function () {
    //
    othis = $(this);
    var color_obj = othis.data('obj');
    var id = "#" + othis.attr('id');

    //标识符为选择
    colorpicker.render({
      elem: "#" + color_obj,
      color: othis.val()
      , done: function (color) {
        $(id).val(color);

      },
      change: function (color) {
        $(id).val(color);

      }
    });

  });


  $('[ui-event="datetime"]').each(function () {

    othis = $(this);
    var format = othis.data('format') || 'yyyy-MM-dd HH:mm:ss';
    var value = othis.val() || othis.data('value');
    var min = othis.data('min');
    var max = othis.data('max');
    var lang = othis.data('lang') || '';
    var set_config = othis.data('config');
    var range = othis.data('range');


    var config = {
      elem: this
      , trigger: 'click'
      , type: 'datetime',
      format: format,
      value: value || '',
      lang: lang
    }
    if (range) {
      config.range = true;
    }
    if (set_config) {
      config = $.extend({}, config, set_config);
    }
    if (min) {
      config.min = min;
    }
    if (max) {
      config.max = max;
    }

    laydate.render(config);

  })
  $('[ui-event="date"]').each(function () {

    othis = $(this);
    var format = othis.data('format') || 'yyyy-MM-dd';
    var value = othis.val() || othis.data('value');
    var min = othis.data('min');
    var max = othis.data('max');
    var set_config = othis.data('config');
    var lang = othis.data('lang') || '';
    var range = othis.data('range') || '';
    var config = {
      elem: this
      , trigger: 'click'
      , type: 'date',
      format: format,
      value: value || '',
      lang: lang
    }
    if (range) {
      config.range = true;
    }
    if (set_config) {
      config = $.extend({}, config, set_config);
    }
    if (min) {
      config.min = min;
    }
    if (max) {
      config.max = max;
    }

    laydate.render(config);

  });

    $('[ui-event="xmSelect"]').each(function () {
        othis = $(this);
        var height=othis.data('h') || '250px';
        var el=othis.attr('id');
        var data=(othis.data('data'));
        var toInput=othis.data('to');
        var xs_name=othis.data('bname') || 'name';
        var xs_id=othis.data('bid') || 'id';
        var lang=othis.data('lang') || 'cn';
        var tips=othis.data('tips') || 'cn';
        var initValue=othis.data('value');
        initValue=initValue.toString();
        var setConfig=othis.data('config');
        var more=othis.data('more');
        initValue=initValue.split(",");
        var callFun=othis.data('fun_name');

        var config={
            el: "#"+el,
            height: height,
            data: data,
            initValue: initValue,
            model: {
                label: {type: 'text'}
            },
            prop: {
                name:xs_name,
                value: xs_id
            },
            tips: appLang.trans('请选择')+tips,
            searchTips: tips,//搜索提示
            language: lang,//语言包
            filterable: true,//是否开启搜索
            //radio: true,//是否开启单选模式
            clickClose: !more,
            tree: {
                show: true,
                indent: 15,
                strict: false,
                expandedKeys: true
            },
            //重写搜索方法
            filterMethod: function (val, item, index, prop) {


                if (val == item[xs_name]) {//把value相同的搜索出来
                    return true;
                }
                if (item[xs_name].indexOf(val) != -1) {//名称中包含的搜索出来
                    return true;
                }

                return false;//不知道的就不管了
            },
            on: function (data) {
                var arr = data.arr;

                if(callFun  ){
                    window[callFun](arr,data);
                }

                if(more){
                    var ids=arr.map(function(item){
                        return item.id;
                    }).filter(function(item){
                        if( item){
                            return item
                        }
                    }).join(',');
                    $("#"+toInput).val(ids);
                }else{
                    $("#"+toInput).val(arr[0].id);
                }

            }
        };
        if(!more){
            config.radio=true;
        }
        config = $.extend({}, config, setConfig);
        var insXmSel = xmSelect.render(config);
    });

  collapse();

  //折叠
  function collapse() {
    $('[data-perform="panel-collapse"]').on('click', function () {
      //取得父级
      var parentObj = $(this).parents(".panel");
      parentObj.toggleClass('open');
      h = 'auto';
      if (parentObj.hasClass('open')) {
        parentObj.find('.layui-card-body').hide();
        var h = '0';
        $(this).find('i').addClass('layui-icon-addition');
        $(this).find('i').removeClass('layui-icon-subtraction');

        $(this).find('i').attr('title', '点击可展开');
      } else {

        parentObj.find('.layui-card-body').show().css({
          height: h
        })
        $(this).find('i').attr('title', '点击可关闭')

        $(this).find('i').addClass('layui-icon-subtraction');
        $(this).find('i').removeClass('layui-icon-addition');
      }

    })
  }


  //监听事件
  var ui_events = {
    //弹出信息
    msg: function (othis) {
      var title = othis.data('title');
      var text = othis.data('content');
      layer.open({
        title: title ? title : '提示',
        btnAlign: 'c'
        , content: text
      });
    },
    //图片参考
    viewImg: function (othis) {
      var src = othis.data('src');
      custormEvent.viewImg(src);
    },
    //打开layui iframe
    openIframe: function (othis) {
      var w = othis.data('w');
      var h = othis.data('h');
      var title = othis.data('title');
      var url = othis.data('url');

      yesFun = function (layero, index) {
        layer.close(index); //关闭弹层
      }
      custormEvent.openIframe(w, h, title, url, yesFun)

    },
    //打开提交编辑
    openIframePost: function (othis) {
      w = othis.data('w');
      h = othis.data('h');
      title = othis.data('title');
      url = othis.data('url');
      post_url = othis.data('post_url');
      var btn2 = othis.data('btn') || '';
      custormEvent.openIframePost(url, post_url, w, h, title, btn2);

    },
    //直接打开询问提交
    confirmPost: function (othis) {
      title = othis.data('title');
      post_url = othis.data('post_url');
      var btn2 = othis.data('btn') || '';
      custormEvent.confirmPost(title, post_url, {}, btn2, 1);
    },
    //打开layui map
    openMap: function (othis) {
      var w = othis.data('w');
      var h = othis.data('h');
      var title = othis.data('title');
      var url = othis.data('url');
      var btn = othis.data('btn') || [appLang.trans('关闭')];
      var target=$(othis.data('target'));

      yesFun = function (layero, index) {
        var location=layero.find('iframe').contents().find("#pointInput").val();
        if(location){
          target.val(location);
        }else{
          layer.msg('请选择坐标');
          return false;
        }
        layer.close(index); //关闭弹层
      };

      custormEvent.openIframe(w, h, title, url, yesFun,btn)

    },

  };
  //点击事件
  $(document).on('click', '*[ui-event]', function () {
    var othis = $(this)
      , attrEvent = othis.attr('ui-event');
    ui_events[attrEvent] && ui_events[attrEvent].call(this, othis);
  });

  //删除
  $(document).on("click",".iupload-area-img-show-btn",function(){
    var pObj=$(this).parents(".upload-area");
    console.log(pObj);
    pObj.find(".iupload-area-img-show").addClass("none");
    pObj.find(".upload-area-input").val("");
    $(this).addClass("none");
  });
  exports('custormEvent', custormEvent);
});