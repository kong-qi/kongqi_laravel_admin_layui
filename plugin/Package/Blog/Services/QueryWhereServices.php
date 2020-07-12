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

namespace Plugin\Package\Blog\Services;

use Plugin\Plugin\Services\SearchServices;

class QueryWhereServices extends SearchServices
{
    //这里写的查询条件语句
    //开头格式必须是 whereBy,后面是驼峰形式编写
    //不懂的可以查看plugin/Plugin/Services/QueryWhereTrait.php这里面几个写法参考

    public function whereByQueryLikeAccount($value){
        $data = [
            //'nickname'表示字段
            'account' => [
                'type' => 'like',//搜索条件类型
                'value' => $value //搜索值
            ]
        ];
        $this->addWhere($data);
    }
}