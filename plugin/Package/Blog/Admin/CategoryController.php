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



use Illuminate\Http\Request;
use Plugin\Package\Blog\Models\Category;

class CategoryController extends BaseCurlController
{
    //那些页面不共享，需要单独设置的方法
    //设置页面的名称
    public $pageName = '分类';
    public $denyCommonBladePathActionName = ['index'];

    //1.设置模型
    public function setModel()
    {
        return $this->model = new Category();
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
                'field' => 'sort',
                'width' => 80,
                'title' => '排序',
                'sort' => 1,
                'align' => 'center',
                'edit' => 1
            ],

            [
                'field' => 'name',
                'minWidth' => 150,
                'title' => '名称',
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
                'title' => '创建时间',
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

    //首页按钮设置
    public function setOutputHandleBtnTpl($shareData)
    {
        $default = $this->defaultHandleBtnAddTpl($shareData);
        $data = [

            [
                'class' => 'btn-success',
                'name' => '全部展开',
                'id' => 'btn-expand',

            ],
            [
                'class' => 'btn-dark',
                'name' => '全部折叠',
                'id' => 'btn-fold',
            ],

        ];
        //是否具有批量添加权限
        if (($this->isCanBatch())) {
            $data[] = [
                'class' => 'btn-info',
                'name' => '批量添加',
                'data' => [
                    'data-type' => "custormAdd",
                    'data-url' => $this->batchIndexData()['all_create_url'],
                    'data-post_url' => $this->batchIndexData()['all_post_url'],
                    'data-title' => '批量添加' . $this->getPageName(),
                    'data-w' => $this->layuiOpenWidth(),
                    'data-h' => $this->layuiOpenHeight()
                ]
            ];
            //下载模板
            $data[]=[
                'class'=>'btn-secondary',
                'name' => '下载导入模板',
                'data'=>[
                    'data-event'=>"link",
                    'data-url'=>$this->batchIndexData()['import_tpl_url'],

                ]
            ];
            //导入数据
            $data[]=[
                'class'=>'btn-dark',
                'name' => '导入Excel',
                'data'=>[
                    'data-type'=>"import",
                    'data-post_url'=>$this->batchIndexData()['import_post_url'],
                    'data-title'=>'导入添加'.$this->getPageName(),
                    'data-w'=>$this->layuiOpenWidth(),
                    'data-h'=>$this->layuiOpenHeight()
                ]
            ];
        }
        $data = array_merge($default, $data);
        //赋值到ui数组里面必须是`btn`的key值
        $this->uiBlade['btn'] = $data;

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
                'field' => 'query_is_checked',
                'type' => 'select',
                'name' => '是否启用',
                'default' => '',
                'data' => $this->uiService->trueFalseData(1)

            ]

        ];
        //赋值给UI数组里面，必须是search这个key
        $this->uiBlade['search'] = $data;
    }

    //4.编辑和添加页面表单数据
    public function setOutputUiCreateEditForm($show = '')
    {
        //如果是批量添加位置，需要把name转换成textarea
        $name = [];
        if ($this->createFormCurrent == 'batch') {
            $name['type'] = 'textarea';
            $name['mark'] = '一行一条记录';
        } else {
            $name['type'] = 'text';

        }

        $data = [
            [
                'field' => 'name',
                'type' => $name['type'],
                'name' => '名称',
                'must' => 1,
                'verify' => 'rq',
                'mark' => $name['mark'] ?? ''
            ],

            [
                'field' => 'parent_id',
                'type' => 'select',
                'name' => '上级',
                'must' => 1,
                'verify' => 'rq',
                'default' => 0,
                'data' => array_merge([['id'=>0,'name'=>'根级','parent_id'=>0]],$this->uiService->treeData(Category::checked()->get()->toArray()))
            ],
            [
                'field' => 'sort',
                'type' => 'text',
                'name' => '排序',
                'must' => 1,
                'default' => 0,
                'verify' => 'rq'
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
        //赋值给UI数组里面,必须是form为key
        $this->uiBlade['form'] = $data;

    }



    /**
     * 批量写入数据的数据
     * @param Request $request
     */
    public function batchCreateSetData(Request $request)
    {
        $name = $request->input('name');
        if (empty($name)) {
            return [];
        }
        $name = explode("\n", $name);

        $data = [];
        foreach ($name as $k => $v) {
            if($v===''){
                continue;
            }
            $data[] = [
                'name' => $v,
                'parent_id' => $request->input('parent_id'),
                'sort' => $request->input('sort'),
                'is_checked' => $request->input('is_checked')
            ];

        }
        return $data;
    }


}