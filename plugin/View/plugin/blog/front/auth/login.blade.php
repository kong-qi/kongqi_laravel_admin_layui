@extends('plugin.blog.front.layouts.base')
@section('content')
    <form class="form-signin" action="{{ proute('blog.loginPost') }}" method="post">
        @csrf
        @include('plugin.blog.front.layouts.tips')
        <div class="text-center mb-4">
            <img class="mb-4" src="{{ res_url(config_cache('blog.logo')) }}" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">{{ config_cache('blog.name') }}</h1>

        </div>

        <div class="form-label-group">
            <input type="text" name="account" id="inputEmail" class="form-control" placeholder="账号" required=""
                   autofocus="">

        </div>

        <div class="form-label-group">
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="密码" required="">

        </div>

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="1" name="remember"> 记住我
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
        <p class="mt-5 mb-3 text-muted text-center">© 2017-2020</p>
    </form>
@endsection