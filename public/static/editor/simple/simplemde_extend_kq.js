//增加设置标签H1-H6


function SimpleToggleHeading(editor, size, direction) {
  var cm = editor.codemirror;
  if (/editor-preview-active/.test(cm.getWrapperElement().lastChild.className))
    return;
  var startPoint = cm.getCursor("start");
  var endPoint = cm.getCursor("end");
  for (var i = startPoint.line; i <= endPoint.line; i++) {
    (function (i) {
      var text = cm.getLine(i);
      var currHeadingLevel = text.search(/[^#]/);

      if (direction !== undefined) {
        if (currHeadingLevel <= 0) {
          if (direction == "bigger") {
            text = "###### " + text;
          } else {
            text = "# " + text;
          }
        } else if (currHeadingLevel == 6 && direction == "smaller") {
          text = text.substr(7);
        } else if (currHeadingLevel == 1 && direction == "bigger") {
          text = text.substr(2);
        } else {
          if (direction == "bigger") {
            text = text.substr(1);
          } else {
            text = "#" + text;
          }
        }
      } else {
        if (size == 1) {
          if (currHeadingLevel <= 0) {
            text = "# " + text;
          } else if (currHeadingLevel == size) {
            text = text.substr(currHeadingLevel + 1);
          } else {
            text = "# " + text.substr(currHeadingLevel + 1);
          }
        } else if (size == 2) {
          if (currHeadingLevel <= 0) {
            text = "## " + text;
          } else if (currHeadingLevel == size) {
            text = text.substr(currHeadingLevel + 1);
          } else {
            text = "## " + text.substr(currHeadingLevel + 1);
          }
        } else {
          if (currHeadingLevel == size) {
            text = text.substr(currHeadingLevel + 1);
          } else {

            text = _repeatStringNumTimes("#", size) + " " + text.substr(currHeadingLevel + 1);
          }
        }
      }

      cm.replaceRange(text, {
        line: i,
        ch: 0
      }, {
        line: i,
        ch: 99999999999999
      });
    })(i);
  }
  cm.focus();
}

function _repeatStringNumTimes(str, num) {
  let repeatStr = '';
  for (let i = 0; i < num; i++) {
    repeatStr += str;
  }
  return repeatStr;
}


function SimpletoggleAlignment(editor, type) {
  if (/editor-preview-active/.test(editor.codemirror.getWrapperElement().lastChild.className))
    return;

  end_chars = '';
  var cm = editor.codemirror;

  type = type || 'left';
  var text;
  var start = '';
  var end = '';

  var startPoint = cm.getCursor("start");
  var endPoint = cm.getCursor("end");
  text = cm.getSelection();
  //判断是否存在
  var p_reg = /\<p\s.*?\>(.*)\<\/p\>/;
  if (p_reg.test(text)) {
    //已经存在了。
    text = cm.getLine(startPoint.line);
    start = text.slice(0, startPoint.ch);
    end = text.slice(startPoint.ch);
    end = end.replace(/\<p\s.*?\>/, "");
    end = end.replace(/\<\/p\>/, "");

    cm.replaceRange(start + end, {
      line: startPoint.line,
      ch: 0
    }, {
      line: startPoint.line,
      ch: 99999999999999
    });


  } else {
    if (type == 'left') {
      text = "<p align=\"left\">" + text + "</p>";
    }
    if (type == 'center') {
      text = "<p align=\"center\">" + text + "</p>";
    }
    if (type == 'right') {
      text = "<p align=\"right\">" + text + "</p>";
    }

    cm.replaceSelection(start + text + end);
    endPoint.ch = startPoint.ch + text.length;
  }


  cm.setSelection(startPoint, endPoint);
  cm.focus();


}


function SimpletogglePager(editor) {
  var start = '';
  var end = '';
  var cm = editor.codemirror;
  var startPoint = cm.getCursor("start");
  var endPoint = cm.getCursor("end");
  text = cm.getSelection();
  var p_reg = /\[kq_page\]/;
  if (p_reg.test(text)) {
    text = cm.getLine(startPoint.line);
    start = text.slice(0, startPoint.ch);
    end = text.slice(startPoint.ch);
    end = end.replace(p_reg, "");
    cm.replaceRange(start + end, {
      line: startPoint.line,
      ch: 0
    }, {
      line: startPoint.line,
      ch: 99999999999999
    });
  } else {
    text = '  \n[web_page]   \n';
    cm.replaceSelection(start + text + end);
    endPoint.ch = startPoint.ch + text.length;
  }
  cm.setSelection(startPoint, endPoint);
  cm.focus();
}

function SimpleDrawImg(editor) {
  var cm = editor.codemirror;

  layui.use([ 'uploader'], function () {
    var uploader = layui.uploader;

    uploader.placeEdit( function (res) {
      console.log(res);
      var html='';
      for (var i in res){
        html += '![' + res[i].tmp_name + '](' + res[i].path + ')  \n';
      }
      cm.replaceSelection(html);

    },'image',1)
  });


}
//视频
function SimpleDrawVideo(editor) {
  var cm = editor.codemirror;


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

      cm.replaceSelection(html+'  '+"\n");
      layer.close(index);

    }, 'video', 1)
  });




}


