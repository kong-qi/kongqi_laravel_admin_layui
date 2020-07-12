<?php

namespace Plugin\Package\Blog\Front;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Validator;
use Plugin\Package\Blog\Models\User;

class AuthController extends BaseController
{
    use ThrottlesLogins;
    public function login()
    {


        if (pn_blog_user()) {
            return redirect()->route('plugin.blog.index');
        }

        $data = [];
        $title = '会员登录';
        $this->setSeo($title, $title, $title);
        return $this->display($data);
    }
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'account' => 'required|string',
            'password' => 'required|string',
        ]);
    }
    protected function attemptLogin(Request $request)
    {
        $login = [
            'account' => $request->input('account'),
            'password' => $request->input('password'),
        ];
        return $this->guard()->attempt(
            $login, $request->filled('remember')
        );
    }

    public function username()
    {
        return 'account';
    }

    //提交登录
    public function loginPost(Request $request)
    {

        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {

            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    protected function sendLoginResponse(Request $request)
    {
        //生成新的session
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        return $this->authenticated($request, $this->guard()->user());
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'account' => ['账号或密码不正确'],
        ]);
    }

    public function register()
    {
        $title = '会员注册';
        $this->setSeo($title, $title, $title);
        return $this->display();
    }

    //操作权限的认证组
    protected function guard()
    {
        return Auth::guard('blog_user');
    }

    public function registerPost(Request $request)
    {
        $this->registValidator($request->all())->validate();
        $user = $this->create($request->all());
        $this->guard()->login($user);
        return $this->authenticated($request, $user);
    }

    //创建会员
    protected function create(array $data)
    {
        unset($data['_token']);
        $data['is_checked'] = 1;
        return User::create($data);
    }

    //登录成功跳转
    protected function authenticated(Request $request, $user)
    {
        //判断是否被禁用
        //dd($user->is_checked);

        if ($user['is_checked'] == 0) {
            //退出
            $this->guard()->logout();
            $request->session()->invalidate();
            return $this->bladeError('账号被禁用', 401);
        }

        return redirect()->intended(proute('blog.index'));

    }

    /**
     * 注册验证
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function registValidator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'account' => ['required', 'string', 'unique:pn_blog_users'],
            'password' => ['required', 'string', 'min:6'],
        ]);
    }

    public function loginOut()
    {
        Auth::guard('blog_user')->logout();
        \request()->session()->invalidate();
        return redirect()->route('plugin.blog.login');

    }
}