<!-- 侧边菜单 -->
<div class="layui-side layui-side-menu">
    <div class="layui-side-scroll">
        <div class="layui-logo" >
            <span>{{ lang('管理后台') }} 2.0</span>
        </div>

        <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu"
            lay-filter="layadmin-system-side-menu">

            @php
                $menu=admin_menu();

            @endphp
            @if(!empty($menu))
                @foreach($menu as $k=>$v)
                    @if($v['menu_show'])
                        @if(isset($v['_child']) && !empty($v['_child']) && array_sum(array_column($v['_child'],'menu_show'))>0 )
                            {{--检验是否有任意一个子权限--}}



                            @if(acan_anys(array_column($v['_child'],'name')))
                                <li data-name="home" class="layui-nav-item">

                                        <a href="javascript:;" >
                                            <i class="{{ $v['icon'] }}"></i>
                                            <cite>{{ lang($v['menu_name']) }}</cite>
                                        </a>

                                    <dl class="layui-nav-child">
                                        @foreach($v['_child'] as $k2=>$v2)
                                            @if(acan($v2['name']))
                                                @if($v2['menu_show'])
                                                    <dd>
                                                        <a lay-href="{{ nroute($v2['name']) }}">{{ lang($v2['cn_name']) }}</a>
                                                    </dd>
                                                @endif
                                            @endif
                                        @endforeach
                                    </dl>
                                </li>

                            @endif
                        @else
                            @if(!empty($v['name']) && acan($v['name']) )

                                <li data-name="get" class="layui-nav-item">
                                    <a href="javascript:;" lay-href="{{ $v['name']?nroute($v['name']):'' }}">
                                        <i class="{{ $v['icon'] }}"></i>
                                        <cite>{{ lang($v['menu_name']) }}</cite>
                                    </a>
                                </li>
                            @endif
                        @endif
                    @endif
                @endforeach
            @endif
        </ul>
    </div>
</div>

