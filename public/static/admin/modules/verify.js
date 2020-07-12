layui.define(['uform'], function (exports) {
  var $ = layui.$,
    form = layui.uform;

  form.verify({
    //验证英文字符
    ename: function (value, item) { //value：表单的值、item：表单的DOM对象
      if (!new RegExp("^[a-zA-Z][a-zA-Z0-9_]*$").test(value)) {
        return appLang.trans('请使用英文字母开头字符');
      }

    },
    //中文
    cn: [
      /^[\u4e00-\u9fa5]+$/,
      appLang.trans('必须是中文')
    ],
    //必填
    rq: function (value, item) {
      //自动获取
      var title = $(item).attr('placeholder') || $(item).attr('data-tips');
      if (!value) {
        return appLang.trans('必填') + title;
      }

    },
    number: function (value, item) {
      //自动获取
      var title = $(item).attr('placeholder') || $(item).attr('data-tips');
      if (isNaN(value)) {
        return title + appLang.trans('必须是数字');
      }
    },
    required: function (value, item) {
      //自动获取
      var title = $(item).attr('placeholder') || $(item).attr('data-tips');
      if (!value) {
        return appLang.trans('必填') + title;
      }
    },
    //验证最大数值
    max_number: function (value, item) { //value：表单的值、item：表单的DOM对象
      var max2 = $(item).attr('max');
      value = parseInt(value);
      is_true = value > max2 ? 1 : 0;
      if (is_true) {
        return appLang.trans('不能超过') + max2;
      }
    },
    //验证最小数值
    min_number: function (value, item) {
      var min2 = $(item).attr('min');
      value = parseInt(value);
      is_true = value < min2 ? 1 : 0;
      if (is_true) {
        return appLang.trans('不能小于') + min2;
      }
    },
    //图片验证
    img: function (value, item) {
      var title = $(item).attr('placeholder') || $(item).attr('data-tips');
      if (!value) {
        return appLang.trans('请上传') + title || '请上传必填图片';
      }

    },
    //复选框
    checkbox: function (value, item) {
      //获得checkbox的名字
      var checkbox_name = $(item).attr('name');
      var length = $(item).data('min');
      length = length || 1;//可以把上面第一种方案改成这种，更加优化
      var title = $(item).parents('.checkbox-tips').data('tips');
      var size_length = $("[name='" + checkbox_name + "']:checked").length;
      if (size_length < length) {
        $(item).parent(".layui-input-block").addClass('layui-form-danger');
        return '请选择' + title + '最少' + length + '项' || '必填一项';
      }
    },
    //单选按钮
    radio: function (value, item) {
      //获得checkbox的名字
      var checkbox_name = $(item).attr('name');
      //自动获取
      var title = $(item).parents('.radio-tips').data('tips');
      var size_length = $("[name='" + checkbox_name + "']:checked").length;
      if (!size_length) {
        return appLang.trans('请选择') + title;
      }
    }


  });


  exports('verify', {});
});