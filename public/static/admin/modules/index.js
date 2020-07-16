/**

 @Name：layuiAdmin iframe版主入口
 @Author：贤心
 @Site：http://www.layui.com/admin/
 @License：LPPL

 */
/*
*
* */

layui.extend({
  setter: 'config' // {/}的意思即代表采用自有路径，即不跟随 base 路径
}).define(['setter', 'admin', 'cacheNav'], function (exports) {
  var setter = layui.setter
    , cacheNav = layui.cacheNav
    , element = layui.element
    , admin = layui.admin
    , tabsPage = admin.tabsPage

    //打开标签页
    , openTabsPage = function (url, text) {
      //遍历页签选项卡
      var matchTo
        , tabs = $('#LAY_app_tabsheader>li')
        , path = url.replace(/(^http(s*):)|(\?[\s\S]*$)/g, '');

      tabs.each(function (index) {
        var li = $(this)
          , layid = li.attr('lay-id');

        if (layid === url) {
          matchTo = true;
          tabsPage.index = index;
        }
      });

      text = text || '新标签页';

      //定位当前tabs
      var setThisTab = function () {
        element.tabChange(FILTER_TAB_TBAS, url);
        admin.tabsBodyChange(tabsPage.index, {
          url: url
          , text: text
        });
      };

      if (setter.pageTabs) {
        //如果未在选项卡中匹配到，则追加选项卡
        if (!matchTo) {
          //延迟修复 Firefox 空白问题
          setTimeout(function () {
            $(APP_BODY).append([
              '<div class="layadmin-tabsbody-item layui-show">'
              , '<iframe src="' + url + '" frameborder="0" class="layadmin-iframe"></iframe>'
              , '</div>'
            ].join(''));
            setThisTab();
          }, 10);

          tabsPage.index = tabs.length;
          element.tabAdd(FILTER_TAB_TBAS, {
            title: '<span>' + text + '</span>'
            , id: url
            , attr: path
          });

        }
      } else {
        var iframe = admin.tabsBody(admin.tabsPage.index).find('.layadmin-iframe');
        iframe[0].contentWindow.location.href = url;
      }

      setThisTab();
    }

    , APP_BODY = '#LAY_app_body', FILTER_TAB_TBAS = 'layadmin-layout-tabs'
    , $ = layui.$, $win = $(window);

  //初始
  // if (admin.screen() < 2) admin.sideFlexible();


  //加载缓存的navs
  var cacheOpenTabsPage = function () {
    //判断是否存在缓存
    var cache_navs = cacheNav.get();
    if (cache_navs) {
      var item_key = cacheNav.getOn();
      //进行输出变量
      for (var i in cache_navs) {
        var item = cache_navs[i];
        if (item && item.href) {
          item.title = item.title.replace(/ဆ/, '');

          //插入顶部tabs
          if(top.layui.index){

            top.layui.index.openTabsPage(item.href, item.title)
          }


        }

      }

      //设置最后一个定位
      item_key = cacheNav.getOn();
      item = cache_navs[item_key];



      if (item && item.href) {
        item.title = item.title.replace(/ဆ/, '');

        if(top.layui.index){
          top.layui.index.openTabsPage(item.href, item.title)
        }

      }

    }
  };
  cacheOpenTabsPage();


  //对外输出
  exports('index', {
    openTabsPage: openTabsPage,
    cacheNav:cacheNav
  });
});
