layui.define(['layer', 'utable', 'listTable'], function (exports) {
  var $ = layui.jquery;
  var layer = layui.layer;
  var table = layui.utable;
  var listTable = layui.listTable;
  var has_hander = 0;
  var treetable = {
    // 渲染树形表格
    render: function (param) {
      this.param = param;
      param.reload_url = param.url;
      // 检查参数
      if (!treetable.checkParam(param)) {
        return;
      }
      // 获取数据
      if (param.data) {
        treetable.init(param, param.data);
      } else {
        $.getJSON(param.url, param.where, function (res) {
          treetable.init(param, res.data);
        });
      }
    },
    //刷新页面，重载入
    reload: function (that, res) {
      var param = that.param;
      $.getJSON(param.reload_url, param.where, function (res) {
        that.init(param, res.data);

      });
    },
    // 渲染表格
    init: function (param, data) {
      var mData = [];
      var doneCallback = param.done;
      var tNodes = data;
      // 补上id和pid字段
      for (var i = 0; i < tNodes.length; i++) {
        var tt = tNodes[i];
        if (!tt.id) {
          if (!param.treeIdName) {
            layer.msg(appLang.trans('参数treeIdName不能为空'), {icon: 5});
            return;
          }
          tt.id = tt[param.treeIdName];
        }
        if (!tt.pid) {
          if (!param.treePidName) {
            layer.msg(appLang.trans('参数treePidName不能为空'), {icon: 5});
            return;
          }
          tt.pid = tt[param.treePidName];
        }
      }

      // 对数据进行排序
      var sort = function (s_pid, data) {
        for (var i = 0; i < data.length; i++) {
          if (data[i].pid == s_pid) {
            var len = mData.length;
            if (len > 0 && mData[len - 1].id == s_pid) {
              mData[len - 1].isParent = true;
            }
            mData.push(data[i]);
            sort(data[i].id, data);
          }
        }
      };
      sort(param.treeSpid, tNodes);

      // 重写参数
      param.url = undefined;
      param.data = mData;
      param.page = {
        count: param.data.length,
        limit: param.data.length
      };
      param.even = false;
      param.cols[0][param.treeColIndex].templet = function (d) {
        var mId = d.id;
        var mPid = d.pid;
        var isDir = d.isParent;
        var emptyNum = treetable.getEmptyNum(mPid, mData);
        var iconHtml = '';
        for (var i = 0; i < emptyNum; i++) {
          iconHtml += '<span class="treeTable-empty"></span>';
        }
        if (isDir) {
          iconHtml += '<i class="layui-icon layui-icon-triangle-d"></i>';
        } else {
          iconHtml += '';
        }
        iconHtml += '&nbsp;&nbsp;';
        var ttype = isDir ? 'dir' : 'file';
        var vg = '<span class="treeTable-icon open" lay-tid="' + mId + '" lay-tpid="' + mPid + '" lay-ttype="' + ttype + '">';
        return vg + iconHtml + d[param.cols[0][param.treeColIndex].field] + '</span>'
      };
      //数据渲染完的回调。你可以借此做一些其它的操作
      param.done = function (res, curr, count) {
        //添加树形CLASS
        $(param.elem).next().addClass('treeTable');
        //隐藏分页
        $('.treeTable .layui-table-page').css('display', 'none');
        $(param.elem).next().attr('treeLinkage', param.treeLinkage);
        // 绑定事件换成对body绑定
        /*$('.treeTable .treeTable-icon').click(function () {
            treetable.toggleRows($(this), param.treeLinkage);
        });*/
        //是否折叠
        if (param.treeDefaultClose) {
          treetable.foldAll(param.elem);
        }
        if (doneCallback) {
          doneCallback(res, curr, count);
        }
      };

      // 渲染表格
      table.render(param);


    },
    //增加事件监听
    listenFun: function () {
      var that = this;
      if (has_hander == 0) {
        //执行事件/顶部事件
        listTable.handle('', function (res) {

          that.reload(that, res)
        });
        listTable.top(function (res) {

          that.reload(that, res)
        });
      }

      has_hander = 1;
    },
    // 计算缩进的数量
    getEmptyNum: function (pid, data) {
      var num = 0;
      if (!pid) {
        return num;
      }
      var tPid;
      for (var i = 0; i < data.length; i++) {
        if (pid == data[i].id) {
          num += 1;
          tPid = data[i].pid;
          break;
        }
      }
      return num + treetable.getEmptyNum(tPid, data);
    },
    // 展开/折叠行
    toggleRows: function ($dom, linkage) {
      var type = $dom.attr('lay-ttype');
      if ('file' == type) {
        return;
      }
      var mId = $dom.attr('lay-tid');
      var isOpen = $dom.hasClass('open');
      if (isOpen) {
        $dom.removeClass('open');
      } else {
        $dom.addClass('open');
      }
      $dom.closest('tbody').find('tr').each(function () {
        var $ti = $(this).find('.treeTable-icon');
        var pid = $ti.attr('lay-tpid');
        var ttype = $ti.attr('lay-ttype');
        var tOpen = $ti.hasClass('open');
        if (mId == pid) {
          if (isOpen) {
            $(this).hide();
            if ('dir' == ttype && tOpen == isOpen) {
              $ti.trigger('click');
            }
          } else {
            $(this).show();
            if (linkage && 'dir' == ttype && tOpen == isOpen) {
              $ti.trigger('click');
            }
          }
        }
      });
    },
    // 检查参数
    checkParam: function (param) {
      if (!param.treeSpid && param.treeSpid != 0) {
        layer.msg('参数treeSpid不能为空', {icon: 5});
        return false;
      }

      if (!param.treeColIndex && param.treeColIndex != 0) {
        layer.msg('参数treeColIndex不能为空', {icon: 5});
        return false;
      }
      return true;
    },
    // 展开所有
    expandAll: function (dom) {
      $(dom).next('.treeTable').find('.layui-table-body tbody tr').each(function () {
        var $ti = $(this).find('.treeTable-icon');
        var ttype = $ti.attr('lay-ttype');
        var tOpen = $ti.hasClass('open');
        if ('dir' == ttype && !tOpen) {
          $ti.trigger('click');
        }
      });
    },
    // 折叠所有
    foldAll: function (dom) {
      $(dom).next('.treeTable').find('.layui-table-body tbody tr').each(function () {
        var $ti = $(this).find('.treeTable-icon');
        var ttype = $ti.attr('lay-ttype');
        var tOpen = $ti.hasClass('open');
        if ('dir' == ttype && tOpen) {
          $ti.trigger('click');
        }
      });
    }
  };

  layui.link(layui.cache.base + 'treetable-lay/treetable.css');

  // 给图标列绑定事件
  $('body').on('click', '.treeTable .treeTable-icon', function () {
    var treeLinkage = $(this).parents('.treeTable').attr('treeLinkage');
    if ('true' == treeLinkage) {
      treetable.toggleRows($(this), true);
    } else {
      treetable.toggleRows($(this), false);
    }
  });

  exports('treetable', treetable);
});