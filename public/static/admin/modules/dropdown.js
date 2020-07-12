layui.define(["jquery"], function (exports) {
  var $ = layui.jquery;
  var openClass = "dropdown-open";
  var disableClass = "dropdown-disabled";
  var noScrollClass = "dropdown-no-scroll";
  var shadeClass = "dropdown-menu-shade";
  var n = "dropdown-menu";
  var m = "dropdown-menu-nav";
  var j = "dropdown-hover";
  var d = "fixed";
  var g = "no-shade";
  var k = "layui-anim layui-anim-upbit";
  var a = "layui-anim layui-anim-fadein";
  var l = ["bottom-left", "bottom-right", "bottom-center", "top-left", "top-right", "top-center", "left-top", "left-bottom", "left-center", "right-top", "right-bottom", "right-center"];

  var dropdown = {
    //初始化
    init: function () {
      $(document).off("click.dropdown").on("click.dropdown", "." + n + ">*:first-child", function (t) {
        var u = $(this).parent();
        if (!u.hasClass(j)) {
          if (u.hasClass(openClass)) {
            u.removeClass(openClass)
          } else {
            dropdown.hideAll();
            dropdown.show($(this).parent().find("." + m))
          }
        }
        t.stopPropagation()
      });
      $(document).off("click.dropHide").on("click.dropHide", function (t) {
        dropdown.hideAll()
      });
      $(document).off("click.dropNav").on("click.dropNav", "." + m, function (t) {
        t.stopPropagation()
      });
      var s, p, q = "." + n + "." + j;
      $(document).off("mouseenter.dropdown").on("mouseenter.dropdown", q, function (t) {
        if (p && p == t.currentTarget) {
          clearTimeout(s)
        }
        dropdown.show($(this).find("." + m))
      });
      $(document).off("mouseleave.dropdown").on("mouseleave.dropdown", q, function (t) {
        p = t.currentTarget;
        s = setTimeout(function () {
          $(t.currentTarget).removeClass(openClass)
        }, 300)
      });
      $(document).off("click.dropStand").on("click.dropStand", "[data-dropdown]", function (t) {
        dropdown.showFixed($(this));
        t.stopPropagation()
      });
      var r = "." + m + " li";
      $(document).off("mouseenter.dropdownNav").on("mouseenter.dropdownNav", r, function (t) {
        $(this).children(".dropdown-menu-nav-child").addClass(k);
        $(this).addClass("active")
      });
      $(document).off("mouseleave.dropdownNav").on("mouseleave.dropdownNav", r, function (t) {
        $(this).removeClass("active");
        $(this).find("li.active").removeClass("active")
      });
      $(document).off("click.popconfirm").on("click.popconfirm", ".dropdown-menu-nav [btn-cancel]", function (t) {
        dropdown.hideAll();
        t.stopPropagation()
      })
    }, openClickNavClose: function () {
      $(document).off("click.dropNavA").on("click.dropNavA", "." + m + ">li>a", function (p) {
        dropdown.hideAll();
        $(this).parentsUntil("." + n).last().parent().removeClass(openClass);
        p.stopPropagation()
      })
    }, hideAll: function () {
      $("." + n).removeClass(openClass);
      $("." + m + "." + d).addClass("layui-hide");
      $("." + shadeClass).remove();
      $("body").removeClass(noScrollClass);
      $(".dropdown-fix-parent").removeClass("dropdown-fix-parent");
      $("[data-dropdown]").removeClass(openClass)
    }, show: function (r) {
      if (r && r.length > 0 && !r.hasClass(disableClass)) {
        if (r.hasClass("dropdown-popconfirm")) {
          r.removeClass(k);
          r.addClass(a)
        } else {
          r.removeClass(a);
          r.addClass(k)
        }
        var p;
        for (var q = 0; q < l.length; q++) {
          if (r.hasClass("dropdown-" + l[q])) {
            p = l[q];
            break
          }
        }
        if (!p) {
          r.addClass("dropdown-" + l[0]);
          p = l[0]
        }
        dropdown.forCenter(r, p);
        r.parent("." + n).addClass(openClass);
        return p
      }
      return false
    }, showFixed: function (q) {
      var t = $(q.data("dropdown")), p;
      if (!t.hasClass("layui-hide")) {
        dropdown.hideAll();
        return
      }
      dropdown.hideAll();
      p = dropdown.show(t);
      if (p) {
        t.addClass(d);
        t.removeClass("layui-hide");
        var s = dropdown.getTopLeft(q, t, p);
        s = dropdown.checkPosition(t, q, p, s);
        t.css(s);
        $("body").addClass(noScrollClass);
        var r = (q.attr("no-shade") == "true");
        $("body").append('<div class="' + (r ? (shadeClass + " " + g) : shadeClass) + ' layui-anim layui-anim-fadein"></div>');
        q.parentsUntil("body").each(function () {
          var u = $(this).css("z-index");
          if (/[0-9]+/.test(u)) {
            $(this).addClass("dropdown-fix-parent")
          }
        });
        q.addClass(openClass)
      }
    }, forCenter: function (p, u) {
      if (!p.hasClass(d)) {
        var t = p.parent().outerWidth(), q = p.parent().outerHeight();
        var s = p.outerWidth(), v = p.outerHeight();
        var w = u.split("-"), r = w[0], x = w[1];
        if ((r == "top" || r == "bottom") && x == "center") {
          p.css("left", (t - s) / 2)
        }
        if ((r == "left" || r == "right") && x == "center") {
          p.css("top", (q - v) / 2)
        }
      }
    }, getTopLeft: function (B, A, y) {
      var w = B.outerWidth();
      var u = B.outerHeight();
      var p = A.outerWidth();
      var x = A.outerHeight();
      var z = B.offset().top - $(document).scrollTop();
      var t = B.offset().left;
      var D = t + w;
      var C = 0, s = 0;
      var v = y.split("-");
      var r = v[0];
      var q = v[1];
      if (r == "top" || r == "bottom") {
        x += 8;
        switch (q) {
          case"left":
            s = t;
            break;
          case"center":
            s = t - p / 2 + w / 2;
            break;
          case"right":
            s = D - p
        }
      }
      if (r == "left" || r == "right") {
        p += 8;
        switch (q) {
          case"top":
            C = z + u - x;
            break;
          case"center":
            C = z - x / 2 + u / 2;
            break;
          case"bottom":
            C = z
        }
      }
      switch (r) {
        case"top":
          C = z - x;
          break;
        case"right":
          s = t + w;
          break;
        case"bottom":
          C = z + u;
          break;
        case"left":
          s = t - p
      }
      return {top: C, left: s, right: "auto", bottom: "auto"}
    }, checkPosition: function (t, q, p, r) {
      var s = p.split("-");
      if ("bottom" == s[0]) {
        if ((r.top + t.outerHeight()) > dropdown.getPageHeight()) {
          r = dropdown.getTopLeft(q, t, "top-" + s[1]);
          t.removeClass("dropdown-" + p);
          t.addClass("dropdown-top-" + s[1])
        }
      } else {
        if ("top" == s[0]) {
          if (r.top < 0) {
            r = dropdown.getTopLeft(q, t, "bottom-" + s[1]);
            t.removeClass("dropdown-" + p);
            t.addClass("dropdown-bottom-" + s[1])
          }
        }
      }
      return r
    }, getPageHeight: function () {
      return document.documentElement.clientHeight || document.body.clientHeight
    }, getPageWidth: function () {
      return document.documentElement.clientWidth || document.body.clientWidth
    }
  };
  dropdown.init();
  //引入
  layui.link(layui.cache.base + "dropdown/dropdown.css")

  exports("dropdown", dropdown)
});