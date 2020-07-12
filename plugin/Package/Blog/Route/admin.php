<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Admin')->group(function ($route) {


    //前缀，肯定使我们的插件的标识符，需要加水插件前缀
    $checkPermissionRoutePrefix = 'admin.plugin.Forum.';
    //资源路由数组
    $resource = [
        'PageController',
        'CategoryController',
        'UserController',
        'ConfigController'

    ];
    //批量添加控制器
    $batch = [
        'CategoryController'
    ];

    //只有首页
    $only_index = [

    ];

    //首页和添加页面
    $only_index_add = [

    ];
    //首页和添加和编辑页面，没有删除页面
    $only_index_add_edit = [

    ];

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

});
?>