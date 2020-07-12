<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Models\Role;
use App\Services\UiService;

class AdminRoleController extends BaseCurlController
{
    public $pageName = '权限角色';
    //那些页面不共享，需要单独设置的方法


    /**
     * 设置模型
     * @return mixed|void
     */
    public function setModel()
    {
        $this->model = new Role();
    }

    //首页设置列表显示的信息
    public function indexCols()
    {
        $cols = [
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
                'field' => 'cn_name',
                'minWidth' => 120,
                'title' => '名称',
                'align' => 'center',

            ],

            [
                'field' => 'mark',
                'title' => '说明',
                'align' => 'center',

            ],

            [
                'field' => 'handle',
                'minWidth' => 150,
                'title' => '操作',
                'align' => 'center'
            ]

        ];

        return $cols;
    }

    //4.设置搜索部分
    public function setOutputSearchFormTpl($shareData)
    {
        $data = [
            [
                'field' => 'id',
                'type' => 'text',
                'name' => 'ID',
            ],
            [
                'field' => 'query_like_name',
                'type' => 'text',
                'name' => '名称',
            ]

        ];
        //赋值到ui数组里面必须是`search`的key值
        $this->uiBlade['search'] = $data;
    }


    public function permissions($permissions, $role = '')
    {

        $permissions = tree($permissions);
        foreach ($permissions as $key1 => $item1) {
            $permissions[$key1]['own'] = $role ? $role->hasPermissionTo($item1['id']) ? 'checked' : false : false;
            if (isset($item1['_child'])) {
                foreach ($item1['_child'] as $key2 => $item2) {
                    $permissions[$key1]['_child'][$key2]['own'] = $role ? $role->hasPermissionTo($item2['id']) ? 'checked' : false : false;
                    if (isset($item2['_child'])) {
                        foreach ($item2['_child'] as $key3 => $item3) {
                            $permissions[$key1]['_child'][$key2]['_child'][$key3]['own'] = $role ? $role->hasPermissionTo($item3['id']) ? 'checked' : false : false;
                        }
                    }
                }
            }

        }
        return $permissions;
    }

    //编辑和添加共享数据
    public function createEditShareData($show = '')
    {
        $permissions = Permission::where('guard_name', $this->guardName)->get()->toArray();
        $permissions = $this->permissions($permissions, $show);
        return ['permissions' => $permissions];

    }

    //添加和编辑页面表单设置
    public function setOutputUiCreateEditForm($show = '')
    {

        $data = [
            [
                'field' => 'cn_name',
                'type' => 'text',
                'name' => '名称',
                'must' => 1,
                'verify' => 'rq'

            ],
            [
                'field' => 'name',
                'type' => 'text',
                'name' => '标识符',
                'must' => 1,
                'verify' => 'rq'

            ],
            [
                'field' => 'mark',
                'type' => 'textarea',
                'name' => '描述',
                'mark' => '可为空',

            ],
            [
                'field' => 'blade',
                'type' => 'blade',
                'blade_name' => 'adminRole.permission',
                'mark' => '',
                'name'=>'请分配权限',
                'must'=>1

            ]


        ];
        //赋值到ui数组里面必须是`form`的key值
        $this->uiBlade['form'] = $data;
    }

    //表单验证
    public function checkRule($id = '')
    {
        if (!$id) {
            return [
                'name' => 'required|unique:roles,name',
                'permissions' => 'required',
            ];
        }
        return [
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'required',

        ];
    }

    //表单验证字段对应名称
    public function checkRuleFieldName()
    {
        $messages = [
            'name' => '名称',
            'permissions' => '权限规则必填',
        ];
        return $messages;
    }


    /**
     * 添加提交附加数据
     * @param $model
     * @return mixed
     */
    public function addPostData($model)
    {
        $model->guard_name = $this->guardName;
        return $model;
    }

    //提交入口成功之后事件
    public function afterSaveSuccessEvent($model, $id = '')
    {
        $permissions = $this->rq->input('permissions');
        //更新操作
        $model->syncPermissions($permissions);

    }

    /**
     * 列表附加数据
     * @param $item
     * @return mixed|void
     */
    public function setListOutputItemExtend($item)
    {


        $item->is_checked_html = '';

        return $item;
    }


}
