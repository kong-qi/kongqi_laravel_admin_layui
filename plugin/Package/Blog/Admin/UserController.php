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

namespace Plugin\Package\Blog\Admin;

use App\Services\UiService;
use Plugin\Package\Blog\Models\Cateogry;
use Plugin\Package\Blog\Models\Page;
use Plugin\Package\Blog\Models\User;

class UserController extends BaseCurlController
{
    //那些页面不共享，需要单独设置的方法
    //public $denyCommonBladePathActionName = ['create'];
    //设置页面的名称
    public $pageName = '会员管理';

    //1.设置模型
    public function setModel()
    {
        return $this->model = new User();
    }


    //2.首页的数据表格数组
    public function indexCols()
    {
        //这里99%跟layui的表格设置参数一样
        $data = [
            [
                'type' => 'checkbox'
            ],
            [
                'field' => 'id',
                'width' => 80,
                'title' => '编号',
                'sort' => 1,
                'align' => 'center'
            ],
            [
                'field' => 'name',
                'minWidth' => 150,
                'title' => '昵称',
                'align' => 'center',

            ],
            [
                'field' => 'account',
                'minWidth' => 150,
                'title' => '账号',
                'align' => 'center',

            ],
            [
                'field' => 'thumb',
                'width' => 120,
                'title' => '头像',
                'align' => 'center',
            ],
            [
                'field' => 'is_checked_html',
                'minWidth' => 80,
                'title' => '状态',
                'align' => 'center',
            ],
            [
                'field' => 'created_at',
                'minWidth' => 150,
                'title' => '注册时间',
                'align' => 'center'
            ],
            [
                'field' => 'handle',
                'minWidth' => 150,
                'title' => '操作',
                'align' => 'center'
            ]
        ];
        //要返回给数组
        return $data;
    }

    //3.设置搜索数据表单
    public function setOutputSearchFormTpl($shareData)
    {
        $data = [
            [
                'field' => 'id',
                'type' => 'text',
                'name' => 'ID',
            ],

            [
                'field' => 'query_like_name',//这个搜索写的查询条件在app/TraitClass/QueryWhereTrait.php 里面写
                'type' => 'text',
                'name' => '名称',
            ],
            [
                'field' => 'query_like_account',//这个搜索写的查询条件在app/TraitClass/QueryWhereTrait.php 里面写
                'type' => 'text',
                'name' => '账号',
            ],

            [
                'field' => 'query_is_checked',
                'type' => 'select',
                'name' => '是否启用',
                'default' => '',
                'data' => $this->uiService->trueFalseData(1)

            ]

        ];
        //赋值到ui数组里面必须是`search`的key值
        $this->uiBlade['search'] = $data;
    }

    //4.编辑和添加页面表单数据
    public function setOutputUiCreateEditForm($show = '')
    {

        $data = [

            [
                'field' => 'name',
                'type' => 'text',
                'name' => '会员昵称',
                'must' => 1,
                'verify' => 'rq'
            ],
            [
                'field' => 'account',
                'type' => 'text',
                'name' => '登录账号',
                'must' => 1,
                'verify' => 'rq'
            ],
            [
                'field' => 'password',
                'type' => 'text',
                'name' => '密码',
                'must' => 1,
                'mark' => $show ? '不修改默认为空' : '',
                'verify' => $show ? '' : 'rq',
                'value'=>''
            ],
            [
                'field' => 'is_checked',
                'type' => 'radio',
                'name' => '是否启用',
                'verify' => '',
                'default' => 1,
                'data' => $this->uiService->trueFalseData()
            ]

        ];

        //赋值到ui数组里面必须是`form`的key值
        $this->uiBlade['form'] = $data;
    }

    //5.写验证规则
    public function checkRule($id = '')
    {
        $rule= [
            'name'=>'required',
            'account'=>'required',
            'password'=>'required'
        ];
        if($id){
            unset($rule['password']);
        }
        return $rule;
    }

    //弹窗大小
    public function layuiOpenWidth()
    {
        return '600px'; // TODO: Change the autogenerated stub
    }

    public function layuiOpenHeight()
    {
        return '500px'; // TODO: Change the autogenerated stub
    }

    public function setListOutputItemExtend($item)
    {
        $item->category_name = $item->category['name'] ?? '';
        $item->thumb=UiService::layuiTplImg($item->thumb);
        return $item;
    }


}