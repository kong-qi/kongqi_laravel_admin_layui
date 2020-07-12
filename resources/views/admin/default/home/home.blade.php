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




    </div>
@endsection