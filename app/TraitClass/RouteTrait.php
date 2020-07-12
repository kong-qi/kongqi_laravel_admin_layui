<?php
// +----------------------------------------------------------------------
// | KongQiAdminBase [ Laravel快速后台开发 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012~2019 http://www.kongqikeji.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kongqi <531833998@qq.com>`
// +----------------------------------------------------------------------

namespace App\TraitClass;

use Illuminate\Support\Facades\Route;

trait RouteTrait
{

    public $route;
    public $namespace = 'App\\Http\\Controllers\\';//命名空间位置，如果你的位置不在此，需要修改此命名空间
    public $modulePrefix='';
    public $routePrefix='';
    /**
     * 路由控制器相关信息
     * @param string $module
     * @return array
     */
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
        //$data['controller_base_name']=   $controller_route_name;
        //这个用在了isCanEdiT检验权限之类
        $data['controller_route_name'] =$this->routePrefix.$this->toBlade($controller_route_name).'.';
        $this->controllerBladePath=$this->toBlade($controller_route_name).'.';
        $this->route = $data;
        $data['controller_base_name_lower'] = strtolower($data['controller_base_name']);//控制器小写名称

        return $data;
    }
    public function toBlade($path){
        $arr= explode("\\",$path);
        $route=[];
        foreach ($arr as $k=>$v){
            $route[]=lcfirst($v);
        }
        return (implode(".",$route));
    }


}