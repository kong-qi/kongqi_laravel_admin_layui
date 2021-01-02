layui.define(['uupload', 'layer', 'layerOpen'], function (exports) {
  var upload = layui.uupload;
  var $ = layui.$;
  var layer = layui.layer;
  var layerOpen = layui.layerOpen;

  var uploader = {
    one: uploadOne,
    more: uploadMore,
    place: uploadPlace,
    placeUpload: uploadPlaceUp,
    placeEdit: placeEdit,
    placeVideoEdit:placeVideoEdit,
    icon: iconPlace,
    fileApi:uploadOpenFileApi
  }

  /**
   * 上传接口
   * @param that 触发这个的对象
   * @param file_type 文件类型
   * @param accept_type 接受文件的类型
   * @param successFun 成功的回调
   * @param resFun 上传回调，不一定成功
   * @returns {*}
   */
  function uploadApi(that, file_type, accept_type, successFun, resFun) {
    //分组id
    var group_id = that.data('group_id') || 0;
    var upload_url = that.data('upload_url') || g_upload_url;//默认全局上传地址
    if (!upload_url) {
      upload_url = g_upload_url;
    }
    //上传设置存储类型
    var oss_type = that.data('oss_type') || 'local';

    var more = that.data('more');
    if (more == 1) {
      more = true
    } else {
      more = false;
    }

    //文件最大可允许上传的大小设置
    var size = that.data('size');
    if (size < 0) {
      size = 0;
    }
    //文件最大可允许上传的大小设置
    var number = that.data('number');
    if (number < 0) {
      number = 0;
    }

    return upload.render({
      elem: that,
      url: upload_url,
      size: size,//0（即不限制）
      number: number,//0（即不限制）
      data: {
        _token: $('[name="csrf-token"]').attr('content'),
        file_type: file_type,//文件类型
        group_id: group_id || 0,
        oss_type:oss_type
      },
      multiple: more,
      accept: accept_type,//接受文件上传的类型
      before: function (res,index,upload) {

      },
      done: function (res) {
        resFun && resFun(res);
        if (res.is_upload == 1) {
          successFun && successFun(res);
        } else {
          layer.msg(res.message);
        }

      },
      error:function (index,upload) {

      }
    });
  }


  function uploadPlaceUp(obj, accept_type) {
    var that = $(obj);
    //文件类型
    var file_type = that.data('file_type');
    //使用场景
    accept_type = accept_type || 'images';
    file_type = file_type || 'image';
    if (file_type != 'image') {
      accept_type = 'file';
    }
    //对象包含了自己设置上传接受类型，则走自己的设置
    if (that.data('accept_type')) {
      accept_type = that.data('accept_type');
    }
    var value_name = that.data('value_name');
    if (!value_name) {
      value_name = 'path';
    }

    return uploadApi(that, file_type, accept_type, function (res) {
      //找到父
      var html = '<div class="file-choose-list-item upload-area-more-item"' +
        'data-tmp_name="' + res.tmp_name + '"' +
        'data-size="' + res.size_px + '"' +
        'data-ext="' + res.ext + '" ' +
        'data-type="' + res.type + '"' +
        'data-path="' + res[value_name] + '" ' +
        'data-view_src="' + res.view_src + '" ' +
        'data-oss_type="' + res.oss_type + '" ' +
        'data-origin_path="' + res.origin_path + '">\n' +
        '    <div class="file-choose-list-item-img "  data-src="' + res.view_src + '" style="background-image: url(' + res.view_src + ') "></div>\n' +
        '<div class="file-choose-list-item-name">' + res.tmp_name + '</div>' +
        '<div class="file-choose-list-item-ck layui-form"><div class="layui-unselect layui-form-checkbox " lay-skin="primary"><i class="layui-icon layui-icon-ok"></i></div></div>' +
        '</div>';

      var parentObj = $(that.data("target"));
      parentObj.find('.file-choose-list').prepend(html);


    })

  };

  /**
   * 单文件上传
   * @param obj 触发对象ID
   * @param accept_type 可上传类型
   */
  function uploadOne(obj, accept_type) {
    var that = $(obj);
    //文件类型
    var file_type = that.data('file_type');
    var value_name = that.data('value_name');
    if (!value_name) {
      value_name = 'path';
    }
    //使用场景
    accept_type = accept_type || 'images';
    file_type = file_type || 'image';
    if (file_type != 'image') {
      accept_type = 'file';
    }
    //对象包含了自己设置上传接受类型，则走自己的设置
    if (that.data('accept_type')) {
      accept_type = that.data('accept_type');
    }
    //console.log("file_type",file_type);
    return uploadApi(that, file_type, accept_type, function (res) {

      //找到父
      var parentObj = $(that.data("target"));
      //找到图片显示区域
      parentObj.find(".iupload-area-img-show").removeClass('none').attr('src', res.view_src);
      parentObj.find(".iupload-area-img-show-btn").removeClass('none');
      if (file_type != 'image') {
        //如果是文件，则需要输出文件名
        parentObj.find(".iupload-area-img-show").next('p').remove();
        parentObj.find(".iupload-area-img-show").after('<p>' + res.tmp_name + '</p>');
      }
      //表单赋值
      parentObj.find(".upload-area-input").val(res[value_name]);

    })

  };

  function addInput(input_type){
    var add_input_html='';
    switch (input_type) {
      case 1:
        add_input_html=' <input type="text" name="json[0][title]" class="layui-input mb-10 js-title" placeholder="标题" id="">';

        break;
      case 2:
        add_input_html=' <input type="text" name="json[0][title]" class="layui-input mb-10 js-title" placeholder="标题" id="">';
        add_input_html+='<textarea name="json[0][content]" class="layui-textarea mb-10 js-content" id="" placeholder="长文本" cols="30" rows="5"></textarea>';

        break;
      case 3:
        add_input_html=' <input type="text" name="json[0][title]" class="layui-input mb-10 js-title" placeholder="标题" id="">';
        add_input_html+='<textarea name="json[0][content]" class="layui-textarea mb-10 js-content" id="" placeholder="长文本" cols="30" rows="5"></textarea>';

        add_input_html+='<input type="text" name="json[0][link]" class="layui-input mb-10 js-link" placeholder="链接" id="">';

        break;

    }
    return add_input_html;
  }
  /**
   * 多图上传
   * @param obj 触发对象ID
   * @param accept_type
   * @returns {*}
   */
  function uploadMore(obj, accept_type) {
    var that = $(obj);
    //文件类型
    var file_type = that.data('file_type');
    //使用场景
    accept_type = accept_type || 'images';
    file_type = file_type || 'image';
    if (file_type != 'image') {
      accept_type = 'file';
    }
    //对象包含了自己设置上传接受类型，则走自己的设置
    if (that.data('accept_type')) {
      accept_type = that.data('accept_type');
    }
    var value_name = that.data('value_name');
    if (!value_name) {
      value_name = 'path';
    }
    //表单增加类型
    var input_type = that.data('input_type') || 0;

    var add_input_html=addInput(input_type);

    //多图上传增加其他html表单内容




    return uploadApi(that, file_type, accept_type, function (res) {
      //找到父
      var html = '<div data-input_type="'+input_type+'" class="file-choose-list-item upload-area-more-item"' +
        'data-tmp_name="' + res.tmp_name + '"' +
        'data-size="' + res.size_px + '"' +
        'data-ext="' + res.ext + '" ' +
        'data-type="' + res.type + '"' +
        'data-path="' + res[value_name] + '" ' +
        'data-view_src="' + res.view_src + '" ' +
        'data-oss_type="' + res.oss_type + '" ' +
        'data-origin_path="' + res.origin_path + '">\n' +
        '    <div class="file-choose-list-item-img "  ui-event="viewImg" data-src="' + res.view_src + '" style="background-image: url(' + res.view_src + ') "></div>\n' +
        '    ' +add_input_html+
        '<div class="handle ">\n' +
        '        <button type="button" class="layui-btn layui-btn-primary layui-btn-sm js_left_pic" data-tips="tooltip" ' +
        'title="' + appLang.trans('左移') + '">\n' +
        '            <i class="layui-icon layui-icon-left"></i></button>\n' +
        '        <button type="button" class="layui-btn layui-btn-primary layui-btn-sm js_right_pic" data-tips="tooltip" title="' + appLang.trans('右移') + '">\n' +
        '            <i class="layui-icon layui-icon-right"></i></button>\n' +
        '<button type="button" class="layui-btn layui-btn-primary layui-btn-sm js_remove_pic" data-tips="tooltip" title="' + appLang.trans('移除') + '" >\n' +
        ' <i class="layui-icon layui-icon-delete"></i></button>\n' +
        '</div>\n' +
        '</div>';

      var parentObj = $(that.data("target"));
      parentObj.removeClass('none').find('.file-choose-list').append(html);
      //如果存在设置表单属性，则不自动计算
      if(!input_type){
        jsonThumbs(parentObj)
      }

    })

  };


  /**
   * 计算图片算出JSON数据复制给对象
   * @param parentObj
   */
  function jsonThumbs(parentObj) {
    //计算数据
    var items = [];
    parentObj.find(".upload-area-more-item").each(function () {
      var that = $(this);
      var path = that.data('path');
      var tmp_name = that.data('tmp_name')
      var ext = that.data('ext');
      var oss_type = that.data('oss_type');
      var view_src = that.data('view_src');
      var type = that.data('type');
      var origin_path = that.data('origin_path');
      //进行数据渲染
      items.push(
        {
          path: path,
          type: type,
          view_src: view_src,
          tmp_name: tmp_name,
          ext: ext,
          oss_type: oss_type,
          origin_path: origin_path
        })
    })

    var json = JSON.stringify(items);
    if (items.length <= 0) {
      json = '';
    }
    parentObj.find(" .upload-area-input").val(json ? (json) : '')
  }


  //左移
  $(document).on('click', '.js_left_pic', function (event) {

    var onthis = $(this).parents(".upload-area-more-item");
    var getup = $(this).parents(".upload-area-more-item").prev(".upload-area-more-item");

    if (getup.html() != null) {
      $(getup).before(onthis);
    }
    var parentObj = $(this).parents(".upload-area-more");

    if(!onthis.data('input_type')){
      jsonThumbs(parentObj);
    }


  });
  //下移动
  $(document).on('click', '.js_right_pic', function (event) {
    var onthis = $(this).parents(".upload-area-more-item");
    var getup = $(this).parents(".upload-area-more-item").next(".upload-area-more-item");

    if (getup.html() != null) {
      $(getup).after(onthis);
    }
    var parentObj = $(this).parents(".upload-area-more");
    if(!onthis.data('input_type')){
      jsonThumbs(parentObj);
    }

  });
  //删除
  $(document).on('click', '.js_remove_pic', function (event) {
    var onthis = $(this).parents(".upload-area-more-item");
    var parentObj = $(this).parents(".upload-area-more");
    layer.msg(appLang.trans('你确定要删除吗'), {
      time: 0,
      btn: [appLang.trans('删除'), appLang.trans('取消')], //按钮
      yes: function (index) {
        onthis.remove();
        layer.close(index);

        if(!onthis.data('input_type')){
          jsonThumbs(parentObj);
        }
      }
    });


  });

  /**
   * 图标库弹窗
   * @param that
   * @param is_more
   */
  function iconPlace(that, is_more) {
    var custorm_url = that.attr('place_url');
    if (custorm_url) {
      g_icon_url = custorm_url;
    }

    //空间时最大化
    try {
      if (parent.currentLayerIndex) {
        parent.layer.full(parent.currentLayerIndex)
      }
    } catch (e) {
    }


    uploadPlaceApi(g_icon_url, function (layero, index) {
      var items = layero.find('iframe').contents().find('.active');

      //如果不是多个
      var res = {
        icon: items.find('i').attr('class')
      };
      //找到父
      var parentObj = $(that.data("target"));
      parentObj.find(".iupload-area-img-show").removeClass('none').removeClass('d-none').empty();
      //如果是文件，则需要输出文件名
      //iupload-area-img-show
      parentObj.find(".iupload-area-img-show").append('<i class="' + res.icon + '"></i>');
      //表单赋值
      parentObj.find(".upload-area-input").val(res.icon);

      layer.close(index); //关闭弹层
    }, function () {
      try {
        ////空间时恢复大小设置
        if (parent.currentLayerIndex) {
          parent.layer.restore(parent.currentLayerIndex)
        }
      } catch (e) {

      }


    });
  }

  //编辑器文件库
  function placeEdit(callFun, file_type, is_more) {
    if (file_type == undefined) {
      file_type = '';
    }

    //打开图片空间
    var url = g_upload_place + '?is_more=' + is_more + '&file_type=' + file_type;
    //空间时最大化
    try {
      if (parent.currentLayerIndex) {
        parent.layer.full(parent.currentLayerIndex)
      }
    } catch (e) {
    }

    uploadPlaceApi(url, function (layero, index) {
      var items = layero.find('iframe').contents().find('.upload-area-more-item.active');
      if (is_more == 1) {
        var img = [];
        items.each(function () {
          var res = $(this).data();
          img.push(res);
        });
        //排序，先选的在前面
        img.sort(function (x, y) {
          return x.index - y.index
        });

        callFun && callFun(img);


      } else {
        callFun && callFun(items.data());
      }
      layer.close(index); //关闭弹层
    }, function () {
      //空间时最大化
      try {
        if (parent.currentLayerIndex) {
          parent.layer.restore(parent.currentLayerIndex)
        }
      } catch (e) {
      }
    });
  }

  //编辑器视频文件选择
  //编辑器文件库
  function placeVideoEdit(callFun) {
    //不支持多选
    var  is_more=0;
    var file_type='video';

    //打开图片空间
    var url = g_upload_place + '?is_more=' + is_more + '&file_type=' + file_type+'&editor_api=1';
    //空间时最大化
    try {
      if (parent.currentLayerIndex) {
        parent.layer.full(parent.currentLayerIndex)
      }
    } catch (e) {
    }

    uploadPlaceApi(url, function (layero, index) {


      callFun(layero,index,layer);

      //console.log(tabLi.index());

    }, function () {
      //空间时最大化
      try {
        if (parent.currentLayerIndex) {
          parent.layer.restore(parent.currentLayerIndex)
        }
      } catch (e) {
      }
    });
  }

  //文件库空间
  function uploadPlace(that, file_type, is_more, group_id) {
    if (file_type == undefined) {
      file_type = '';
    }
    if (group_id == undefined) {
      group_id = '';
    }
    var value_name = that.data('value_name');
    if (!value_name) {
      value_name = 'path';
    }


    var custorm_url = that.attr('place_url');
    if (custorm_url) {
      g_upload_place = custorm_url;
    }
    var oss_type = that.data('oss_type');
    if (!oss_type) {
      oss_type = 'local';
    }
    //oss_type驱动


    //打开图片空间
    var url = g_upload_place + '?is_more=' + is_more + '&file_type=' + file_type + '&group_id=' + group_id+'&oss_type='+oss_type;
    //空间时最大化
    try {
      if (parent.currentLayerIndex) {
        parent.layer.full(parent.currentLayerIndex)
      }
    } catch (e) {
    }

    //表单增加类型
    var input_type = that.data('input_type') || 0;

    var add_input_html=addInput(input_type);


    uploadPlaceApi(url, function (layero, index) {
      var items = layero.find('iframe').contents().find('.upload-area-more-item.active');
      if (is_more == 1) {
        var img = [];
        items.each(function () {
          var res = $(this).data();
          img.push(res);
          //找到父

        });
        //排序，先选的在前面
        img.sort(function (x, y) {
          return x.index - y.index
        });
        var html = '';
        for (var i in img) {
          var res = img[i];
          html += '<div data-input_type="'+input_type+'" class="file-choose-list-item upload-area-more-item"' +
            'data-tmp_name="' + res.tmp_name + '"' +
            'data-ext="' + res.ext + '" ' +
            'data-type="' + res.type + '"' +
            'data-path="' + res[value_name] + '" ' +
            'data-view_src="' + res.view_src + '" ' +
            'data-oss_type="' + res.oss_type + '" ' +
            'data-origin_path="' + res.origin_path + '">\n' +
            '    <div class="file-choose-list-item-img "  ui-event="viewImg" data-src="' + res.view_src + '" style="background-image: url(' + res.view_src + ') "></div>\n' +
            '    '+add_input_html+'<div class="handle ">\n' +
            '        <button type="button" class="layui-btn layui-btn-primary layui-btn-sm js_left_pic" data-tips="tooltip" ' +
            'title="' + appLang.trans('左移') + '">\n' +
            '            <i class="layui-icon layui-icon-left"></i></button>\n' +
            '        <button type="button" class="layui-btn layui-btn-primary layui-btn-sm js_right_pic" data-tips="tooltip" title="' + appLang.trans('右移') + '">\n' +
            '            <i class="layui-icon layui-icon-right"></i></button>\n' +
            '<button type="button" class="layui-btn layui-btn-primary layui-btn-sm js_remove_pic" data-tips="tooltip" title="' + appLang.trans('移除') + '" >\n' +
            ' <i class="layui-icon layui-icon-delete"></i></button>\n' +
            '</div>\n' +
            '</div>';
        }

        var parentObj = $(that.data("target"));
        parentObj.removeClass('none').find('.file-choose-list').append(html);
        //如果存在设置表单属性，则不自动计算
        if(!input_type){
          jsonThumbs(parentObj)
        }

      } else {
        //如果不是多个
        var res = $(items).data();
        //找到父
        var parentObj = $(that.data("target"));
        //找到图片显示区域
        parentObj.find(".iupload-area-img-show").removeClass('none').attr('src', res.view_src);
        parentObj.find(".iupload-area-img-show-btn").removeClass('none');
        if (res.type != 'image') {
          //如果是文件，则需要输出文件名
          parentObj.find(".iupload-area-img-show").next('p').remove();
          parentObj.find(".iupload-area-img-show").after('<p>' + res.tmp_name + '</p>');
        }
        //表单赋值
        parentObj.find(".upload-area-input").val(res[value_name]);
      }
      layer.close(index); //关闭弹层
    }, function () {
      //空间时最大化
      try {
        if (parent.currentLayerIndex) {
          parent.layer.restore(parent.currentLayerIndex)
        }
      } catch (e) {
      }
    });

  }

  function uploadPlaceApi(url, callFun, successFun) {
    //layer.full(parent.currentLayerIndex)
    layerOpen.open({
      title: appLang.trans('文件空间'),
      type: 2,
      url: url,
      w: '80%',
      h: '80%',
      btn: [appLang.trans('确定选择'), appLang.trans('关闭')]
    }, function (layero, index) {
      callFun && callFun(layero, index);

    }, function (layero, index) {

    }, function (layero, index) {
      successFun && successFun(layero, index);
    }, function (layero, index) {
      successFun && successFun(layero, index);
    })
  }


  function uploadOpenFileApi(type, is_more, file_type,group_id, callFun) {

    //打开图片空间
    var url = g_upload_place + '?is_more=' + is_more + '&file_type=' + file_type + '&group_id=' + group_id;
    //空间时最大化
    try {
      if (parent.currentLayerIndex) {
        parent.layer.full(parent.currentLayerIndex)
      }
    } catch (e) {
    }

    uploadPlaceApi(url, function (layero, index) {
      var item_img = layero.find('iframe').contents().find('.upload-area-more-item.active');

      var img_arr = [];
      if (is_more == 1) {
        item_img.each(function () {
          img_arr.push($(this).data());
        });

      } else {
        img_arr.push(item_img.data());
      }

      layer.close(index); //关闭弹层
      return callFun && callFun(img_arr);
    }, function () {
      //空间时最大化
      try {
        if (parent.currentLayerIndex) {
          parent.layer.restore(parent.currentLayerIndex)
        }
      } catch (e) {
      }
    });
  }

  exports('uploader', uploader);
})