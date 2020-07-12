layui.define(['treetable'], function (exports) {
  var treetable = layui.treetable;

  var treeListTable = {
    render: render
  };

  function render(url, cols, config, extendFun, tableNameId) {
    tableNameId = tableNameId || 'LAY-list-table';
    config = config || {};
    var defatul_config = {
      treeColIndex: 3,//第几列设置折叠图标
      treeIdName: 'id',//ID的值
      treePidName: 'parent_id',//父级id
      treeSpid: 0,
      elem: '#' + tableNameId,
      treeDefaultClose: 0,//是否折叠
      page: false,
      toolbar: true,
      method: 'post',
      limit: 30,
      even: true, //开启隔行背景
      text: {
        none: appLang.trans('无数据') //默认：无数据。注：该属性为 layui 2.2.5 开始新增
      },
      where: {
        limit: 10000,
        sort: 'sort'
      },
      cellMinWidth: 120,
      url: url, //模拟接口
      cols: cols,
      response: {
        statusName: 'code' //规定数据状态的字段名称，默认：code
        , statusCode: 200 //规定成功的状态码，默认：0
        , msgName: 'msg' //规定状态信息的字段名称，默认：msg
        , countName: 'count' //规定数据总数的字段名称，默认：count
        , dataName: 'data' //规定数据列表的字段名称，默认：data
      },
      done: function () {

      }

    };
    var render_config = $.extend({}, defatul_config, config);
    render_config.where._token = $('[name="csrf-token"]').attr('content');
    //渲染
    var tree = treetable.render(render_config);

    $('#btn-expand').click(function () {
      treetable.expandAll("#" + tableNameId);
    });

    $('#btn-fold').click(function () {
      treetable.foldAll("#" + tableNameId);
    });
    //开启监听添加，表格内事件
    treetable.listenFun();
    return tree;


  }

  exports('treeListTable', treeListTable);
});