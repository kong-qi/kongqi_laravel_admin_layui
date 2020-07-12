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

use Plugin\Plugin\Controller\Front\PluginController;

class BaseController extends PluginController
{

    /**
     * 设置资源缓存版本号
     * @return string
     */
    public function setResVersion($version)
    {
        $this->resVersion = config_cache_default('blog.cache_version','1.0');

        return $this->resVersion;
    }
    /**
     * @param $title
     * @param $keyword
     * @param $desc
     * @param int $type
     * @return array
     */
    public function setSeo($title, $keyword, $desc, $type = 0)
    {

        $data = [
            'title' => $title,
            'keyword' => $keyword,
            'description' => $desc
        ];

        view()->share($data);
        return $data;
    }
}