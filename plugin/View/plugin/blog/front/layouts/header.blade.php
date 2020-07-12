<nav class="navbar navbar-expand navbar-dark flex-column flex-md-row bd-navbar mb-4">
    <a class="navbar-brand" href="{{ proute('blog.index') }}">{{ config_cache_default('blog.name','Blog') }}</a>

    <div class="navbar-nav-scroll mr-3 ml-3">
        <ul class="navbar-nav mr-auto">
            @php
                $category=pn_blog_category();
            @endphp
            @if(!empty($category))
                @foreach($category as $k=>$v)
                    <li class="nav-item active">
                        <a class="nav-link"
                           href="{{ proute('blog.category',['id'=>$v['id']]) }}">{{ $v['name'] }}</a>
                    </li>
                @endforeach
            @endif

        </ul>
    </div>
    <form class="form-inline my-2 my-lg-0 " action="?">
        <div class="input-group">
            <input class="form-control " name="key" value="{{ request()->input('key') }}" type="search"
                   placeholder="关键词" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-warning my-sm-0" type="submit">搜索</button>
            </div>
        </div>
    </form>
    <div class="flex-grow-1 ">

        <div class="text-white text-center  text-md-right ">
            @guest('blog_user')
                <a href="{{ proute('blog.register') }}" class="btn btn-sm  text-white">注册</a> | <a
                        href="{{ proute('blog.login') }}" class="btn btn-sm text-white">登录</a>
            @endguest
            @auth('blog_user')

                    <a href="{{ proute('blog.userPage',['id'=>pn_blog_user('id')]) }}" class="btn btn-sm  text-white">{{ pn_blog_user('name') }}</a>
                    <a
                            href="{{ proute('blog.loginOut') }}" class="btn btn-sm text-white">退出 ></a>
            @endauth
        </div>
    </div>
</nav>