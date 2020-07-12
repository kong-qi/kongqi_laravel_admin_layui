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


namespace Plugin\Plugin\Controller\Front;

use App\TraitClass\ApiTrait;
use App\TraitClass\BladeTrait;
use App\TraitClass\CheckFormTrait;
use App\TraitClass\RouteTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;

class PluginController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use ApiTrait, CheckFormTrait, RouteTrait, BladeTrait;
    public function __construct()
    {

        $this->module='Plugin';
        $this->namespace='Plugin\Package\\';//插件包模块
        $this->routePrefix='plugin.';//路由前缀

        //设置路由信息
        $this->routeInfo($this->module);
        //设置资源版本号
        $this->setResVersion("1.0");
        //自动视图
        $this->setAutoBlade();


        //视图名称
        $this->getPageName();

    }
    public function routeInfo($module = '')
    {
        $route_arr = explode('@', Route::currentRouteAction());
        $data = [];
        $data['route_name'] = Route::currentRouteName();//路由名称
        $data['controller_name'] = '\\' . $route_arr[0];//控制器命名路径
        $data['action_name'] = ($route_arr[1]);//控制器方法名称
        //自動模塊
        $moduleArr=explode("\\",str_replace($this->namespace,'',$route_arr[0]));
        if(!$module){
            $module=$moduleArr[0];
        }

        $data['module'] = $module;//命名空间的模块名称
        $controller_name_arr = explode("\\", $data['controller_name']);
        //getControllerOriginViewPath
        if (!empty($controller_name_arr) && isset($controller_name_arr[count($controller_name_arr) - 1])) {
            $data['controller_base_name'] = $controller_name_arr[count($controller_name_arr) - 1];
        }
        $data['controller_base_name'] = str_replace('Controller', '', $data['controller_base_name']);//控制器名称不包含Controller
        $controller_route_name = str_replace($this->namespace, '', str_replace($this->namespace, '', $route_arr[0]));
        $controller_route_name=str_replace('Controller', '', $controller_route_name);
        $data['controller_base_name']=   $controller_route_name;
        //过来掉前端front
        $controller_route_name=str_replace('\Front','',$controller_route_name);
        $data['controller_route_name'] =$this->routePrefix.$this->toBlade($controller_route_name).'.';
        $this->controllerBladePath=$this->toBlade($controller_route_name).'.';
        $data['controller_base_name_lower'] = strtolower($data['controller_base_name']);//控制器小写名称

        $this->route = $data;

        return $data;
    }
    /**
     * 设置控制器视图路径
     * @return string
     */
    public function getControllerViewPath()
    {

        //控制器首字母小写
        $path=explode("\\",$this->getRouteInfo('controller_base_name'));
        $this->custormControllerPathPrefix=$this->toBlade($path[0].'\\'.$path[1]).'.';
        //dump($this->custormControllerPathPrefix);
        return $this->controllerBladePath=$this->toBlade($this->getRouteInfo('controller_base_name')).'.';

    }
}