<?php
// +----------------------------------------------------------------------
// | KongQiAdminBase [ Laravel快速后台开发 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012~2019 http://www.kongqikeji.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kongqi <531833998@qq.com>`
// +----------------------------------------------------------------------

namespace Plugin\Package\Blog\Admin;

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