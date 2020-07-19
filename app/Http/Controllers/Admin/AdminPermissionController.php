<?php

namespace App\Http\Controllers\Admin;

use App\Services\UiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;
use App\Models\Role;

class AdminPermissionController extends BaseCurlController
{
    public $pageName = '权限规则';
    //不共享curl页面,为空表示走自己模板
    public $commonBladePath = '';


    /**
     * 设置模型
     * @return Permission|mixed
     */
    public function setModel()
    {
        return $this->model = new Permission();
    }

    //首页共享数据
    public function indexShareData()
    {
        //设置首页数据替换
        $this->setListConfig(['open_width' => '600px', 'open_height' => '700px']);
        return $this->batchIndexData();//设置批量数据URL
    }


    //首页数据表格数据
    public function indexCols()
    {
        $cols = [
            [
                'type' => 'checkbox'
            ],
            [
                'field' => 'sort',
                'width' => 80,
                'title' => '排序',
                'sort' => 1,
                'align' => 'center',
                'edit'=>1
            ],
            [
                'field' => 'icon',
                'width' => 80,
                'title' => '图标',
                'align' => 'center'
            ],

            [
                'field' => 'cn_name',
                'minWidth' => 120,
                'title' => '名称',
                'align' => 'center'
            ],
            [
                'field' => 'menu_name',
                'minWidth' => 120,
                'title' => '菜单名称',
                'align' => 'center',
                'edit'=>true
            ],
            [
                'field' => 'name',
                'minWidth' => 120,
                'title' => '路由',
                'align' => 'center'
            ],
            [
                'field' => 'menu_show',
                'minWidth' => 80,
                'title' => '菜单是否显示',
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
    //首页按钮设置
    public function setOutputHandleBtnTpl($shareData){
        $default=$this->defaultHandleBtnAddTpl($shareData);
        $data = [

            [
                'class'=>'layui-btn-success',
                'name' => '全部展开',
                'id' => 'btn-expand',

            ],
            [
                'class'=>'layui-btn-dark',
                'name' => '全部折叠',
                'id' => 'btn-fold',
            ],


        ];
        //是否具有批量添加权限
        if($this->isCanBatch()){
            $data[]=[
                'class'=>'layui-btn-info',
                'name' => '批量添加一组权限',
                'data'=>[
                    'data-type'=>"custormAdd",
                    'data-url'=>$this->batchIndexData()['all_create_url'],
                    'data-post_url'=>$this->batchIndexData()['all_post_url'],
                    'data-title'=>'批量添加'.$this->getPageName(),
                    'data-w'=>$this->layuiOpenWidth(),
                    'data-h'=>$this->layuiOpenHeight()
                ]
            ];



        }
        $data=array_merge($default,$data);
        //赋值到ui数组里面必须是`btn`的key值
        $this->uiBlade['btn'] = $data;

    }

    /**
     * 表单验证
     * @param string $id
     * @return array
     */
    public function checkRule($id = '')
    {
        if (!$id) {
            return [
                'name' => 'required',
                'cn_name' => 'required'
            ];
        }
        return [
            'name' => 'required',
            'cn_name' => 'required',

        ];
    }

    /**
     * 设置检验对应字段的名字
     * @return array
     */
    public function checkRuleField()
    {
        $messages = [
            'cn_name' => '权限名称',
            'name' => '权限路由名'

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

    /**
     * 创建/更新共享数据
     * @param string $id
     * @return array
     */
    public function createEditShareData($id = '')
    {
        $roles = $this->getRole();// 获取所有角色
        $cate = $this->getPermission()->toArray();
        $cate=array_merge([['id'=>0,'cn_name'=>'根级','name'=>'','parent_id'=>0]],$cate);

        $cate = tree($cate,'id','parent_id','children');

        return ['roles' => $roles, 'permissions' => $cate];
    }

    //添加和编辑页面表单设置
    public function setOutputUiCreateEditForm($show = '')
    {

        $data = [
            [
                'blade_name'=>'adminPermission.parent',
                'type'=>'blade',
                'name' => '上级',
                'field'=>'parent_id',
                'must'=>1
            ],
            [
                'field' => 'cn_name',
                'type' => 'text',
                'name' => '权限名称',
                'must' => 1,
                'verify' => 'rq'

            ],
            [
                'field' => 'menu_name',
                'type' => 'text',
                'name' => '菜单名称',
                'must' => 1,
                'verify' => 'rq'

            ],
            [
                'field' => 'name',
                'type' => 'text',
                'name' => '路由地址',
                'must' => 1,
                'verify' => 'rq',
                'mark'=>'根级输入:0'

            ],
            [
                'field' => 'icon',
                'type' => 'icon',
                'name' => '图标',
                'must' => 0,
                'verify' => ''

            ],
            [
                'field' => 'sort',
                'type' => 'text',
                'name' => '排序',
                'must' => 1,
                'verify' => '',
                'default'=>0

            ],
            [
                'field' => 'menu_show',
                'type' => 'radio',
                'name' => '是否显示菜单',
                'default' => 0,
                'data' => $this->uiService->trueFalseData()

            ]

        ];
        //如果是批量操作，需要追加是否需要批量操作
        if($this->createFormCurrent=='batch'){
            $data[]=[
                'field' => 'batch_show',
                'type' => 'radio',
                'name' => '是否包含批量操作',
                'default' => 0,
                'data' => $this->uiService->trueFalseData()
            ];
        }

        //赋值到ui数组里面必须是`form`的key值
        $this->uiBlade['form'] = $data;
    }

    //取得角色
    public function getRole()
    {
        return Role::where('guard_name', $this->guardName)->pluck('name', 'id');
    }

    //取得权限
    public function getPermission()
    {
        return Permission::where('guard_name', $this->guardName)->orderBy('sort','desc')->get();
    }

    //表格编辑事件
    public function afterEditTableSuccessEvent($field, array $ids)
    {
        //缓存移除
        Cache::forget("spatie.permission.cache");
    }

    /**
     * JSON 列表输出项目设置
     * @param $item
     * @return mixed
     */
    public function setListOutputItemExtend($item)
    {

        $item->menu_show = UiService::switchTpl('menu_show', $item,'','显示|隐藏');
        $item->handle = UiService::editDelTpl();
        $item->icon = '<i class="' . $item->icon . '"></i>';
        return $item;

    }

    //删除，如果存在下级，则不给删除
    public function checkDelet($id_arr)
    {
        $childs = $this->getModel()->whereIn('parent_id', $id_arr)->count();
        if ($childs) {
            return lang('存在子级，请先删除子级再删除');
        }
    }

    //批量操作
    public function batchCreatePost(Request $request)
    {

        $cn_name = $request->input('cn_name');
        $name = $request->input('name');
        $menu_name = $request->input('menu_name');
        $icon = $request->input('icon');
        $menu_show = $request->input('menu_show', 1);
        //检验表单
        $error = $this->checkForm($request->all(), $this->checkRule(''), $this->checkRuleMsg(), $this->checkRuleField());
        if (count($error) > 0) {
            return $this->checkFormErrorFormat($error);
        };
        if ($cn_name == '' || $name == '') {
            return $this->returnFailApi('缺少参数');
        }

        //批量数据出初始化
        $arr = [
            'create' => $cn_name . lang('添加'),
            'edit' => $cn_name . lang('编辑'),
            'destroy' => $cn_name . lang('删除'),
            'show' => $cn_name . lang('详情')
        ];
        //如果存在批量
        if ($request->input('batch_show')) {
            $arr['batch'] = $cn_name . lang('批量添加');
        }
        $all_data = [];
        //先添加index，然后其他放在这个ID的父级
        $pid = $request->input('parent_id');

        $p_data = [
            'cn_name' => $cn_name,
            'name' => $name . '.index',
            'parent_id' => $pid,
            'menu_name' => $menu_name,
            'guard_name' => $this->guardName,
            'icon' => $icon,
            'menu_show' => $menu_show,
        ];
        DB::beginTransaction();
        $pid_obj = Permission::create($p_data);
        if ($pid_obj) {
            $pid = $pid_obj->id;
        }
        foreach ($arr as $k => $v) {
            $all_data[] = [
                'cn_name' => $v,
                'name' => $name . '.' . $k,
                'parent_id' => $pid,
                'menu_name' => $v,
                'guard_name' => $this->guardName,
                'menu_show' => 0
            ];
        }
        $all_r = Permission::insert($all_data);
        if ($all_r && $pid_obj) {
            DB::commit();
            $this->insertLog($this->getPageName() . lang('批量插入成功'));
            return $this->returnSuccessApi(lang('批量插入成功'));
        } else {
            DB::rollBack();
            $this->insertLog($this->getPageName() . lang('批量插入失败'));
            return $this->returnFailApi(lang('批量插入失败'));
        }

    }
    public function allAfterEvent($type = '')
    {
       Permission::getCache();
    }
}
