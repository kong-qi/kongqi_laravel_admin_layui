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

namespace App\TraitClass;

use App\Services\UiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait ModelCurlTrait
{

    use GetListTrait;
    public $model;//当前数据库操作的模型
    public $rq;//创建，更新，搜索页面的request
    protected $modelSaveMsg;//模型验证错误输出数据
    protected $createEditLastId;//创建或更新入库的最后ID值
    protected $resultMsgOut;//结果信息输出定义
    protected $formSearchSelf = false;//是否单独设置自己的form搜索模板true 表示是
    protected $uiBlade = [];//存储uiBlade数据
    protected $createFormCurrent = '';//创建表单位置标识符，编辑，创建，批量
    protected $createEditfootAddJavascript = '';//底部是否增加自己控制的js模板设置，请直接写你的当前模块js写的模板路径例如：footJs,无需写前缀admin.default.adv.
    protected $indexfootAddJavascript = '';//数据列表首页增加自己控制的js模块.跟上面的配置一样

    //设置indexRequst默认值
    public function indexRequestValue()
    {
        //设置request默认值
        //\request()->request->set('nav_id', '');
    }

    //设置添加和编辑默认值
    public function createEditRequestValue()
    {
        //\request()->request->set('nav_id', '');
    }

    /**
     * 创建视图文件
     */
    public function index()
    {
        $this->indexRequestValue();
        $this->getListConfig();
        $cols = $this->indexCols();
        if ($cols) {
            $cols = UiService::createLayuiTable($cols);
        }
        //绑定Ui
        $this->buildUi();
        $indexShareData = $this->indexShareData();
        //搜索数据
        $this->setOutputSearchFormTpl($indexShareData);

        //按钮
        $this->setOutputHandleBtnTpl($indexShareData);

        //首页cols JSON 数据
        if (!empty($cols)) {
            $this->shareData(['cols' => [$cols]]);
        }

        $this->shareData(
            [
                'index_list_tips' => $this->indexTips(),
                'indexfootAddJavascript' =>$this->getIndexFooterAddJavascript()
            ]
        );
        //将btn和搜索数据写入到变量里面
        $this->createBladeHtml();

        return $this->display($indexShareData ?: []);
    }
    public function getIndexFooterAddJavascript(){
        return $this->indexfootAddJavascript?$this->getOriginBladePath().$this->indexfootAddJavascript:'';
    }

    /**
     * 首页提示内容框
     */
    public function indexTips()
    {
        return '';
    }

    /**
     * 创建html 代码并共享数据
     * 具体实现代码 app/Services/BootstrapUi.php
     */
    public function createBladeHtml($show = '')
    {
        if (!empty($this->uiBlade)) {
            foreach ($this->uiBlade as $k => $v) {
                if (isset($this->uiBlade['show']) && !empty($this->uiBlade['show'])) {
                    $show = $this->uiBlade['show'];
                }
                switch ($k) {
                    case 'search':
                        $this->shareData(['search_form_tpl' => $this->uiService->createFormSearchInput($v)]);
                        break;
                    case 'btn':
                        $this->shareData(['index_handle_btn_tpl' => $this->uiService->createBtn($v), 'index_handle_btn_number' => count($v)]);
                        break;
                    case 'form':
                        $this->shareData(['form_tpl' => $this->uiService->createFormInput($v, $show)]);
                        $this->shareData(['body_bg' => 'layui-bg-white']);
                        $this->listenIsEditorInput($v);
                        break;
                    case 'formShowBtn':

                        $this->shareData(['form_tpl' => $this->uiService->createFormInput($v, $show, 1)]);
                        $this->shareData(['body_bg' => 'layui-bg-white']);
                        $this->listenIsEditorInput($v);
                        break;
                }
            }
        }
    }

    /**
     * 监听页面是否存在编辑器类型
     * @param $data
     */
    public function listenIsEditorInput($data)
    {


        $editor = [];
        foreach ($data as $k => $v) {


            if (isset($v['group_name'])) {
                foreach ($v['data'] as $k2 => $v2) {

                    if ($v2['type'] == 'editor') {
                        $v2['id'] = $v2['id'] ?? $v2['field'];
                        $v2['editor_type'] = $v2['editor_type'] ?? 'summernote';
                        if (empty($v2['editor_type'])) {
                            $v2['editor_type'] = 'summernote';
                        }

                        $editor[] = [
                            'id' => 'input-' . $v2['id'],
                            'type' => $v2['editor_type']
                        ];
                    }
                }
            } else {
                $v['id'] = $v['id'] ?? $v['field'];
                if ($v['type'] == 'editor') {
                    $v['editor_type'] = $v['editor_type'] ?? 'summernote';
                    if (empty($v['editor_type'])) {
                        $v['editor_type'] = 'summernote';
                    }
                    $editor[] = [
                        'id' => 'input-' . $v['id'] ?? $v['filed'],
                        'type' => $v['editor_type']
                    ];
                }

            }
        }

        $this->shareData(['editor_create' => $editor]);
    }

    //批量编辑页面
    public function batchIndexData()
    {
        $item['all_create_url'] = action($this->getRouteInfo('controller_name') . '@batchCreate', \request()->all());
        $item['all_post_url'] = action($this->getRouteInfo('controller_name') . '@batchCreatePost', \request()->all());
        $item['import_tpl_url'] = action($this->getRouteInfo('controller_name') . '@importTpl', \request()->all());
        $item['import_post_url'] = action($this->getRouteInfo('controller_name') . '@importPost', \request()->all());
        return $item;
    }


    /**
     * 首页cols数据
     * @return array
     */
    public function indexCols()
    {
        return [];
    }

    /**
     * 搜索数据生成
     * @param $shareData 传递共享数据
     */
    public function setOutputSearchFormTpl($shareData)
    {

    }

    /**
     * 首页按钮生成数据
     * @param $shareData
     */
    public function setOutputHandleBtnTpl($shareData)
    {
        return $this->uiBlade['btn'] = $this->defaultHandleBtnAddTpl($shareData);

    }

    /*
     * 首页默认按钮
     */
    public function defaultHandleBtnAddTpl($shareData)
    {
        $data = [];
        if ($this->isCanCreate()) {

            $data[] = [
                'name' => '添加',
                'data' => [
                    'data-type' => "add"
                ]
            ];
        }
        if ($this->isCanDel()) {
            $data[] = [
                'class' => 'layui-btn-danger',
                'name' => '删除',
                'data' => [
                    'data-type' => "allDel"
                ]
            ];
        }

        return $data;
    }

    public function defaultHandleBtnDelTpl($shareData)
    {
        $data = [];

        if ($this->isCanDel()) {
            $data[] = [
                'class' => 'btn-danger',
                'name' => '删除',
                'data' => [
                    'data-type' => "allDel"
                ]
            ];
        }

        return $data;
    }

    /**
     * Layui 弹窗宽度
     * @return string
     */
    public function layuiOpenWidth()
    {
        return '100%';
    }

    /**
     * Layui 弹窗高度
     * @return string
     */
    public function layuiOpenHeight()
    {
        return '100%';
    }


    /**
     * 首页配置参数
     * @return array
     */
    public function getListConfig($listMethod = '')
    {
        $data = [
            'index_url' => naction($this->getRouteInfo('controller_name') . '@getList', request()->all()),//首页列表JSON地址
            'table_name' => $this->getModelTableName(),
            'page_name' => lang($this->getPageName()),
            'del_url' => naction($this->getRouteInfo('controller_name') . '@destroy'),//删除提交地址
            'edit_field_url' => naction($this->getRouteInfo('controller_name') . '@editTable'),//表格编辑提交地址
            'create_url' => naction($this->getRouteInfo('controller_name') . '@create', request()->all()),//创建页面地址
            'store_url' => naction($this->getRouteInfo('controller_name') . '@store'),
            'open_height' => $this->layuiOpenHeight(),//Layui 弹窗弹出高度
            'open_width' => $this->layuiOpenWidth(),//Layui 弹窗高度窗口
        ];
        //设置form，搜索路径

        $this->shareData(['form_search_self' => $this->formSearchSelf]);
        $this->shareData(['index_config' => $data]);

        return $data;
    }


    /**
     * 设置首页配置参数
     * @param $data
     */
    public function setListConfig($data)
    {
        $data = $data + $this->getListConfig();
        $this->shareData(['index_config' => $data]);
    }

    /**
     * 创建视图文件
     */
    public function create()
    {
        $this->createEditRequestValue();
        $this->buildUi();
        $this->createFormCurrent = 'create';
        $this->setOutputUiCreateEditForm();
        $this->createBladeHtml();
        $this->shareData(['footAddJavascript' => $this->getFootJavascriptBlade()]);
        return $this->display($this->createEditShareData() ?: []);
    }

    public function getFootJavascriptBlade()
    {
        $origin_blade_path = $this->getOriginBladePath();
        return $this->createEditfootAddJavascript ? $origin_blade_path . $this->createEditfootAddJavascript : '';
    }



    /**
     * 编辑页面
     */
    /**
     * 编辑页面
     * @param $id
     */
    public function edit($id)
    {
        $this->createEditRequestValue();
        $show = $this->editWhere()->findOrFail($id);
        if (!$show) {
            return $this->bladeError(lang('数据不存在'));
        }

        $this->editGate($show);

        $this->buildUi();
        $this->createFormCurrent = 'edit';
        $this->setOutputUiCreateEditForm($show);
        $this->createBladeHtml($show);

        $this->shareData(['show' => $show, 'footAddJavascript' => $this->getFootJavascriptBlade()]);
        return $this->display($this->createEditShareData($show) ?: []);
    }

    /**
     * 复制操作
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function copy(Request $request)
    {
        $id = $request->input('id');
        $form_model = $this->getModel()->find($id);
        $origin_model = $form_model->replicate();
        $r = $origin_model->save();
        if ($r) {
            $this->afterCopySuccess($form_model, $origin_model);
            $this->allAfterEvent('copy');
            $this->insertLog($this->getPageName() . lang('复制成功'));
            return $this->returnSuccessApi(lang('复制成功'));
        }
        $this->insertLog($this->getPageName() . lang('失败'));
        $this->afterCopyFail($form_model, $origin_model);
        return $this->returnFailApi(lang('失败'));

    }

    /**
     * 编辑信息策略，就跟Laravel 的policy一样，只是这里用方法代替
     * @param $show 数据
     */
    public function editGate($show)
    {

    }

    /**
     * 显示策略验证
     * @param $show
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function showGate($show)
    {

    }

    /**
     * 批量操作H
     * @return mixed
     */
    public function batchCreate(Request $request)
    {
        $this->buildUi();
        $this->createFormCurrent = 'batch';
        $this->setOutputUiCreateEditForm();
        $this->createBladeHtml();
        $this->shareData(['footAddJavascript' => $this->getFootJavascriptBlade()]);
        return $this->display($this->createEditShareData(''));
    }


    /**
     * 创建提交操作
     */
    public function store(Request $request)
    {
        $model = $this->getModel();
        return $this->saveData($request, $model);
    }

    /**
     * POST更新
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $model = $this->editWhere()->findOrFail($id);
        return $this->saveData($request, $model, $id);
    }

    /**
     * 显示输出
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $show = $this->showWhere()->find($id);
        if (!$show) {
            return $this->bladeError(lang('数据不存在'));
        }
        $this->showGate($show);
        $this->shareData(['show' => $show]);
        return $this->display($this->showShareData($show) ?: []);
    }

    /**
     * 显示数据共享数据
     * @param $show
     */
    public function showShareData($show)
    {

    }

    /**
     * 是否关闭删除操作
     */
    public function closeDestroy()
    {
        return false;//true 表示允许删除
    }

    /**
     * 删除
     * @param $id
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        if ($this->closeDestroy()) {
            return $this->returnFailApi(lang('不允许删除'));
        }
        //主键IDS
        $ids = $request->input('ids');
        $type_id = $request->input('type_id');
        //分割ids
        $id_arr = explode(',', $ids);

        $id_arr = is_array($id_arr) ? $id_arr : [$id_arr];
        if (empty($id_arr)) {

            return $this->returnFailApi(lang('没有选择数据'));
        }
        $error = $this->checkDelet($id_arr);
        if ($error) {
            return $this->returnFailApi($error);
        }
        //过滤ids
        $id_arr = $this->delFilterIds($id_arr);
        //可以通过此方法删除数据之前先获取数据存储备用
        $model = $this->delAddWhere();
        $this->deleteGetData($model, $id_arr);
        //是否开启事务删除
        $is_transaction = $this->delIsTransaction();

        $id_ok_del = 0;
        if ($is_transaction) {
            DB::beginTransaction();
            $r = $model->whereIn($type_id, $id_arr)->delete();
            //需要事务一起操作的事件
            $trans_r = $this->delTransactionEvent($type_id, $id_arr);
            if ($r && $trans_r) {
                $id_ok_del = 1;
            }
            DB::rollBack();
        } else {
            $id_ok_del = $model->whereIn($type_id, $id_arr)->delete();
        }
        if ($id_ok_del) {
            //删除成功之后要操作的事件
            $this->deleteSuccessAfter($id_arr);
            $this->allAfterEvent('del');
            $this->insertLog($this->getPageName() . lang('成功删除ids') . '：' . implode(',', $id_arr));
            return $this->returnSuccessApi(lang('删除成功'));
        }
        //失败之后要操作事
        $this->deleteFailAfter($id_arr);
        $this->insertLog($this->getPageName() . lang('刪除失败编号') . '：' . implode(',', $id_arr));
        return $this->returnFailApi(lang('删除失败'));

    }

    /**
     * 删除是否开启事务
     */
    protected function delIsTransaction()
    {
        return false;
    }

    /**
     * 删除事务事件
     * @param $type_id
     * @param $ids 主表IDS
     * @return bool 事务返回真才会删除
     */
    public function delTransactionEvent($type_id, $ids)
    {
        return true;
    }

    /**
     * 批量操作方法
     * @param Request $request
     * @return array
     */
    public function batchCreatePost(Request $request)
    {
        $this->rq = $request;
        //检验表单
        $error = $this->batchCreateCheckForm();
        if (count($error) > 0) {
            return $this->checkFormErrorFormat($error);
        };

        //写入
        $post_data = $this->batchCreateSetData($request);
        if (empty($post_data)) {
            return $this->returnFailApi($this->batchCreateErrorMsg());
        }
        //附加检验
        $extend_check = $this->batchCreateExtendValidate();
        if (is_array($extend_check) && count($extend_check) > 0) {
            return $this->returnApiData($extend_check);
        }
        $r = $this->getModel()->insert($post_data);
        if ($r) {
            $this->afterBatchSuccessCreateEvent($post_data);//批量添加成功之后的事件
            $this->insertLog($this->getPageName() . lang('批量插入成功'));
            $this->allAfterEvent('batch');
            return $this->returnSuccessApi(lang('批量插入成功'));
        }
        $this->afterBatchFailCreateEvent($post_data);
        $this->insertLog($this->getPageName() . lang('批量插入失败'));
        return $this->returnFailApi(lang('批量插入失败'));
    }

    //批量添加错误信息
    public function batchCreateErrorMsg()
    {
        return lang('缺少数据');
    }

    /**
     * 批量写入数据的数据
     * @param Request $request
     */
    public function batchCreateSetData(Request $request)
    {
    }

    /**
     * 批量操作表单验证
     * @return array
     */
    protected function batchCreateCheckForm()
    {
        //检验表单
        return $this->checkForm($this->checkRuleData($this->rq), $this->checkBatchRule(), $this->checkRuleMsg(), $this->checkRuleFieldName());

    }


    /**
     * 页面表格数据编辑
     * @param Request $request
     * @return mixed
     */
    public function editTable(Request $request)
    {
        $this->rq = $request;
        $ids = $request->input('ids'); // 修改的表主键id批量分割字符串
        //分割ids
        $id_arr = explode(',', $ids);

        $id_arr = is_array($id_arr) ? $id_arr : [$id_arr];

        if (empty($id_arr)) {
            return $this->returnFailApi(lang('没有选择数据'));
        }
        //表格编辑过滤IDS
        $id_arr = $this->editTableFilterIds($id_arr);

        $field = $request->input('field'); // 修改哪个字段
        $value = $request->input('field_value'); // 修改字段值
        $id = 'id'; // 表主键id值

        $type_r = $this->editTableTypeEvent($id_arr, $field, $value);

        if ($type_r) {
            return $type_r;
        } else {
            $r = $this->editTableAddWhere()->whereIn($id, $id_arr)->update([$field => $value]);
            if ($r) {
                $this->insertLog($this->getPageName() . lang('成功修改ids') . '：' . implode(',', $id_arr));
            } else {
                $this->insertLog($this->getPageName() . lang('失败ids') . '：' . implode(',', $id_arr));
            }
            return $this->editTablePutLog($r, $field, $id_arr);
        }

    }

    /**
     * 编辑表格写入日志
     * @param $r
     * @param $field
     * @param $id_arr
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function editTablePutLog($r, $field, $id_arr)
    {
        if ($r) {
            $this->afterEditTableSuccessEvent($field, $id_arr);
            $this->allAfterEvent('edit_table');
            return $this->returnSuccessApi($this->setEditTableResultMsg($field, $r));
        }
        $this->afterEditTableFailEvent($field, $id_arr);
        return $this->returnFailApi($this->setEditTableResultMsg($field, $r));
    }

    /**
     * 编辑设置表格错误提示
     * @param $field
     * @param $r
     * @return string
     */
    public function setEditTableResultMsg($field, $r)
    {
        //存在自定义，输出自定义
        if ($this->resultMsgOut) {
            return $this->resultMsgOut;
        }
        if ($r) {

            return lang('修改成功');
        }
        return lang('修改失败');
    }

    /**
     * 过滤表格编辑IDS
     * @param array $ids
     * @return array
     */
    public function editTableFilterIds(array $ids)
    {
        return $ids;
    }


    /**
     * 自定义表格编辑事件
     * @param $ids
     * @param $field
     * @param $value
     * @return bool
     */
    public function editTableTypeEvent($ids, $field, $value)
    {
        return false;
    }

    /**
     * 创建和更新操作
     * @param $request
     * @param $model 操作类，创建,更新对应的类,
     * @param string $id 创建为空，更新为当前的ID
     * @return array|\Illuminate\Http\JsonResponse
     */
    protected function saveData($request, $model, $id = '')
    {
        $this->rq = $request;
        $error = $this->checkForm($this->checkRuleData($request), $this->checkRule($id), $this->checkRuleMsg(), $this->checkRuleFieldName());
        if (count($error) > 0) {
            return $this->checkFormErrorFormat($error);
        };
        //附加检验
        $extend_check = $this->extendValidate($model, $id);
        if (is_array($extend_check) && count($extend_check) > 0) {
            return $this->returnApiData($extend_check);
        }
        //设置请求参数
        $data = $this->postData($id);

        //参数赋值给模型
        $model = $this->setFieldValue($model, $data);
        //附加POST数据
        $model = $this->addPostData($model);
        //是否开启事务
        $begin = $this->isTransaction($data, $id);
        //更新/添加之前要操作的事
        $this->beforeSaveEvent($model, $id);

        //赋值模型后的附加验证
        $model = $this->extendModelValidate($model, $id);
        //检测之前是否有问题
        if (is_array($this->modelSaveMsg) && count($this->modelSaveMsg) > 0) {
            return $this->returnApiData($this->modelSaveMsg);
        }

        //$begin=1表示开启事务操作
        if ($begin != 0) {
            DB::beginTransaction();
            $result = $model->save();
            //插入/更新最后ID
            $result ? $this->createEditLastId = $model->id : '';
            //事务的操作，之后的需要返回真才能够完成，否则失败
            $after_result = $this->afterSaveEvent($model, $id);
            if ($result && $after_result) {
                DB::commit();
                //入库/编辑成功之后要操作的事
                $this->afterSaveSuccessEvent($model, $id);
            } else {
                DB::rollback();
            }
        } else {
            //非事务操作
            $result = $model->save();
            $result ? $this->createEditLastId = $model->id : '';
            //入库/编辑成功之后要操作的事
            $this->afterSaveSuccessEvent($model, $id);
        }
        //返回信息
        return $this->saveMessage($result, $id);
    }


    /**
     * 表格导入
     * @param Request $request
     * @return mixed
     */
    public function importPost(Request $request)
    {
        //是否情况之前的
        $is_del = $request->input('is_del');
        $file = str_replace("\\", "/", public_path()) . (str_replace(url('/'), "", $request->input('excel')));
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);

        $worksheet = $spreadsheet->getActiveSheet();
        $sheetdata = $worksheet->toArray();
        //进行批量插入
        if (empty($sheetdata)) {
            return $this->returnFailApi(lang('空数据'));
        }
        $title_data = $sheetdata[0];
        $insert_data = [];
        if (!isset($sheetdata[1])) {
            return $this->returnFailApi(lang('空数据'));
        }
        $data = $sheetdata;
        unset($data[0]);
        try {
            foreach ($data as $k => $v) {
                foreach ($v as $sk => $sv) {
                    $insert_data[$k][$title_data[$sk]] = $sv;
                }
            }

        } catch (\Exception $exception) {
            return $this->returnFailApi(lang('数据异常'));
        }
        if (empty($insert_data)) {
            return $this->returnFailApi(lang('没有数据可插入'));
        }

        if ($is_del) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table($this->getModelTableName())->truncate();
        }

        try {
            $r = $this->importPostWhere()->insert($insert_data);
            if ($r) {
                $this->allAfterEvent('import');
                $this->afterImportSuccessEvent($insert_data);
                $this->insertLog($this->pageName . lang('导入成功'));
                return $this->returnSuccessApi(lang('导入成功'));

            }
            $this->insertLog($this->pageName . lang('导入失败'));
            //导入失败之后事件
            $this->afterImportFailEvent($insert_data);
            return $this->returnFailApi(lang('导入失败'));

        } catch (\Exception $exception) {
            $this->afterImportFailEvent($insert_data);
            return $this->returnFailApi(lang('数据异常,请重新上传表格数据或自检') . $exception->getMessage());
        }

    }


    /**
     * 生成导入模板
     * @param Request $request
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function importTpl(Request $request)
    {
        //取得字段，
        $files = $this->getField();
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $spreadsheet->getActiveSheet()
            ->fromArray(
                $files,
                NULL,
                'A1'
            );

        //设置单元格宽度，自动
        $this->importTplTableSet($spreadsheet);

        return $this->downExcel($spreadsheet, $this->getModelTableName() . '.xlsx');
    }

    /**
     * 取得模型的数据库表名称
     * @return string
     */
    public function getModelTableName()
    {
        if (gettype($this->getModel()) != 'object') {
            $table = '';
        } else {
            $table = $this->getModel()->getTable();
        }
        $share_view['table_name'] = $table;

        $this->shareData($share_view);
        return $table;
    }

    /**
     * 表格模板模板宽度
     * @return int
     */
    public function importTplTableSet($spreadsheet)
    {
        return $spreadsheet->getActiveSheet()->getDefaultColumnDimension('A')->setWidth(22);
    }

    /**
     * 输出下载文件
     * @param $spreadsheet
     * @param $name
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function downExcel($spreadsheet, $name)
    {
        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $name . '"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;//一定要加个，不然winodow下有问题
    }

    /**
     * 导入设置查询或者是限制条件
     * @return mixed
     */
    public function importPostWhere()
    {
        return $this->getModel();
    }

    /**
     * 删除增加限制条件
     * @return mixed
     */
    public function delAddWhere()
    {
        return $this->getModel();
    }

    /**
     * 过滤删除IDS
     * @param array $ids
     * @return array
     */
    public function delFilterIds(array $ids)
    {
        return $ids;
    }


    /**
     * 全局创建和更新操作返回消息
     * @param $result
     * @param $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    protected function saveMessage($result, $id = '')
    {
        $request = $this->rq;
        $type = $id ? lang('更新') : lang('创建');

        $msg_type = $result ? lang('成功') : lang('失败');
        $msg_str = $this->getPageName() . $type . $msg_type . ($this->createEditLastId ? 'id:' . $this->createEditLastId : '');
        if ($result) {
            $this->allAfterEvent($id ? 'edit' : 'create');
            $this->insertLog($msg_str);
        }
        if ($request->ajax() || $request->wantsJson()) {
            return $this->returnApi($result ? 200 : 1, $this->saveMessageOutputStr($msg_str, $result, $id));
        }
    }

    /**
     * 提交和保存
     * @param $msg_str
     * @param $result
     * @param $id
     * @return mixed
     */
    public function saveMessageOutputStr($msg_str, $result, $id)
    {
        return $msg_str;
    }


    /**
     * 设置页面标题
     * @return mixed
     */
    public function setPageName($name)
    {
        $this->shareData(['page_name' => $name]);
        return $this->pageName = $name;
    }



    /************************设置模型相关*********************************/
    /**
     * 设置模型
     * @param $model
     */
    public function setModel()
    {
        return $this->model;
    }

    /**
     * 取得模型
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /*************************增加限制条件部分*************************************/
    /**
     * 增加，更新，搜索等全局增加限制条件
     * @return mixed
     */
    public function curdWhere()
    {
        return $this->model;
    }

    /**
     * 编辑/更新页面添加限制条件
     */
    public function editWhere()
    {
        return $this->curdWhere();
    }

    /**
     * 编辑表格增加条件
     * @return mixed
     */
    public function editTableAddWhere()
    {
        return $this->curdWhere();
    }


    /**
     * 显示查看条件
     * @return mixed
     */
    public function showWhere()
    {
        return $this->curdWhere();
    }
    /***********************共享数据部分******************************/
    /**
     * 编辑和创建共享的数据变量
     * @param string $edit_data 这个表示编辑时候的模型数据
     * @return array 返回数组形式，必须
     */
    public function createEditShareData($show = '')
    {

        return [];
    }

    /**
     * 绑定UI器
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function buildUi()
    {
        $this->uiService = app()->make('App\Services\Ui');
        $this->shareData(['uiService' => $this->uiService]);
        return $this->uiService;
    }

    /**
     * 设置输出
     * @param $show
     * @return array
     */
    public function setOutputUiCreateEditForm($show = '')
    {
        return "";
    }

    /**
     * 首页共享数据
     * @return array
     */
    public function indexShareData()
    {
        return [];
    }


    /**
     * 共享数据
     * @param $data
     */
    public function shareData($data)
    {
        view()->share($data);
    }

    /***************验证相关*****************/
    /**
     * 设置验证的规则数据
     * @param $request
     * @return mixed
     */
    public function checkRuleData($request)
    {
        return $request->all();
    }

    /**
     * 检查验证规则
     * @param string $id id不为空表示更新操作的表单规则
     * @return array
     */
    protected function checkRule($id = '')
    {
        return [];
    }

    protected function checkBatchRule()
    {
        return [];
    }

    /**
     * 设置表单验证键值对不通过输出的
     * @return array
     */
    public function checkRuleMsg()
    {
        $messages = [
        ];
        return $messages;
    }

    /**
     * 设置表单验证的字段值对应名字
     * @return array
     */
    public function checkRuleFieldName()
    {
        $messages = [
        ];
        return $messages;
    }


    /**
     * 添加、更新的附加验证规则，一般用于特殊附加值
     * @param string $model
     * @param string $id
     * @return 数组表示有错误，格式必须是
     * ['code'=>'错误代码','msg'=>'错误信息','data'=>[]]
     */
    protected function extendValidate($model = '', $id = '')
    {
        return true;
    }

    /**
     * 批量附加验证事件
     */
    protected function batchCreateExtendValidate()
    {

    }

    /**
     * 添加、更新经过赋值后模型附加验证多一次，
     * 如果有错误,$this->modelSaveMsg=['code'=>错误代码,'msg'=>'错误信息','data'=>[]];
     * @param string $model
     * @param string $id
     */
    protected function extendModelValidate($model = '', $id = '')
    {
        return $model;
    }

    /**
     * 检查是否存在错误，直接返回错误字符串
     */
    public function checkDelet($id_arr)
    {

    }



    /**************设置模型设置******************/
    /**
     * 是否设置事务，返回真表示开启事务
     * @param $post_data
     * @return bool
     */
    protected function isTransaction($post_data, $id = '')
    {
        return false;
    }

    /**
     * 设置创建和更新的模型赋值数据
     * @param string $id 如果更新，则存在
     * @return mixed
     */
    protected function postData($id = '')
    {
        return $this->rq->all();
    }

    /**
     * 设置创建/更新模型键值对赋值
     * @param $obj
     * @param $data
     * @return mixed
     */
    protected function setFieldValue($obj, $data)
    {

        $fileds = $this->getField();

        foreach ($data as $field => $v) {
            if (in_array($field, $fileds)) {
                $v = is_null($v) ? '' : $v;
                $obj->$field = trim($v);
            }
        }

        return $obj;
    }

    /**
     * 取得当前的模型的全部字段
     * @param $model
     * @return mixed
     */
    protected function getField()
    {
        return $this->getModel()->getModelField();

    }

    /**
     * 附加保存数据参数
     * 例如：$model->name='23434';
     */
    public function addPostData($model)
    {
        return $model;
    }

    /******************设置事件操作*********************/

    /**
     * 创建/更新之前的操作
     * @param $model 当前操作的模型
     * @param string $id ID存在表示更新操作数据
     */
    protected function beforeSaveEvent($model, $id = '')
    {
    }

    /**
     * 事务时候,主表入库之后其他表要入库的事件操作
     * @param $model 入库/更新之后的模型数据
     * @param string $id ID值存在表示更新的操作
     * @return bool 如果是事务返回true 才可以提交
     */
    protected function afterSaveEvent($model, $id = '')
    {
        return true;
    }

    /**
     * 创建,更新，成功提交之后要操作的事件,不区分是事务还是非事务
     * @param $model
     * @param $id
     */
    protected function afterSaveSuccessEvent($model, $id)
    {

    }

    /**
     * 所有操作事件之后要做的事情,
     * @param $type 操作的类型，edit:编辑，create 创建
     */
    public function allAfterEvent($type = '')
    {

    }

    /**
     * 数据表格成功更新之后事件
     * @param $field
     * @param array $ids
     */
    public function afterEditTableSuccessEvent($field, array $ids)
    {

    }

    /**
     * 数据表格失败之后事件
     * @param $field
     * @param array $ids
     */
    public function afterEditTableFailEvent($field, array $ids)
    {

    }

    /**
     * 批量成功添加之后
     * @param array $data 数据
     */
    public function afterBatchSuccessCreateEvent(array $data)
    {

    }

    /**
     * 批量失败添加之后
     * @param array $data 数据
     */
    public function afterBatchFailCreateEvent(array $data)
    {

    }


    /**
     * 复制成功之后的操作事件
     * @param $show
     */
    public function afterCopySuccess($show, $new)
    {

    }

    /**
     * 复制失败之后的操作事件
     * @param $show
     */
    public function afterCopyFail($show, $new)
    {

    }

    /**
     * 成功删除之后要操作的事
     * @param $ids
     */
    public function deleteSuccessAfter(array $ids)
    {

    }

    /**
     * 删除失败之后要操作的事
     * @param array $ids
     */
    public function deleteFailAfter(array $ids)
    {

    }

    /**
     * 可以通过此方法删除数据之前先获取数据存储备用
     * @param $model
     * @param array $ids
     */
    public function deleteGetData($model, array $ids)
    {

    }


    /**
     * 导入成功之后事件
     * @param $insert_data 插入的数据
     */
    public function afterImportSuccessEvent($insert_data)
    {

    }

    public function afterImportFailEvent($insert_data)
    {

    }


    /**
     * 创建、编辑操作日志
     * @param $str
     */
    protected function insertLog($msg)
    {


    }

    /**
     * 列表增加搜索地方
     * @param $model
     */
    public function addListSearchWhere($model)
    {
        return $model;
    }

    /**
     * 导出
     * @return mixed
     */
    public function exportCreate(Request $request)
    {

        return $this->display($this->indexShareData());
    }

    public function exportCreatePost(Request $request)
    {
        $this->isGetListData = 1;
        $exprot_type = $request->input('exprot_type', 'txt');
        $result = $this->getList($request);
        $result = $result['data'];
        if (empty($result)) {
            exit('无数据');
        }
        if ($exprot_type == 'excel') {
            return $this->exportCreateExcel($result);
        }
        return $this->exportCreateTxt($result);

    }

    /**
     * 导出文本格式
     * @param $data
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportCreateTxt($data)
    {

        $data = $this->exportCreateTxtFormat($data);
        if (empty($data)) {
            exit('请先设置输出格式');
        }
        $name = $data['name'];
        $html = $data['html'];
        return response()->streamDownload(function () use ($html) {
            echo $html;
        }, $name . '.txt');
    }

    //导出格式
    public function exportCreateTxtFormat($data)
    {

    }

    public function exportCreateExcel($data)
    {

    }

    /**
     * 是否具有批量操作权限
     */
    public function isCanBatch()
    {
        if (acan($this->getRouteInfo('controller_route_name') . 'batch')) {
            return true;
        }
        return false;
    }

    /**
     * 是否有编辑权限
     * @return bool
     */
    public function isCanEdit()
    {

        if (acan($this->getRouteInfo('controller_route_name') . 'edit')) {
            return true;
        }
        return false;
    }

    /**
     * 是否有创建
     * @return bool
     */
    public function isCanCreate()
    {

        if (acan($this->getRouteInfo('controller_route_name') . 'create')) {
            return true;
        }
        return false;
    }

    /**
     * 是否有删除权限
     * @return bool
     */
    public function isCanDel()
    {
        if (acan($this->getRouteInfo('controller_route_name') . 'destroy')) {
            return true;
        }
        return false;
    }

    /**
     * 是否有查看详情权限
     * @return bool
     */
    public function isCanShow()
    {
        if (acan($this->getRouteInfo('controller_route_name') . 'show')) {
            return true;
        }
        return false;
    }


}
