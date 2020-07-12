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

//后台绑定域名,可在.env下配置

use Illuminate\Support\Facades\Route;

$admin_domain = env('ADMIN_URL', '');
//后台目录
$admin_path = 'admin';
$route_name = 'admin.';

if ($admin_domain) {
    $route = Route::domain($admin_domain);
} else {
    $route = Route::prefix($admin_path ?: '/admin/');
}
$route->name($route_name)->group(function ($route) {
    $route->get('/login', 'LoginController@showLoginForm')->name('login');
    $route->post('login', 'LoginController@login')->name('post.login');
    $route->get('logout', 'LoginController@logout')->name('logout');
});

//验证权限规则前缀

$route->middleware(['admin_auth'])->name($route_name)->group(function ($route) {

    $checkPermissionRoutePrefix = 'admin.';

    $route->get('home', 'HomeController@home')->name('home');
    $route->get('/', 'HomeController@index')->name('index');
    //上传接口
    $route->any('upload/{type}', ['uses' => 'FileUploadController@handle'])->name('upload');
    //导入表格
    $route->any('excel/tpl', ['uses' => 'ExcelController@index'])->name('excel.tpl');

    //资源路由数组
    $resource = [
        'AdminController',
        'AdminRoleController',
        'AdminPermissionController',

        //以下是例子部分的演示,不需要就删除
        'ArticleController',
        'CategoryController',

    ];
    //批量添加控制器
    $batch = [
        'AdminPermissionController',
        //以下是例子部分的演示,不需要就删除
        'CategoryController',

    ];

    //只有首页
    $only_index = [
        'LogController'
    ];

    //首页和添加页面
    $only_index_add = [
        'ConfigController',
    ];
    //首页和添加和编辑页面，没有删除页面
    $only_index_add_edit = [

    ];
    //清除缓存
    $route->get('clear/cache', 'AdminController@clear')->name("clear");

    //管理员修改密码
    $route->get('admin/password', 'AdminController@password')->name("admin.password");
    $route->post('admin/password', 'AdminController@passwordPost')->name("admin.password_post");

    foreach ($resource as $c) {
        //自动获取
        $controller = str_replace('Controller', '', $c);

        $route_name = lcfirst($controller);//首字母小写

        $route->group(['prefix' => $route_name . '/'], function ($route) use ($c, $route_name, $checkPermissionRoutePrefix) {
            $permission_rule = 'permission:' . $checkPermissionRoutePrefix . $route_name . '.';
            $route->get('/', $c . '@index')->name($route_name . ".index")->middleware($permission_rule . 'index');
            $route->get('create', $c . '@create')->name($route_name . ".create")->middleware($permission_rule . 'create');
            $route->get('show/{id}', $c . '@show')->name($route_name . ".show")->middleware($permission_rule . 'show');
            $route->post('store', $c . '@store')->name($route_name . ".store")->middleware($permission_rule . 'create');
            $route->get('edit/{id}', $c . '@edit')->name($route_name . ".edit")->middleware($permission_rule . 'edit');
            $route->put('update/{id}', $c . '@update')->name($route_name . ".update")->middleware($permission_rule . 'edit');
            $route->put('delete/', $c . '@destroy')->name($route_name . ".destroy")->middleware($permission_rule . 'destroy');
            $route->post('edit_list/', $c . '@editTable')->name($route_name . ".edit_list")->middleware($permission_rule . 'edit');
            $route->any('/list', $c . '@getList')->name($route_name . ".list")->middleware($permission_rule . 'index');

        });
    }
    //批量导入和批量添加
    foreach ($batch as $c) {
        //自动获取
        $controller = str_replace('Controller', '', $c);
        $route_name = lcfirst($controller);//首字母小写
        $route->group(['prefix' => $route_name . '/'], function ($route) use ($c, $route_name, $checkPermissionRoutePrefix) {
            $permission_rule = 'permission:' . $checkPermissionRoutePrefix . $route_name . '.';
            $route->get('/batch/create', ['uses' => $c . '@batchCreate'])->name($route_name . '.batch_create')->middleware($permission_rule . "batch");
            $route->post('/batch/create/post', ['uses' => $c . '@batchCreatePost'])->name($route_name . '.batch_create_post')->middleware($permission_rule . "batch");
            $route->post('/import/post', ['uses' => $c . '@importPost'])->name($route_name . '.import_post')->middleware($permission_rule . "import");
            $route->get('/import/tpl', ['uses' => $c . '@importTpl'])->name($route_name . '.import')->middleware($permission_rule . "import");

        });
    }
    //只有首页
    foreach ($only_index as $c) {
        //自动获取
        $controller = str_replace('Controller', '', $c);
        $route_name = lcfirst($controller);//首字母小写

        $route->group(['prefix' => $route_name . '/'], function ($route) use ($c, $route_name, $checkPermissionRoutePrefix) {
            $permission_rule = 'permission:' . $checkPermissionRoutePrefix . $route_name . '.';
            $route->get('/', $c . '@index')->name($route_name . ".index")->middleware($permission_rule . 'index');
            $route->any('/list', ['uses' => $c . '@getList'])->name($route_name . ".list")->middleware($permission_rule . 'index');
        });
    }
    //首页和添加页面
    foreach ($only_index_add as $c) {
        //自动获取
        $controller = str_replace('Controller', '', $c);
        $route_name = lcfirst($controller);//首字母小写
        $route->group(['prefix' => $route_name . '/'], function ($route) use ($c, $route_name, $checkPermissionRoutePrefix) {
            $permission_rule = 'permission:' . $checkPermissionRoutePrefix . $route_name . '.';
            $route->get('/', $c . '@index')->name($route_name . ".index")->middleware($permission_rule . 'index');
            $route->any('/list', ['uses' => $c . '@getList'])->name($route_name . ".list")->middleware($permission_rule . 'index');
            $route->get('create', $c . '@create')->name($route_name . ".create")->middleware($permission_rule . 'create');
            $route->post('store', $c . '@store')->name($route_name . ".store")->middleware($permission_rule . 'create');
        });
    }
    //首页和添加页面，编辑页面
    foreach ($only_index_add_edit as $c) {
        //自动获取
        $controller = str_replace('Controller', '', $c);
        $route_name = lcfirst($controller);//首字母小写
        $route->group(['prefix' => $route_name . '/'], function ($route) use ($c, $route_name, $checkPermissionRoutePrefix) {
            $permission_rule = 'permission:' . $checkPermissionRoutePrefix . $route_name . '.';
            $route->get('/', $c . '@index')->name($route_name . ".index")->middleware($permission_rule . 'index');
            $route->get('create', $c . '@create')->name($route_name . ".create")->middleware($permission_rule . 'create');
            $route->get('show/{id}', $c . '@show')->name($route_name . ".show")->middleware($permission_rule . 'show');
            $route->post('store', $c . '@store')->name($route_name . ".store")->middleware($permission_rule . 'create');
            $route->get('edit/{id}', $c . '@edit')->name($route_name . ".edit")->middleware($permission_rule . 'edit');
            $route->put('update/{id}', $c . '@update')->name($route_name . ".update")->middleware($permission_rule . 'edit');
            $route->post('edit_list/', $c . '@editTable')->name($route_name . ".edit_list")->middleware($permission_rule . 'edit');
            $route->any('/list', ['uses' => $c . '@getList'])->name($route_name . ".list")->middleware($permission_rule . 'index');
        });
    }
    //插件
    //如果关闭插件则不加载
    if (env('OPEN_PLUGIN', 1)) {
        $c = 'PackageController';
        $controller = 'Package';
        $route_name = lcfirst($controller);//首字母小写
        $route->group(['prefix' => 'package' . '/'], function ($route) use ($c, $route_name, $checkPermissionRoutePrefix) {
            $permission_rule = 'permission:' . $checkPermissionRoutePrefix . $route_name . '.';
            $route->get('/', $c . '@index')->name($route_name . ".index")->middleware($permission_rule . 'index');
            $route->get('show/{id}', $c . '@show')->name($route_name . ".show")->middleware($permission_rule . 'show');
            $route->post('store', $c . '@store')->name($route_name . ".store")->middleware($permission_rule . 'create');
            $route->put('update/{id}', $c . '@update')->name($route_name . ".update")->middleware($permission_rule . 'edit');
            $route->post('edit_list/', $c . '@editTable')->name($route_name . ".edit_list")->middleware($permission_rule . 'edit');
            $route->any('/list', ['uses' => $c . '@getList'])->name($route_name . ".list")->middleware($permission_rule . 'index');
            //安装操作
            $route->post('handle/{type}/{id}', $c . '@handlePost')->name($route_name . ".install")->middleware($permission_rule . 'install');
            $route->put('delete/', $c . '@destroy')->name($route_name . ".destroy")->middleware($permission_rule . 'destroy');

        });
    }
});

