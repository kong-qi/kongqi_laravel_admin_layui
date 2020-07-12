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

use Illuminate\Http\Request;

class ExcelController extends BaseCurlController
{
    public $commonBladePath = '';//不需要公用

    public function indexShareData()
    {

        $this->setOutputUiCreateEditForm('');

    }

    //4.编辑和添加页面表单数据
    public function setOutputUiCreateEditForm($show = '')
    {

        $data = [
            [
                'field' => 'excel',
                'type' => 'img',
                'name' => '上传Execel',
                'must' => 1,
                'verify' => 'rq',
                'file_type' => 'office',
                'accept_type' => 'file',
                'oss_type'=>'local',//存储到本地
                'value_name' => 'origin_path',//这里取得上传的值，这里不需要补域名的路径
            ],
            [
                'field' => 'is_del',
                'type' => 'radio',
                'name' => '是否删除原来数据',
                'verify' => '',
                'default' => 1,
                'data' => $this->uiService->trueFalseData()
            ]

        ];

        //赋值到ui数组里面必须是`formShowBtn`的key值,这里会显示按钮图标
        $this->uiBlade['form'] = $data;
        //如果存在数据赋值，这个备用，只有单页的时候采用到，平时的编辑页面自动注入
        $this->uiBlade['show'] = $show;

    }
}
