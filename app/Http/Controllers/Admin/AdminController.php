<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class AdminController extends BaseCurlController
{
    //页面信息
    public $pageName = '账号';
    public $denyCommonBladePathActionName = ['password'];

    //1.设置模型
    public function setModel()
    {
        $this->model = new Admin();

    }


    //2.首页设置列表显示的信息
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
                'field' => 'account',
                'minWidth' => 80,
                'title' => '账号',
                'align' => 'center',
                'hide' => true
            ],
            [
                'field' => 'nickname',
                'minWidth' => 80,
                'title' => '昵称',
                'align' => 'center'
            ],
            [
                'field' => 'roles_name',
                'minWidth' => 80,
                'title' => '角色',
                'align' => 'center'
            ],
            [
                'field' => 'is_checked_html',
                'minWidth' => 80,
                'title' => '状态',
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

    //3.设置搜索部分
    public function setOutputSearchFormTpl($shareData)
    {
        $data = [
            [
                'field' => 'id',
                'type' => 'text',
                'name' => 'ID',
            ],
            [
                'field' => 'query_like_nickname',
                'type' => 'text',
                'name' => '昵称',
            ],

            [
                'field' => 'query_is_root',
                'type' => 'select',
                'name' => '是否超级管理员',
                'on' => '1',
                'data' => array_merge([['id' => '', 'name' => '全部']], $this->uiService->trueFalseData())

            ],
            [
                'field' => 'query_is_checked',
                'type' => 'select',
                'name' => '是否启用',
                'on' => '',
                'data' => array_merge([['id' => '', 'name' => '全部']], $this->uiService->trueFalseData())

            ]

        ];
        //赋值到ui数组里面必须是`search`的key值
        $this->uiBlade['search'] = $data;
    }

    //4.添加和编辑页面表单设置
    public function setOutputUiCreateEditForm($show = '')
    {
        $role = Role::get()->toArray();
        $nrole = [];
        foreach ($role as $k => $v) {
            $nrole[] = ['id' => $v['id'], 'name' => $v['cn_name']];
        }

        $data = [
            [
                'field' => 'nickname',
                'type' => 'text',
                'name' => '昵称',
                'must' => 1,
                'verify' => 'rq'

            ],
            [
                'field' => 'account',
                'type' => 'text',
                'name' => '账号',
                'must' => 1,
                'verify' => 'rq'

            ],
            [
                'field' => 'password',
                'type' => 'text',
                'name' => '密码',
                'must' => 1,
                'verify' => $show ? '' : 'rq',
                // 'remove'=>$show?'1':0,//1表示移除，编辑页面不出现
                'value' => '',
                'mark' => $show ? '不填表示不修改密码' : '',

            ],

            [
                'field' => 'is_root',
                'type' => 'radio',
                'name' => '是否超级管理员',
                'default' => 0,
                'data' => $this->uiService->trueFalseData()

            ],
            [
                'field' => 'is_checked',
                'type' => 'radio',
                'name' => '是否启用',
                'verify' => '',
                'default' => 1,
                'data' => $this->uiService->trueFalseData()

            ],
            [
                'field' => 'roles',
                'type' => 'checkbox',
                'name' => '角色',
                'verify' => '',
                'value' => $show ? $show->roles->pluck('id')->toArray() : [],
                'data' => $nrole

            ]

        ];

        //赋值到ui数组里面必须是`form`的key值
        $this->uiBlade['form'] = $data;
    }

    //5.表单验证规则
    public function checkRule($id = '')
    {
        $data = [
            'account' => 'required|unique:admins,account',
            'nickname' => 'required',
            'password' => 'required'
        ];
        //$id值存在表示编辑的验证
        if ($id) {
            $data['password'] = '';
            $data['account'] = 'required|unique:admins,account,' . $id;
        }
        return $data;
    }


    //6.编辑和添加页面共享数据
    public function createEditData($show = '')
    {
        $permissions = Role::select(['name as route_name', 'id', 'cn_name as name'])->where('guard_name', $this->guardName)->get();
        return ['role' => $permissions];

    }

    //设置分配角色
    public function afterSaveSuccessEvent($model, $id = '')
    {
        $role = $this->rq->input('roles');
        if ($role) {
            $model->syncRoles($role);
        }
    }

    //列表数据附加信息
    public function setListOutputItemExtend($item)
    {
        $item->roles_name = implode(",", $item->roles->pluck('cn_name')->toArray());
        return $item;
    }

    //加载with
    public function setModelRelaction($model)
    {
        return $model->with('roles');
    }

    public function password()
    {

        $this->buildUi();
        $this->uiBlade['form'] = [
            [
                'field' => 'old_password',
                'type' => 'text',
                'name' => '旧密码',
                'must' => 1,
                'verify' => 'rq',
            ],
            [
                'field' => 'password',
                'type' => 'text',
                'name' => '新密码',
                'must' => 1,
                'verify' => 'rq',
            ],
        ];
        $this->createBladeHtml();
        return $this->display();
    }

    public function passwordPost(Request $request)
    {

        $error = $this->checkForm($request->all(), [
            'old_password' => 'required',
            'password' => 'required',
        ], [], ['old_password' => '旧密码']);
        if (count($error) > 0) {
            return $this->checkFormErrorFormat($error);
        };
        //检验密码是否正确
        $old_password = $request->input('old_password');
        $new_password = $request->input('password');
        $admin = admin();
        if (Hash::check($old_password, $admin->password)) {
            //进行更新
            $admin->password = ($new_password);
            $r = $admin->save();
            if ($r) {
                $this->insertLog('修改密码成功');
                return $this->returnSuccessApi('修改密码成功');
            }
            $this->insertLog('修改密码失败');
            return $this->returnFailApi('修改密码失败');
        }
        $this->insertLog('修改密码,旧密码不正确');
        return $this->returnFailApi('旧密码不正确');
    }

    public function clear()
    {
        //执行数据库迁移
        Artisan::call('cache:clear');
        return $this->bladeError(lang('清除成功'), '200');
    }
}
