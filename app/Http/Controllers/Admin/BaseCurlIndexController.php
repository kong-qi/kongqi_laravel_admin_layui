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

class BaseCurlIndexController extends BaseCurlController
{
    //没有添加和编辑页面
    public function editUrlShow($item)
    {
        $item['edit_url'] = '';
        $item['edit_post_url'] = '';
        return $item;
    }

    //列表操作按钮去掉
    public function listHandleBtnCreate($item)
    {
        $this->uiBlade['btn'] = [];
    }
    //首页按钮去掉
    public function setOutputHandleBtnTpl($shareData)
    {
        //默认首页顶部添加按钮去掉
        $this->uiBlade['btn']=[];
    }
}