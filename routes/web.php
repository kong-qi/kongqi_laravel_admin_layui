<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});


//验证码
Route::prefix('api/')->group(function ($route) {
    $route->get('captcha/{type?}', 'Api\CaptchaController@index')->name('api.captcha');

});
