@extends('admin.default.layouts.base')
@section('add_css')
    <link rel="stylesheet" href="{{___('/admin/style/login.css')}}">
    <script>
        //登录页面在iframe下进行修复，新建打开
        if(top.location!=self.location){
            parent.window.location.reload();
        }
    </script>
@endsection
@section('content')
    <div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login">

        <div class="layadmin-user-login-main">
            <div class="layadmin-user-login-box layadmin-user-login-header">
                <h2>{{ config('copyright.site_name') }}</h2>
                <p>{{config('copyright.system_version')}}</p>
            </div>
            <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
                @csrf
                <div class="layui-form-item">
                    <label class="layadmin-user-login-icon layui-icon layui-icon-username"
                           for="LAY-user-login-username"></label>
                    <input type="text" name="account" id="LAY-user-login-username" lay-verify="rq"
                           placeholder="用户名" class="layui-input">
                </div>
                <div class="layui-form-item">
                    <label class="layadmin-user-login-icon layui-icon layui-icon-password"
                           for="LAY-user-login-password"></label>
                    <input type="password" name="password" id="LAY-user-login-password" lay-verify="rq"
                           placeholder="密码" class="layui-input">
                </div>
                @if(env('ADMIN_OPEN_CAPTCHA',1))
                <div class="layui-form-item">
                    <div class="layui-row">
                        <div class="layui-col-xs7">
                            <label class="layadmin-user-login-icon layui-icon layui-icon-vercode"
                                   for="LAY-user-login-vercode"></label>
                            <input type="text" name="captcha" id="LAY-user-login-vercode" lay-verify="required"
                                   placeholder="图形验证码" class="layui-input">
                        </div>
                        <div class="layui-col-xs5">
                            <div class="ml-10 border-default">
                                <img src="{{ route('api.captcha',['type'=>env('ADMIN_CAPTCHA_TYPE','admin')]) }}"
                                     data-src="{{ route('api.captcha',['type'=>env('ADMIN_CAPTCHA_TYPE','admin')]) }}"
                                     class="layadmin-user-login-codeimg" id="LAY-user-get-vercode">
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="layui-form-item mb-20" >
                    <input type="checkbox" name="remember" value="1"  title="{{ lang('记住密码') }}">

                </div>
                <div class="layui-form-item">
                    <button class="layui-btn layui-btn-fluid layui-btn-success" lay-submit lay-filter="login-submit">{{ lang('登录') }}</button>
                </div>

            </div>
        </div>

        <div class="layui-trans layadmin-user-login-footer">

            <p>© 2012-{{ date('Y') }} <a href="//{{config('copyright.domain')}}" target="_blank">{{ config('copyright.author') }}</a></p>

        </div>


    </div>

@endsection
@section('foot_js')
    <script>

        var postLoginUrl = '{{ route('admin.post.login') }}';

        layui.use(['uform', 'request'], function () {

          var $ = layui.$
            , request = layui.request
            , form = layui.uform
            , layer = layui.layer;

          //提交
          form.on('submit(login-submit)', function (obj) {
            console.log('提交了');
            request.post(postLoginUrl, obj.field, function (res) {
              if (res.code != 200) {
                layer.msg(res.msg, {icon: 5, shift: 6});
                //刷新验证码
                $("#LAY-user-get-vercode").click();
              } else {
                layer.msg(res.msg, {icon: 1, shift: 6});
                location.href = res.data; //后台主页
              }
            })
          });
          $(".layui-form").bind("keydown", function (e) {
            var theEvent = e || window.event;
            var code = theEvent.keyCode || theEvent.which || theEvent.charCode;
            if (code == 13) {
              $("[lay-submit]").click();
            }
          });
          //更换图形验证码
          $("body").on('click', '#LAY-user-get-vercode', function () {
            var othis = $(this);
            this.src = othis.data('src') + '?t=' + new Date().getTime()
          });

        })
    </script>
@endsection