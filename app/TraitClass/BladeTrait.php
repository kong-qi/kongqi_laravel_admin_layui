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

use App\Exceptions\ErrorException;

trait BladeTrait
{
    public $bladeView;//视图文件
    public $pageName;
    public $module;//模块
    public $bladeTheme;//主题模板
    public $bladePrefix = '';//视图前缀文件
    public $resVersion = '';//资源版本号
    public $controllerBladePath = '';
    public $commonBladePath = '';//只对第二层
    //例如 $denyCommonBladePathActionName=['index']，设置index不走公用，写对应的方法名即可,
    public $denyCommonBladePathActionName = [];//针对第二次设置不设置公共的

    public $custormControllerPathPrefix='';//自定义控制器前缀

    /**
     * 取得路由信息
     * @param string $field
     * @return array
     */
    public function getRouteInfo($field = '')
    {
        $route_info = $this->route;
        return $field ? $route_info[$field] : $route_info;
    }

    /**
     * 设置模块路径
     * @return string
     */
    public function getModuleViewPath()
    {
        //取得主题模板
        $this->getBladeTheme();
        //dump($this->module);
        //首字母小写
        return lcfirst($this->toModelBlade($this->module)) . ($this->bladeTheme ? '.' . $this->bladeTheme : '');
    }

    /**
     * 设置控制器视图路径
     * @return string
     */
    public function getControllerViewPath()
    {

        //控制器首字母小写
        return $this->controllerBladePath = lcfirst($this->toModelBlade($this->getRouteInfo('controller_base_name'))) . '.';

    }

    public function getControllerOriginViewPath()
    {

        //控制器首字母小写
        return lcfirst($this->toModelBlade($this->getRouteInfo('controller_base_name'))) . '.';

    }

    /**
     * 设置视图控制器目录路径
     * @param $controller_path
     */
    public function setControllerViewPath($controller_path)
    {
        $this->controllerBladePath = $controller_path;
        $controller_path=$this->custormControllerPathPrefix.$controller_path;
        $this->bladeView = $this->getModuleViewPath() . '.' . $controller_path . "." . $this->getRouteInfo('action_name');
    }

    /**
     * 设置当前视图路径
     * @param $blade_path
     */
    public function setViewPath($blade_path)
    {
        $this->bladeView = $this->getModuleViewPath() . '.' . $this->controllerBladePath . $blade_path;
    }


    /**
     * 设置视图文件定位转换格式
     * @param $path
     * @return string
     */
    public function toModelBlade($path)
    {
        $arr = explode("\\", $path);
        $path=[];
        foreach ($arr as $k=>$v){
            $path[]=lcfirst($v);
        }
        return (implode(".", $path));
    }

    /**
     * 自动定位视图
     */
    public function setAutoBlade()
    {

        $this->getControllerViewPath();
        //模块视图转换成小写

        $this->bladeView = $this->getModuleViewPath() . '.' . $this->controllerBladePath . $this->getRouteInfo('action_name');
        //设置资源版本号

        $this->getResVersion();

    }

    /**
     * 全局设置模板调用
     */
    public function setAutoCommonBlade()
    {

        if (!empty($this->commonBladePath) && !in_array($this->getRouteInfo('action_name'), $this->denyCommonBladePathActionName)) {
            $this->controllerBladePath = $this->commonBladePath . '.';
            $this->bladeView = $this->getModuleViewPath() . '.' . $this->commonBladePath . '.' . $this->getRouteInfo('action_name');

        }

    }


    /**
     * 共享数据
     * @param $data
     */
    public function shareData($data)
    {
        view()->share($data);
    }

    /*********************视图部分*************************/
    /**
     * 输出视图
     */
    public function display(array $data = [])
    {
        //是否设置了全局控制器路径模板则调用它
        $this->setAutoCommonBlade();

        $blade = $this->bladePrefix . $this->bladeView;
        $this->shareData([
                'title' => $this->getPageName(),
                'theme_blade' => $this->bladeTheme,
                'base_blade_path' => $this->getModuleViewPath(),
                'current_base_blade_path' => $this->getModuleViewPath() . '.' . $this->controllerBladePath, //当前的模板会跟随公用设置而改变路径
                'origin_current_base_blade_path' => $this->getModuleViewPath() . '.' . $this->getControllerOriginViewPath() //当前的模板路径不会跟随改变
            ]


        );

        $this->shareData($this->route);


        if (view()->exists($blade)) {
            return view($blade, $data);
        } else {
            return $this->bladeError($blade . ' ' . lang('视图文件不存在'));
        }

    }

    /**
     * 404页面
     */
    public function bladeError($message = '', $code = 404)
    {
        $data['code'] = $code;
        $data['msg'] = $message;
        $data['theme'] = $this->getModuleViewPath();

        throw  new ErrorException($data);
    }


    /**
     * 取得视图主题
     * @return mixed
     */
    public function getBladeTheme()
    {

        return $this->bladeTheme;
    }

    /**
     * 设置视图主题
     * @return mixed
     */
    public function setBladeTheme($theme)
    {
        $this->bladeTheme = $theme;
    }

    /**
     * 取得页面标题
     */
    public function getPageName()
    {
        $this->shareData(['page_name' => lang($this->pageName)]);
        return lang($this->pageName);
    }

    /**
     * 设置页面标题
     * @return mixed
     */
    public function setPageName($name)
    {
        $name = lang($name);
        $this->shareData(['page_name' => $name]);
        return $this->pageName = $name;
    }

    /**
     * 设置资源缓存版本号
     * @return string
     */
    public function setResVersion($version)
    {

        $this->resVersion = $version;
    }

    /**
     * 设置资源缓存版本号
     * @return string
     */
    public function getResVersion()
    {

        $this->shareData(['res_version' => $this->resVersion]);

        return $this->resVersion;
    }

}