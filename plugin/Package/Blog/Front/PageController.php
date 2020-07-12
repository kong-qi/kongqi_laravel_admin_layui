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

namespace Plugin\Package\Blog\Front;

use Plugin\Package\Blog\Models\Page;
use Plugin\Package\Blog\Models\User;

class PageController extends BaseController
{

    public function show($id)
    {
        $show = Page::find($id);
        return $this->display(['show' => $show, 'title' => $show->name]);
    }

    public function userPage($id)
    {
        $user = User::find($id);
        $list = Page::checked()->whereLike([
            'name' => request()->input('key')
        ])->where('user_id', $id)->with('user')->paginate(10);
        return $this->display(
            [
                'title' => $user->name . '文章',
                'user' => $user,
                'list' => $list,
                'page' => $list->appends(request()->all())->links()
            ]);
    }
}