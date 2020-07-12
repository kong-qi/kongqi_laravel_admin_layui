<div class="layui-header">
    <!-- 头部区域 -->
    <ul class="layui-nav layui-layout-left">
        <li class="layui-nav-item layadmin-flexible" lay-unselect>
            <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
                <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
            </a>
        </li>
        <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;" layadmin-event="refresh" title="刷新">
                <i class="layui-icon layui-icon-refresh-3"></i>
            </a>
        </li>

    </ul>
    <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">

       {{-- <li class="layui-nav-item" lay-unselect>
            <a lay-href="app/message/index.html" layadmin-event="message" lay-text="消息中心">
                <i class="layui-icon layui-icon-notice"></i>

                <!-- 如果有新消息，则显示小圆点 -->
                <span class="layui-badge-dot"></span>
            </a>
        </li>--}}
        <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="theme">
                <i class="layui-icon layui-icon-theme"></i>
            </a>
        </li>

        <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="fullscreen">
                <i class="layui-icon layui-icon-screen-full"></i>
            </a>
        </li>
        <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;">
                <cite>{{ admin('nickname') }}</cite>
            </a>
            <dl class="layui-nav-child">
                <dd><a lay-href="{{ nroute('admin.log.index') }}">{{ lang('操作日志') }}</a></dd>
                <dd><a href="javascript:void(0)" ui-event="openIframePost"
                       data-title="{{ lang('修改密码') }}"
                       data-w="400px" data-h="300px"
                       data-url="{{ nroute('admin.admin.password') }}"
                       data-post_url="{{ nroute('admin.admin.password_post') }}">修改密码</a></dd>
                <hr>
                <dd layadmin-event="logout" style="text-align: center;"><a href="{{ nroute('admin.logout') }}">退出</a></dd>
            </dl>
        </li>

        <li class="layui-nav-item layui-hide-xs" lay-unselect style="width: 20px">
            <a href="javascript:;"></a>
          {{--  <a href="javascript:;" layadmin-event="about"><i class="layui-icon layui-icon-more-vertical"></i></a>--}}
        </li>

    </ul>
</div>

