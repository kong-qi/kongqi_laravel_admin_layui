layui.define(["jquery"], function (a) {
  var $ = layui.jquery;
  var ContentMenu = {
    bind: function (obj, items) {
      //绑定事件,右键触发事件
      $(obj).bind("contextmenu", function (e) {
        //执行显示方法
        ContentMenu.show(items, e.clientX, e.clientY, e);
        return false
      })
    }, show: function (items, x, y, e) {

      var style = "left: " + x + "px; top: " + y + "px;";
      //设置定位
      var html = '<div class="ctxMenu shadow" style="' + style + '">';
      //把数据转换成html数据
      html += ContentMenu.getHtml(items, "");
      html += "</div>";
      ContentMenu.remove();
      $("body").append(html);
      var ctxMenu = $(".ctxMenu");
      if (x + ctxMenu.outerWidth() > ContentMenu.getPageWidth()) {
        x -= ctxMenu.outerWidth()
      }
      if (y + ctxMenu.outerHeight() > ContentMenu.getPageHeight()) {
        y = y - ctxMenu.outerHeight();
        if (y < 0) {
          y = 0
        }
      }
      ctxMenu.css({"top": y, "left": x});
      //绑定事件
      ContentMenu.subEvents(items, e);
      //当鼠标移开这个item的时候
      $(".ctxMenu-item").on("mouseenter", function (e) {
        e.stopPropagation();
        $(this).parent().find(".ctxMenu-sub").css("display", "none");
        if (!$(this).hasClass("haveMore")) {
          return
        }
        var a = $(this).find(">a");
        var subItem = $(this).find(">.ctxMenu-sub");
        var subTop = a.offset().top - $("body,html").scrollTop();
        var subLeft = a.offset().left + a.outerWidth() - $("body,html").scrollLeft();
        if (subLeft + subItem.outerWidth() > ContentMenu.getPageWidth()) {
          subLeft = a.offset().left - subItem.outerWidth()
        }
        if (subTop + subItem.outerHeight() > ContentMenu.getPageHeight()) {
          subTop = subTop - subItem.outerHeight() + a.outerHeight();
          if (subTop < 0) {
            subTop = 0
          }
        }
        $(this).find(">.ctxMenu-sub").css({"top": subTop, "left": subLeft, "display": "block"})
      })
    },
    remove: function () {
      var frames = parent.window.frames;
      for (var d = 0; d < frames.length; d++) {
        var frameItem = frames[d];
        try {
          frameItem.layui.jquery("body>.ctxMenu").remove()
        } catch (e) {
        }
      }
      try {
        parent.layui.jquery("body>.ctxMenu").remove()
      } catch (e) {
      }
    },
    subEvents: function (items, parentElemet) {
      $(".ctxMenu").off("click").on("click", "[event-id]", function (elemt) {
        var obj = $(this).attr("event-id");
        var currentItem = getClickItem(obj, items);
        currentItem.click && currentItem.click(elemt, parentElemet)
      });

      function getClickItem(obj, items) {
        for (var j = 0; j < items.length; j++) {
          var item = items[j];
          if (obj == item.itemId) {
            return item
          } else {
            if (item.subs && item.subs.length > 0) {
              var g = e(obj, item.subs);
              if (g) {
                return g
              }
            }
          }
        }
      }

    },
    getHtml: function (items, d) {
      var h = "";
      for (var i = 0; i < items.length; i++) {
        var item = items[i];
        item.itemId = "ctxMenu-" + d + i;
        if (item.subs && item.subs.length > 0) {
          h += '<div class="ctxMenu-item haveMore" event-id="' + item.itemId + '">';
          h += "<a>";
          if (item.icon) {
            h += '<i class="' + item.icon + ' ctx-icon"></i>'
          }
          h += item.name;
          h += '<i class="layui-icon layui-icon-right icon-more"></i>';
          h += "</a>";
          h += '<div class="ctxMenu-sub" style="display: none;">';
          h += ContentMenu.getHtml(item.subs, d + i);
          h += "</div>"
        } else {
          h += '<div class="ctxMenu-item" event-id="' + item.itemId + '">';
          h += "<a>";
          if (item.icon) {
            h += '<i class="' + item.icon + ' ctx-icon"></i>'
          }
          h += item.name;
          h += "</a>"
        }
        h += "</div>";
        if (items.length != (i + 1)) {
          h += '<div class="border-top"></div>'
        }


      }
      return h
    },
    getPageHeight: function () {
      return document.documentElement.clientHeight || document.body.clientHeight
    }, getPageWidth: function () {
      return document.documentElement.clientWidth || document.body.clientWidth
    },
  };
  $(document).off("click.ctxMenu").on("click.ctxMenu", function () {
    ContentMenu.remove()
  });
  $(document).off("click.ctxMenuMore").on("click.ctxMenuMore", ".ctxMenu-item", function (d) {
    if ($(this).hasClass("haveMore")) {
      if (d !== void 0) {
        d.preventDefault();
        d.stopPropagation()
      }
    } else {
      ContentMenu.remove()
    }
  });
  layui.link(layui.cache.base + 'contextMenu/contextMenu.css');  // 加载css
  a("contextMenu", ContentMenu)
});
