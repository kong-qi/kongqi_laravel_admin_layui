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

namespace App\Http\Controllers\Admin;

use Validator;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class LoginController extends BaseController
{
    use AuthenticatesUsers;

    public function showLoginForm()
    {

        $this->setPageName('登录');
        return $this->display();

    }

    public function username()
    {
        return 'account';
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * 登录失败
     * @param Request $request
     * @return array
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return (['code' => 1, 'msg' => lang('账号或密码错误')]);
    }

    protected function validatorForm($request)
    {
        $message_data = [
            $this->username() . '.required' => '请输入账号',
            'password.required' => '请输入密码',
        ];
        $check_data =
            [
                $this->username() => 'required|string',
                'password' => 'required|string'
            ];
        //开启验证码验证
        if (env('ADMIN_OPEN_CAPTCHA', 1)) {
            $check_data['captcha'] = 'required|captcha';
        }
        $validator = Validator::make($request->all(), $check_data, $message_data);
        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return $validator->errors();
            }
        }
        return [];
    }

    public function login(Request $request)
    {
        $error = $this->validatorForm($request);
        if (count($error) > 0) {
            return $this->checkFormErrorFormat($error);
        };
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        //确定用户是否有太多失败的登录尝试。
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            //太多次返回的信息
            return $this->sendLockoutResponse($request);
        }
        if ($this->attemptLogin($request)) {
            //通过之后响应
            return $this->sendLoginResponse($request);
        }
        //增加登陆尝试次数，默认尝试增加1次
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * 登录成功
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticated()
    {
        //更新session_key
        $admin = admin();
        $admin->session_token = Session::getId();
        $admin->last_ip = \request()->getClientIp();
        $admin->login_numbers += 1;
        $admin->save();
        $url = route('admin.index');
        return $this->returnSuccessApi('登录成功', $url);
    }


    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect()->route('admin.login');
    }

}
