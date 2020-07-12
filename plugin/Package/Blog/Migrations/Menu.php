<?php
// +----------------------------------------------------------------------
// | KQAdmin [ 基于Laravel后台快速开发后台 ]
// | 快速laravel后台管理系统，集成了，图片上传，多图上传，批量Excel导入，批量插入，修改，添加，搜索，权限管理RBAC,验证码，助你开发快人一步。
// +----------------------------------------------------------------------
// | Copyright (c) 2012~2019 www.haoxuekeji.cn All rights reserved.
// +----------------------------------------------------------------------
// | Laravel 原创视频教程，文档教程请关注 www.heibaiketang.com
// +----------------------------------------------------------------------
// | Author: kongqi <531833998@qq.com>`
// +----------------------------------------------------------------------
// 用于安装菜单的权限规则里面的

namespace Plugin\Package\Blog\Migrations;

use App\ExtendClass\Plugin;

class Menu
{
    public static $name = '博客系统';//根级菜单名称
    public static $icon = 'layui-icon layui-icon-heart-fill';//根级菜单图标


    public static function up()
    {
        /**
         * 必须第一个插件的，其他都是子插件
         * 路有名称路径
         * forum.admin.页面控制名称（去除Controller）.控制器方法名称（小驼峰）,例如下面
         * forum.admin.categoryExtend.helloWord
         * form.admin.category.hello
         */
        $module='blog';
        $data = [
            Plugin::pluginMenuNameData('博客配置', $module.'.admin.config.index', 1,1),
            Plugin::groupCurlRouteData('文章管理', 'fa fa-files', '1', $module.'.admin.page'),//一组权限
            Plugin::groupCurlRouteData('分类管理', 'fa fa-files', '1', $module.'.admin.category'),//一组权限
            Plugin::groupCurlRouteData('会员管理', 'fa fa-files', '1', $module.'.admin.user'),//一组权限

        ];

        return $data;
    }


}