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


namespace App\Http\Middleware;

use App\Exceptions\ErrorException;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CheckPermission
{
    public function handle($request, Closure $next, $permission)
    {
        if (app('auth')->guard('admin')->guest()) {
            throw new ErrorException(['code'=>403,'msg'=>lang('还没有登录')]);
        }
        //权限调试区间开启全部通过
        if(env('CHECK_ADMIN_DEBUG')){
           return $next($request);
        }
        //超级管理员通过

        if(admin('is_root')==1){
            return $next($request);
        }
        $permissions = is_array($permission)
            ? $permission
            : explode('|', $permission);


        foreach ($permissions as $permission) {
            if (acan($permission)) {
                return $next($request);
            }
        }
        throw new ErrorException(['code'=>403,'msg'=>lang('没有权限中间件')]);

    }
}
