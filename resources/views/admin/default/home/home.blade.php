@extends('admin.default.layouts.baseCont')
@section('content')
    <div class="layui-row layui-col-space15">
        <div class="layui-card shadow panel">

            <div class="layui-card-header">{{ lang('版本信息') }}
                <div class="panel-action"  >
                    <a href="#" data-perform="panel-collapse"><i  title="点击可折叠" class="layui-icon layui-icon-subtraction"></i></a>
                </div>
            </div>
            <div class="layui-card-body ">
                <div class="table-responsive">

                    <table class="layui-table layui-text">

                        <tbody>
                        <tr>
                            <td>
                                {{ lang("系统名称") }}
                            </td>
                            <td>
                                {{ config('copyright.system_name') }}
                            </td>
                        </tr>
                        <tr>
                            <td>{{ lang("主题版本") }}</td>
                            <td>Layui Admin</td>
                        </tr>
                        <tr>
                            <td>{{ lang("当前版本") }}</td>
                            <td>
                                {{ config('copyright.system_version') }}
                                <a href="//{{ config('copyright.docs_url') }}" target="_blank"
                                   style="padding-left: 15px;">{{ lang("文档手册") }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ lang("基于框架") }}</td>
                            <td>
                                PHP + Laravel {{ app()->version() }}

                            </td>
                        </tr>
                        <tr>
                            <td>{{ lang("主要特色") }}</td>
                            <td>{{ config('copyright.feature') }}</td>
                        </tr>
                        <tr>
                            <td>{{ lang("许可") }}</td>
                            <td style="padding-bottom: 0;">

                                {{ lang('准许MIT协议，允许你重新修改和包装，但需要保留版权信息') }}

                            </td>
                        </tr>
                        <tr>
                            <td>{{ lang("作者") }}</td>
                            <td style="padding-bottom: 0;">
                                {{ config('copyright.author') }}

                            </td>
                        </tr>
                        <tr>
                            <td>{{ lang("联系我") }}</td>
                            <td style="padding-bottom: 0;">
                                <p>QQ: {{ config('copyright.qq') }}</p>
                                <p>Email: {{ config('copyright.qq') }}@qq.com</p>
                            </td>
                        </tr>
                        <tr>
                            <td>提供服务</td>
                            <td>如果你有项目需要外包，可以联系我，在家全职做技术。可开发票签合同。</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>


        <div class="layui-card">
            <div class="layui-card-header">基本用法</div>
            <div class="layui-card-body" style="padding: 25px 15px 20px 15px;">
                <div class="layui-btn-container">
                    <div class="dropdown-menu dropdown-hover">
                        <button class="layui-btn icon-btn">
                            &nbsp;Hover方式触发 <i class="layui-icon layui-icon-drop"></i></button>
                        <ul class="dropdown-menu-nav">
                            <li><a>1st menu item</a></li>
                            <li><a>2nd menu item</a></li>
                            <li><a>3rd menu item</a></li>
                        </ul>
                    </div>
                    <div class="dropdown-menu">
                        <button class="layui-btn icon-btn">
                            &nbsp;点击方式触发 <i class="layui-icon layui-icon-drop"></i>
                        </button>
                        <ul class="dropdown-menu-nav">
                            <div class="dropdown-anchor"></div>
                            <li><a>1st menu item</a></li>
                            <li><a>2nd menu item</a></li>
                            <li><a>3rd menu item</a></li>
                        </ul>
                    </div>
                    <div class="dropdown-menu dropdown-hover">
                        <button class="layui-btn icon-btn">
                            &nbsp;带箭头指示 <i class="layui-icon layui-icon-drop"></i>
                        </button>
                        <ul class="dropdown-menu-nav">
                            <div class="dropdown-anchor"></div>
                            <li><a>1st menu item</a></li>
                            <li><a>2nd menu item</a></li>
                            <li><a>3rd menu item</a></li>
                        </ul>
                    </div>
                    <div class="dropdown-menu dropdown-hover">
                        <button class="layui-btn icon-btn">
                            更多样式 <i class="layui-icon layui-icon-drop"></i></button>
                        <ul class="dropdown-menu-nav">
                            <li class="title">HEADER</li>
                            <li><a><i class="layui-icon layui-icon-star-fill"></i>1st menu item</a></li>
                            <li class="disabled">
                                <a><i class="layui-icon layui-icon-template-1"></i>2nd menu item</a></li>
                            <hr>
                            <li class="title">HEADER</li>
                            <li><a><i class="layui-icon layui-icon-set-fill"></i>3rd menu item</a></li>
                        </ul>
                    </div>
                </div>
                <div class="layui-btn-container" style="margin-top: 15px;">
                    <div class="dropdown-menu dropdown-hover">
                        <button class="layui-btn layui-btn-normal icon-btn">
                            无限子级 <i class="layui-icon layui-icon-drop"></i></button>
                        <ul class="dropdown-menu-nav">
                            <li class="title">HEADER</li>
                            <li><a><i class="layui-icon layui-icon-star-fill"></i>1st menu item</a></li>
                            <li class="have-more">
                                <a><i class="layui-icon layui-icon-template-1"></i>2nd menu item&nbsp;&nbsp;</a>
                                <ul class="dropdown-menu-nav-child">
                                    <li><a>1st menu item</a></li>
                                    <li><a>2nd menu item</a></li>
                                    <li><a>3rd menu item</a></li>
                                </ul>
                            </li>
                            <hr>
                            <li class="title">HEADER</li>
                            <li class="have-more">
                                <a><i class="layui-icon layui-icon-set-fill"></i>3rd menu item&nbsp;&nbsp;</a>
                                <ul class="dropdown-menu-nav-child">
                                    <li><a>1st menu item</a></li>
                                    <li><a>2nd menu item</a></li>
                                    <li class="have-more">
                                        <a>3rd menu item</a>
                                        <ul class="dropdown-menu-nav-child">
                                            <li><a>1st menu item</a></li>
                                            <li><a>2nd menu item</a></li>
                                            <li class="have-more">
                                                <a>3rd menu item</a>
                                                <ul class="dropdown-menu-nav-child">
                                                    <li><a>1st menu item</a></li>
                                                    <li><a>2nd menu item</a></li>
                                                    <li><a>3rd menu item</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <button class="layui-btn layui-btn-normal icon-btn" data-dropdown="#dropdownExp1">
                        &nbsp;显示遮罩层 <i class="layui-icon layui-icon-drop"></i></button>
                </div>
                <div class="dropdown-menu dropdown-hover" style="width: 135px;">
                    <input type="text" placeholder="可用于任意元素" class="layui-input"/>
                    <ul class="dropdown-menu-nav">
                        <li class="title">是不是在找他们啊</li>
                        <li><a>一个的输入框</a></li>
                        <li><a>优雅的Laravel</a></li>
                    </ul>
                </div>
            </div>
        </div>




    </div>
@endsection