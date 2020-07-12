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

namespace Plugin\Plugin\Controller\Admin;

use App\Models\AdminLog;
use App\Services\UiService;
use App\TraitClass\ModelCurlTrait;


class PluginCurlController extends PluginController
{
    use  ModelCurlTrait;
    public $uiService;
    public $commonBladePath = 'commonCurl';
    public $guardName = 'admin';

    /**
     * 插入操作日志
     * @param $str
     */
    protected function insertLog($msg)
    {
        AdminLog::addLog($msg);
    }

    public function __construct()
    {
        parent::__construct();
        //表格名称
        $this->getModelTableName();
        //设置模型
        $this->setModel();
        //服务容器注入
        //更加模板来注入
        app()->bind(
            'App\Services\Ui',
            'App\Services\BootstrapUi'
        );

    }

    //编辑链接赋值检查权限
    public function editUrlShow($item)
    {
        $item['edit_url'] = '';
        $item['edit_post_url'] = '';
        $edit_true = 0;

        if (acan($this->getRouteInfo('controller_route_name') . 'edit')) {
            $edit_true = 1;
        }
        if ($edit_true) {
            $item['edit_url'] = action($this->route['controller_name'] . '@edit', ['id' => $item->id]);
            $item['edit_post_url'] = action($this->route['controller_name'] . '@update', ['id' => $item->id]);
        }
        return $item;

    }

    //首页编辑添加弹窗大小高度设置
    public function layuiOpenHeight()
    {
        return '500px';
    }

    //首页编辑添加弹窗大小高度设置
    public function layuiOpenWidth()
    {
        return '600px';
    }

    /**
     * 列表输出格式单项目设置
     * @param $item
     * @return mixed
     */
    public function setListOutputItem($item)
    {
        $item = $this->editUrlShow($item);

        //自动默认绑定
        $item->is_checked_html = UiService::switchTpl('is_checked', $item);
        $item->handle = $this->listHandleBtnCreate($item);
        $item = $this->setListOutputItemExtend($item);

        return $item;
    }

    public function listHandleBtnCreate($item)
    {
        return UiService::editDelTpl($this->isCanEdit(), $this->isCanDel());;
    }


    /**
     * 首页配置参数
     * @return array
     */
    public function getListConfig($listMethod = '')
    {
        $data = [
            'index_url' => action($this->getRouteInfo('controller_name').'@getList', request()->all()),//首页列表JSON地址
            'table_name' => $this->getModelTableName(),
            'page_name' => lang($this->getPageName()),
            'del_url' => action($this->getRouteInfo('controller_name').'@destroy'),//删除提交地址
            'edit_field_url' => action($this->getRouteInfo('controller_name').'@editTable'),//表格编辑提交地址
            'create_url' => action($this->getRouteInfo('controller_name').'@create', request()->all()),//创建页面地址
            'store_url' => action($this->getRouteInfo('controller_name').'@store'),
            'open_height' => $this->layuiOpenHeight(),//Layui 弹窗弹出高度
            'open_width' => $this->layuiOpenWidth(),//Layui 弹窗高度窗口
        ];
        //设置form，搜索路径

        $this->shareData(['form_search_self' => $this->formSearchSelf]);
        $this->shareData(['index_config' => $data]);
        return $data;
    }
}