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

use Plugin\Package\Blog\Models\Category;
use Plugin\Package\Blog\Models\Page;
use Plugin\Package\Blog\Models\User;

class PageController extends BaseCurlController
{
    //那些页面不共享，需要单独设置的方法
    //public $denyCommonBladePathActionName = ['create'];
    //设置页面的名称
    public $pageName = '文章资讯';

    //1.设置模型
    public function setModel()
    {
        return $this->model = new Page();
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
                'title' => '名称',
                'align' => 'center',

            ],
            [
                'field' => 'category_name',
                'minWidth' => 120,
                'title' => '分类名称',
                'align' => 'center'
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
                'title' => '发布时间',
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
                'field' => 'query_user_id',
                'type' => 'text',
                'name' => '会员ID',
            ],
            [
                'field' => 'query_like_name',//这个搜索写的查询条件在app/TraitClass/QueryWhereTrait.php 里面写
                'type' => 'text',
                'name' => '名称',
            ],
            [
                'field' => 'query_category_id',
                'type' => 'select',
                'name' => '分类',
                'default' => '1',
                'data' => array_merge([['id' => '', 'name' => '全部']], Category::get()->toArray())

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
                'name' => '标题',
                'must' => 1,
                'verify' => 'rq'
            ],
            [
                'field' => 'user_id',
                'type' => 'select',
                'name' => '会员',
                'verify' => 'rq',
                'data' => array_merge($this->uiService->allDataArr('请选择会员'), User::checked()->get()->toArray())//树形select

            ],
            [
                'field' => 'category_id',
                'type' => 'select',
                'name' => '分类',
                'must' => 1,
                'verify' => 'rq',
                'on' => 0,
                'data' => array_merge($this->uiService->allDataArr('请选择分类'), $this->uiService->treeData(Category::checked()->get()->toArray(), 0))//树形select
            ],
            [
                'field' => 'is_checked',
                'type' => 'radio',
                'name' => '是否启用',
                'verify' => '',
                'default' => 1,
                'data' => $this->uiService->trueFalseData()
            ]
            ,
            [
                'field' => 'content',
                'type' => 'editor',
                'editor_type' => 'simple',
                'name' => '正文',
                'verify' => 'rq',
                'must' => 1
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
            'content'=>'required',
            'category_id'=>'required',
            'user_id'=>'required',
        ];
        if($id){
            unset($rule['password']);
        }
        return $rule;
    }

    //弹窗大小
    public function layuiOpenWidth()
    {
        return '80%'; // TODO: Change the autogenerated stub
    }

    public function layuiOpenHeight()
    {
        return '80%'; // TODO: Change the autogenerated stub
    }

    public function setListOutputItemExtend($item)
    {
        $item->category_name = $item->category['name'] ?? '';
        return $item;
    }

    public function setModelRelaction($model)
    {
        return $model->with('category');
    }
}