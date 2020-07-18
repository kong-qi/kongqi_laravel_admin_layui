(function (factory) {
  /* global define */
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module.
    define(['jquery'], factory);
  } else if (typeof module === 'object' && module.exports) {
    // Node/CommonJS
    module.exports = factory(require('jquery'));
  } else {
    // Browser globals
    factory(window.jQuery);
  }
}(function ($) {
  // Extends plugins for adding hello.
  //  - plugin is external module for customizing.
  $.extend($.summernote.plugins, {
    /**
     * @param {Object} context - context object has status of editor.
     */
    'videolayui': function (context) {
      var self = this;

      // ui has renders to build ui elements.
      //  - you can create a button with `ui.button`
      var ui = $.summernote.ui;
      var options = context.options;
      var lang = options.langInfo;
      // add hello button
      context.memo('button.videolayui', function () {
        // create button
        var button = ui.button({
          contents: '<i class="layui-icon layui-icon-video">',
          tooltip: lang.image.image,
          click: function () {
            layui.use(['uploader'], function () {
              var uploader = layui.uploader;
              uploader.placeVideoEdit(function (layero,index,layer) {
                var currentTabIndex=layero.find('iframe').contents().find('.layui-tab-title .layui-this').index();
                var html='';

                switch (currentTabIndex) {
                  case 0:
                    html=layero.find('iframe').contents().find(".layui-video-coder").val();
                    break;
                  case 1:

                    var video_url=layero.find('iframe').contents().find(".layui-video-url").val();
                    var video_poster=layero.find('iframe').contents().find('[name="video_poster"]').val();
                    if(!video_poster){
                      return layer.msg(appLang.trans('请上传封面'));
                    }
                    if(!video_url){
                      return layer.msg(appLang.trans('请填写视频mp4地址'));
                    }
                    html='<video   src="'+video_url+'" poster="'+video_poster+'"  controls="controls" style="max-width: 100%"></video>';
                    break;
                  case 2:
                    var video_poster=layero.find('iframe').contents().find('[name="video_poster2"]').val();
                    if(!video_poster){
                      return layer.msg(appLang.trans('请上传封面'));
                    }
                    var items=layero.find('iframe').contents().find('.upload-area-more-item.active');
                    video_url=items.data('path');
                    if(!video_url){
                      return layer.msg(appLang.trans('请选择视频'));
                    }
                    html='<video   src="'+video_url+'" poster="'+video_poster+'"  controls="controls" style="max-width: 100%"></video>';
                    break;
                }
                if(!html){
                  return layer.msg(appLang.trans('请填写视频信息'));
                }
                context.invoke('editor.pasteHTML', html);
                layer.close(index);
                /* var items = layero.find('iframe').contents().find('.upload-area-more-item.active');
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
                    layer.close(index); //关闭弹层*/
               /* var html = '';
                for (var i in res) {
                  html += '<img src="' + res[i].path + '" alt="' + res[i].tmp_name + '">';
                }
                context.invoke('editor.pasteHTML', html);*/
              }, 'video', 1)
            });

          }
        });

        // create jQuery object from button instance.
        var $videolayui = button.render();
        return $videolayui;
      });

      // This events will be attached when editor is initialized.
      this.events = {
        // This will be called after modules are initialized.
        'summernote.init': function (we, e) {

        },
        // This will be called when user releases a key on editable.
        'summernote.keyup': function (we, e) {

        }
      };

      // This method will be called when editor is initialized by $('..').summernote();
      // You can create elements for plugin
      this.initialize = function () {

      };

      // This methods will be called when editor is destroyed by $('..').summernote('destroy');
      // You should remove elements on `initialize`.
      this.destroy = function () {
        this.$panel.remove();
        this.$panel = null;
      };
    }
  });
}));
