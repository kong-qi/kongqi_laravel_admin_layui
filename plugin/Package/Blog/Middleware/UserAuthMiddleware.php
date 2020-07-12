<?php

namespace Plugin\Package\Blog\Middleware;


use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;

class UserAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $guard = 'blog_user';

        if (Auth::guard($guard)->guest()) {
            return $this->authCheck('login',$request);;
        } else {
            //判断是否被禁用
            $user = Auth::guard($guard)->user();
            if ($user['is_checked'] == 0) {
                Auth::guard($guard)->logout();
                $request->session()->invalidate();
                return $this->authCheck('checked',$request);
            }
        }

        return $next($request);
    }

    public function authCheck($type = '', $request)
    {
        $json_data = ['code' => 1000, 'msg' => lang('请登陆后操作'), 'url' => route('plugin.blog.front.login')];
        if ($type == 'checked') {
            $json_data = ['code' => 401, 'msg' => lang('账号被禁用'), 'url' => route('plugin.blog.front.login')];
        }
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($json_data);
        } else {
            if ($type == 'login') {
                return redirect()->route('plugin.blog.front.login');
            } else {
                return abort(419,lang('账号被禁用'));

            }

        }
    }
}