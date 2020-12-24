layui.define(['utable', 'uform', 'request', 'laypage', 'layer', 'custormEvent'], function (exports) {
  var $ = layui.$;
  var table = layui.utable;
  var form = layui.uform;
  var req = layui.request;
  var layer = layui.layer;
  var custormEvent = layui.custormEvent;

  var listTable = {
    render: listTableRender,//列表表格渲染
    search: listSearch,//列表表格搜索开启
    handle: handleListenTable,//列表监听事件
    top: handelTopListenTable,//顶部操作监听事件
    custom: customList,//自定义列表
    sort: handeleListenTableSort,//列表排序
    searchDo: listAddSearchDoing,//列表自定义搜索字段
    getCheckedIds: listGetCheckedBoxId,//取得列表的选中的IDS
    reload: listTableReload,//重载表格

  }

  /**
   * 自定义列表
   * @param objApp
   * @param url
   * @param pageconfig
   * @param handleFun
   * @param successCallback
   * @param errorCallback
   */
  function customList(objApp, url, pageConfig, handleFun, successCallback, errorCallback) {
    pageConfig = pageConfig || {};
    var laypage = layui.laypage;
    var laypageParams = {
      obj_id: 'page',
      limit: 12,
      limits: [1, 12, 30, 50, 70],
      layout: ['prev', 'page', 'next'],
      prev: appLang.trans('上一页'),
      next: appLang.trans('下一页')
    };
    laypageParams = $.extend(laypageParams, pageConfig);

    req.post(url, {limit: laypageParams.limit}, function (data) {
      if (data.total <= 0) {
        return false;
      }
      laypage.render({
        limit: laypageParams.limit,
        elem: laypageParams.obj_id,
        count: data.total,
        limits: laypageParams.limits,
        layout: laypageParams.layout,
        theme: "##009688",
        jump: function (obj, first) {
          if (typeof(handleFun) != "function" && typeof(successCallback) == "function") {
            successCallback(obj, first);
          }

          if (first) {
            if (typeof(handleFun) == "function") {
              return handleFun(data);
            } else {
              $(objApp).empty().append(data.contents);
              form.render();
            }

          }

          req.post(url, {
            offset: obj.curr,
            limit: obj.limit,
            _token: $('[name="csrf-token"]').attr('content')
          }, function (tdata) {
            if (tdata.total <= 0) {
              return false;
            }

            if (typeof(handleFun) == "function") {

              return handleFun(tdata);
            } else {
              $(objApp).empty().append(tdata.contents);
              form.render();
              return '';
            }
          })

        }
      });
    }, '', function () {

    })


  }


  /**
   * 列表渲染
   * @param url 地址
   * @param cols 数据数组
   * @param config 配置参数
   * @param extendFun 附加监听注入
   * @param tableNameId 表格监听名称
   * @param doneFun 请求成功之后回调，可以再列表内增加其他操作，比如是统计之类
   * @param closeHandelBtnFun 是否取消顶部按钮监听
   */
  function listTableRender(url, cols, config, extendFun, tableNameId, doneFun,closeHandelBtnFun) {
    tableNameId = tableNameId || 'LAY-list-table';
    config = config || {};

    var defatul_config = {
      elem: '#' + tableNameId,
      page: true,
      toolbar: true,
      method: 'post',
      limit: 30,
      even: false, //开启隔行背景
      limits: [
        1, 20, 30, 40, 50, 70, 100, 120, 150, 200
      ],
      text: {
        none: appLang.trans('无数据') //默认：无数据。注：该属性为 layui 2.2.5 开始新增
      },
      where: {},
      cellMinWidth: 120,
      url: url, //模拟接口
      cols: cols,
      response: {
        statusName: 'code' //规定数据状态的字段名称，默认：code
        , statusCode: 200 //规定成功的状态码，默认：0
        , msgName: 'msg' //规定状态信息的字段名称，默认：msg
        , countName: 'count' //规定数据总数的字段名称，默认：count
        , dataName: 'data' //规定数据列表的字段名称，默认：data
      }, done: function (res, curr, count) {
        doneFun && doneFun(res, curr, count);
      }

    };
    var render_config = $.extend({}, defatul_config, config);

    render_config.where._token = $('[name="csrf-token"]').attr('content');
    table.render(render_config);
    //监听表的事件
    handleListenTable(extendFun);
    closeHandelBtnFun=closeHandelBtnFun || 0;
    //顶部操作
    if(!closeHandelBtnFun){
      handelTopListenTable();
    }

  }

  /**
   * 监听表的事件
   */
  function handleListenTable(extendFun, callFun, tableNameId) {

    tableNameId = tableNameId || 'LAY-list-table';
    //监听表操作
    table.on('tool(' + tableNameId + ')', function (obj) {
      var data = obj.data;
      var url, w, h, title;

      var parent_layui=$(this).data('parent') || 0;
      var topLayui = layui ;
      if(parent_layui){
        topLayui=parent.layui;
      }

      switch (obj.event) {
        //删除询问
        case 'del':
          url = listConfig.del_url;
          topLayui.custormEvent.confirmPost(
            appLang.trans('确定删除吗?'),
            url, {
              ids: data.id,
              type_id: 'id',
              handle_str: appLang.trans('删除') + ' ' + appLang.trans(listConfig.page_name),
              _method: "PUT"
            }, "", 1, tableNameId, function (res) {
              if (res.code == 200) {
                obj.del();
              }
              callFun && callFun(res)
            });
          break;
        //post 询问一个赋值
        case 'copy':
          url = data.copy_url;
          topLayui.custormEvent.confirmPost(
            appLang.trans('确定复制吗?'),
            url, "", "", 1, tableNameId, function (res) {
              callFun && callFun(res)
            },)
          break;
        //编辑iframe
        case 'edit':
          url = data.copy_url;
          w = listConfig.open_width;
          h = listConfig.open_height;
          //是否父级弹窗


          topLayui.custormEvent.openIframePost(
            data.edit_url,
            data.edit_post_url,
            w, h,
            appLang.trans('编辑') + appLang.trans(listConfig.page_name),
            [appLang.trans('立即更新'), appLang.trans('取消')],
            tableNameId,
            function (res) {
              callFun && callFun(res)
            }
          )
          break;
        //查看图片
        case 'showImg':
          var src = $(this).data('src');
          src = src || $(this).attr('src');
          topLayui.custormEvent.viewImg(src);
          break;
        //查看url内容
        case 'show':
          w = $(this).data('w');
          h = $(this).data('h');
          title = $(this).data('title');
          url = $(this).data('url');
          topLayui.custormEvent.openIframe(w, h, title, url, callFun);
          break;
        //自定义打开iframe 提交地址，需要2个url
        case 'openPost':
          w = $(this).data('w');
          h = $(this).data('h');
          btn = $(this).data('btn');
          title = $(this).data('title');
          url = $(this).data('url');
          var post_url = $(this).data('post_url');
          topLayui.custormEvent.openIframePost(
            url, post_url, w, h, title, btn, tableNameId, function (res) {
              callFun && callFun(res)
            });
          break;
        //直接询问是否提交，需要一个post url
        case 'post':
          btn = $(this).data('btn');
          title = $(this).data('title');
          url = $(this).data('url');
          topLayui.custormEvent.confirmPost(title, url, '', btn, 1, tableNameId, callFun);
          break;
        case 'openTabUrl':
          var url = $(this).data('url');
          var text = $(this).data('text');
          var topLayui = parent === self ? layui : top.layui;
          topLayui.index.openTabsPage(url, text);


          break;
      }
      //附加监听表
      if (typeof(extendFun) == "function") {
        return extendFun(obj, $(this));
      }

    });
    //监听单元格表格编辑
    table.on('edit(' + tableNameId + ')', function (obj) {
      var value = obj.value,
        data = obj.data,
        field = obj.field;
      //ajax操作
      data = {
        field: field,
        field_value: value,
        ids: data.id
      };
      if (field == 'sort') {
        reg = /^[0-9]*$/;
        if (!reg.test(value)) {
          layer.msg(appLang.trans('只能输入数字'));
          return false;
        }
      }
      var isReload = 0;
      if (field == 'sort') {
        if (g_sort_reload == true) {
          isReload = 1;
        }

      }


      custormEvent.postData(listConfig.edit_field_url, data, isReload, tableNameId, callFun, '', 'sort')

    });

  }

  //switch 监听
  form.on('switch(table-checked)', function (obj) {
    var field = $(this).data('field');
    var true_value = $(this).data('true_value') || 1;
    var false_value = $(this).data('false_value') || 0;
    var value = obj.elem.checked ? true_value : false_value;
    var isReload = $(this).data('is_reload') || 0;//是否重载入
    var id = $(this).data('id');
    field = field || 'is_checked';
    //ajax操作
    var data = {
      field: field,
      field_value: value,
      ids: id
    };
    custormEvent.postData(listConfig.edit_field_url, data, isReload, '', function (res) {
      if (res.code == 200) {
        obj.elem.checked = obj.elem.checked;
        form.render();
      } else {
        obj.elem.checked = !obj.elem.checked
        form.render();
      }
      layer.msg(res.msg);
    })

  });

  /**
   * 顶部删除
   * @returns {*}
   */
  function topDel(callFun) {

    var tableNameId = $(this).data('tableNameId') || 'LAY-list-table';
    var ids = listGetCheckedBoxId(tableNameId);
    if (ids.length <= 0) {
      layer.msg(appLang.trans('没有选择数据'));
      return false;
    }
    var btn = $(this).data('btn');
    var data = {
      _method: 'PUT',
      ids: ids.join(','),
      table: listConfig.table_name,
      type_id: 'id',
      handle_str: appLang.trans(listConfig.page_name)
    };
    custormEvent.confirmPost(appLang.trans('确定批量删除吗？'), listConfig.del_url, data, btn, 1, tableNameId, callFun);

  }

  //顶部操作修改字段
  function doHandel(callFun) {
    var tableNameId = $(this).data('tableNameId') || 'LAY-list-table';
    var ids = listGetCheckedBoxId(tableNameId);
    if (ids.length <= 0) {
      layer.msg(appLang.trans('没有选择数据'));
      return false;
    }
    var btn = $(this).data('btn');
    var field = $(this).data('field');//字段
    var value = $(this).data('value');//要修改字段的值
    var title = $(this).data('title') || appLang.trans('确定批量操作吗');//修改的标题提示

    var data = {
      field: field,
      field_value: value,
      ids: ids.join(',')
    };
    custormEvent.confirmPost(title, listConfig.edit_field_url, data, btn, 1, tableNameId);

  }
  //顶部操作，跳转链接
  function doLink(callFun) {
    var url = $(this).data('url');
    window.location.href=url;
  }


  /**
   * 顶部添加
   */
  function topAdd(callFun) {
    var tableNameId = $(this).data('tableNameId') || 'LAY-list-table';
    custormEvent.openIframePost(
      listConfig.create_url,
      listConfig.store_url,
      listConfig.open_width,
      listConfig.open_height,
      appLang.trans('添加') + appLang.trans(listConfig.page_name),
      [appLang.trans('立即添加'), appLang.trans('取消')], tableNameId, callFun
    );

  }

  /**
   * 导入数据
   */
  function importHandle(callFun) {
    var tableNameId = $(this).data('tableNameId') || 'LAY-list-table';
    var del = $(this).data('del');
    var w = $(this).data('w');
    var h = $(this).data('w');
    var post_url = $(this).data('post_url');
    del = del || '';
    var url = g_import_url + '?table=' + listConfig.table_name + '&del=' + del;
    custormEvent.openIframePost(
      url,
      post_url,
      w || '750px',
      h || '500px',
      appLang.trans('导入数据'),
      [appLang.trans('立即添加'), appLang.trans('取消')], tableNameId, callFun
    );


  }

  /**
   * 顶部自定义添加
   */
  function topCreate(callFun) {
    var tableNameId = $(this).data('tableNameId') || 'LAY-list-table';
    var url = $(this).data('url');
    var post_url = $(this).data('post_url');
    if (post_url) {
      g_import_post_url = post_url
    }
    w = $(this).data('w');
    h = $(this).data('h');
    var title = $(this).data('title');
    custormEvent.openIframePost(
      url,
      g_import_post_url,
      w || '750px',
      h || '500px',
      appLang.trans(title),
      [appLang.trans('立即添加'), appLang.trans('取消')], tableNameId, callFun
    );
  }

  //顶部操作监听
  function handelTopListenTable(callFun) {
    var active = {
      allDel: topDel,
      add: topAdd,
      custormAdd: topCreate,//自定义添加
      import: importHandle,//导入表格
      handle: doHandel,
      link:doLink

    };
    $('.kongqi-handel').on('click', function () {
      var type = $(this).data('type');
      active[type] ? active[type].call(this, callFun) : '';
    });
  }

  /**
   * 列表执行搜索并重载
   */
  function listSearch(filterName, tableNameId) {
    filterName = filterName || 'LAY-list-search';
    tableNameId = tableNameId || 'LAY-list-table';
    form.on('submit(' + filterName + ')', function (data) {

      var field = data.field;

      //执行重载
      table.reload(tableNameId, {
        where: field
      });
    });
  }

  /**
   * 添加搜索条件并搜索
   * @param field
   */
  function listAddSearchDoing(field, tableNameId) {
    tableNameId = tableNameId || 'LAY-list-table';
    table.reload(tableNameId, {
      where: field
    });
  }

  /**
   * 重载入表格
   */
  function listTableReload(tableNameId) {
    tableNameId = tableNameId || 'LAY-list-table';
    table.reload(tableNameId);
  }

  //取得table列表选择的ids
  function listGetCheckedBoxId(tableNameId) {
    tableNameId = tableNameId || 'LAY-list-table';
    var checkStatus = table.checkStatus(tableNameId),
      checkData = checkStatus.data; //得到选中的数据
    if (checkData.length === 0) {
      return [];
    }
    var ids = new Array();
    for (i in checkData) {
      ids.push(checkData[i]['id']);
    }
    return ids;
  }

  //点击表格头排序事件
  function handeleListenTableSort() {
    table.on('sort(LAY-list-table)', function (obj) {
      table.reload('LAY-list-table', {
        initSort: obj
        , where: {
          sort: obj.field, //排序字段
          order: obj.type //排序方式
        }
      });


    });
  }


  exports('listTable', listTable);
});
