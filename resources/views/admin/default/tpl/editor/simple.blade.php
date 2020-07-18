<link rel="stylesheet" href="{{ ___('font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ ___('editor/simple/simplemde.min.css') }}">
<script src="{{ ___('editor/simple/simplemde.min.js') }}"></script>
<script src="{{ ___('editor/simple/codemirror-4.inline-attachment.js') }}"></script>
<script src="{{ ___('editor/simple/simplemde_extend_kq.js') }}"></script>
<style>
    .fa-b {
        font-weight: bold;
    }

    .fa-1:after {
        content: "H1";
        display: inline-block;

    }

    .fa-2:after {
        content: "H2";
        display: inline-block;

    }

    .fa-3:after {
        content: "H3";
        display: inline-block;

    }

    .fa-4:after {
        content: "H4";
        display: inline-block;

    }

    .editor-toolbar a {
        line-height: 30px;
    }
</style>
<script>
  function simple(Obj, config) {
    config = config || {};
    var cacheName = config.cacheName || 'MyUniqueID';
    var simplemde = new SimpleMDE({
      element: document.getElementById(Obj),
      spellChecker: false,
      forceSync: true,//同步textare
      autosave: {
        enabled: false,//不缓冲
        uniqueId: cacheName,
        delay: 1000,
      },
      renderingConfig: {
        singleLineBreaks: false,
        codeSyntaxHighlighting: true,
      },
      status: false,
      autoDownloadFontAwesome: false,//fa图标取消下载，手动引入
      toolbar: [

        {
          name: "undo",
          action: SimpleMDE.undo,
          className: "fas fa fa-undo no-disable",
          title: appLang.trans("撤销")
        },
        {
          name: "redo",
          action: SimpleMDE.redo,
          className: "fas  fa fa-repeat no-disable",
          title: appLang.trans("重做")
        },
        {
          name: "h1",
          action: SimpleMDE.toggleHeading1,
          className: "fas fa-b fa-1",
          title: appLang.trans("标题1")
        },
        {
          name: "h2",
          action: SimpleMDE.toggleHeading2,
          className: "fas fa-b fa-2",
          title: appLang.trans("标题2")
        },
        {
          name: "h3",
          action: SimpleMDE.toggleHeading3,
          className: "fas fa-b fa-3",
          title: appLang.trans("标题3")
        },
        {
          name: "h4",
          action: function customFunction(editor) {
            SimpleToggleHeading(editor, 4)
          },
          className: "fas fa-b fa-4",
          title: appLang.trans("标题4"),
        },

        {
          name: "quote",
          action: SimpleMDE.toggleBlockquote,
          className: "fas fa fa-quote-left",
          title: appLang.trans("块"),
          default: true
        },
        {
          name: "bold",
          action: SimpleMDE.toggleBold,
          className: "fas fa fa-bold",
          title: appLang.trans("加粗")
        },
        {
          name: "italic",
          action: SimpleMDE.toggleItalic,
          className: "fas fa fa-italic",
          title: appLang.trans("斜体")
        }
        ,
        {
          name: "strikethrough",
          action: SimpleMDE.toggleStrikethrough,
          className: "fa fa-strikethrough",
          title: appLang.trans("删除线")
        },

        {
          name: "code",
          action: SimpleMDE.toggleCodeBlock,
          className: "fas fa fa-code",
          title: appLang.trans("代码")
        }
        ,

        {
          name: "align-left",
          action: function (editor) {
            SimpleToggleHeading(editor, 'left');
          },
          className: "fas fa fa-align-left",
          title: appLang.trans("左对齐")
        }
        ,

        {
          name: "align-left",
          action: function (editor) {
            SimpleToggleHeading(editor, 'center');
          },
          className: "fas fa fa-align-justify",
          title: appLang.trans("居中")
        }
        ,

        {
          name: "align-left",
          action: function (editor) {
            SimpleToggleHeading(editor, 'right');
          },
          className: "fas fa fa-align-right",
          title: appLang.trans("右对齐")
        }
        ,

        {
          name: "ordered-list",
          action: SimpleMDE.toggleOrderedList,
          className: "fas fa fa-list-ol",
          title: appLang.trans("有序")
        }
        ,

        {
          name: "unordered-list",
          action: SimpleMDE.toggleOrderedList,
          className: "fas fa fa-list-ul",
          title: appLang.trans("无序")
        }
        ,

        {
          name: "link",
          action: SimpleMDE.drawLink,
          className: "fas fa fa-link",
          title: appLang.trans("链接")
        }
        ,
        {
          name: "video",
          action: function (editor) {
            SimpleDrawVideo(editor);
          },
          className: "fas fa fa-video-camera",
          title: appLang.trans("视频")
        }
        ,

        {
          name: "img",
          action: function (editor) {
            SimpleDrawImg(editor);
          },
          className: "fas fa fa-picture-o",
          title: appLang.trans("图片")
        }
        ,

        {
          name: "table",
          action: SimpleMDE.drawTable,
          className: "fas fa fa-table",
          title: appLang.trans("链接")
        },
        {
          name: "horizontal-rule",
          action: SimpleMDE.drawHorizontalRule,
          className: "fas fa fa-minus",
          title: appLang.trans("水平线")
        },
        {
          name: "side-by-side",
          className: "fas fa fa-columns no-disable no-mobile",
          action: SimpleMDE.toggleSideBySide,
          title: appLang.trans("预览模式"),
          default: true
        },
        {
          name: "fullscreen",
          action: SimpleMDE.toggleFullScreen,
          className: "fas fa fa-arrows-alt no-disable no-mobile",
          title: appLang.trans("全屏"),
          default: true
        },
        {
          name: "page",
          action: function (editor) {
            SimpletogglePager(editor);
          },
          className: "fas fa fa-paragraph no-disable no-mobile",
          title: appLang.trans("插入分页"),
          default: true
        },
      ]
    });
    //默认预览

    var inlineAttachmentConfig = {
      uploadUrl: g_upload_url,               //后端上传图片地址
      uploadFieldName: 'file',          //POST字段的名称
      jsonFieldName: 'path',              //返回结果中图片地址对应的字段名称
      progressText: '![图片上传中...]()',    //上传过程中用户看到的文案
      errorText: '图片上传失败',
      extraHeaders: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
      },
      urlText: '![file]({filename})  ',//让它换行
      onFileUploaded: function (filename) {
        //替换编辑器位置
        var cm = this.editor.codeMirror;
        var startPoint = cm.getCursor("start");
        var endPoint = cm.getCursor("end");
        filename = filename + '  ';
        endPoint.ch = startPoint.ch + filename.length + 2;
        cm.setSelection(startPoint, endPoint);
        cm.focus();
      }
    };
    inlineAttachment.editors.codemirror4.attach(simplemde.codemirror, inlineAttachmentConfig);
    return simplemde;

  }
</script>