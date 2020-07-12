<?php


use Illuminate\Support\Facades\Route;

//绑定域名
$domain = config_cache('blog.domain');
//路径
$path =config_cache_default('blog.path','blog');

//如果绑定了域名则走域名，如果绑定了路径，则走路径，只能2选一, 如果你需要多个，那你下面改下即可
if ($domain) {
    $route = Route::domain($domain);
} else {
    $route = Route::prefix($path);
}


$route->namespace('Front')->group(function ($route) {
    //写你的路由啊
    $route->get('/','IndexController@index')->name('index');
    $route->get('category/{id}','IndexController@category')->name('category');
    $route->get('loginOut','AuthController@loginOut')->name('loginOut');
    $route->get('login','AuthController@login')->name('login');
    $route->get('register','AuthController@register')->name('register');
    $route->post('registerPost','AuthController@registerPost')->name('registerPost');
    $route->post('loginPost','AuthController@loginPost')->name('loginPost');
    $route->get('register','AuthController@register')->name('register');
    $route->get('user-{id}','PageController@userPage')->name('userPage');
    $route->get('{id}','PageController@show')->name('show');

});

?>