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

namespace App\ExtendClass;

use App\Models\Permission;
use http\Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Finder\Finder;

class Plugin
{

    /**
     * 取得插件目录数组
     * @return array 返回目录名称
     */
    public static function getList()
    {

        return self::getStorageList();
    }

    /**
     * 取得插件安装的列表
     */
    public static function getStorageList(){
        $plugin_path = linux_path(storage_path('plugin')).'/';
        if(!file_exists($plugin_path)){
            mkdir($plugin_path,0775);
        }
        $data = get_dir($plugin_path,'','file');

        return $data;
    }

    public static function getOriginList(){
        $plugin_path = self::getPath();
        $data = get_dir($plugin_path);
        return $data;
    }


    /**
     * 取得而沒有安裝的列表
     * @param $plugins
     * @return array
     */
    public static function getNotInstall($plugins)
    {
        return array_diff(self::getOriginList(), $plugins);
    }

    /**
     * 自动安装数据
     * @param $plugins
     * @return bool
     */
    public static function autoInstallData($plugins = [])
    {
        $noInstalls = self::getNotInstall($plugins);

        if (empty($noInstalls)) {
            return false;
        }
        $data = [];
        foreach ($noInstalls as $k => $v) {
            $config = self::getConfig($v);
            if (empty($config)) {
                return false;
            }
            if (!isset($config['name']) || empty($config['name'])) {
                continue;
            }
            $data[] = [
                'name' => $config['name'] ?? '',
                'author' => $config['author'] ?? '',
                'ename' => $v,
                'thumb' => $config['thumb'] ?? '',
                'version' => $config['version'] ?? '1.0.0',
                'plugin_data' => json_encode($config['plugin'] ?? [])
            ];

        }
        return $data;
    }

    /**
     * 取得插件配置信息
     * @param $plugin
     * @return string
     */
    public static function getConfigPath($plugin)
    {
        return self::getPath() . $plugin . '/config.php';

    }

    /**
     * 取得配置数组
     * @param $plugin
     * @return mixed
     */
    public static function getConfig($plugin)
    {
        $file = self::getConfigPath($plugin);
        if (file_exists($file)) {
            $config = require_once $file;
            if (is_array($config)) {
                return $config;
            }
        }

        return [];
    }


    /**
     * 取得插件目录
     * @return string
     */
    public static function getPath()
    {
        $plugin_path = base_path('plugin') . '/Package/';

        return linux_path($plugin_path);
    }

    /**
     * 加载插件中间件
     * @return array|bool
     */
    function loadMiddleware()
    {
        $plugin_path = $this->getPath();
        $plugin_path_dir = get_dir($plugin_path, 0);
        if (empty($plugin_path_dir)) {
            return false;
        }
        $m_arr = [];
        foreach ($plugin_path_dir as $k => $v) {
            $route_path = $plugin_path . $v . '/Kernel.php';
            //判断这个路由文件是否存在，如果存在则进行读取
            if (file_exists($route_path)) {
                $m_arr[$v] = require $route_path;

            }

        };
        return $m_arr;
    }




    /**
     * 插件菜单数据
     * @param $name
     * @param $route
     * @param string $icon
     * @param int $show
     * @return array
     */
    public static function pluginMenuNameData($name, $route, $icon = '', $show = 0)
    {
        return [
            'name' => $name,//名称
            'route' => 'admin.plugin.' . $route, //路由
            'icon' => $icon,//图标
            'menu_show' => $show,//菜单显示不，1表示显示，0表示不在菜单显示
        ];
    }

    /**
     * 插件菜单生成一组菜单数据
     * @param $name
     * @param $routePrefix
     * @param array $filter
     * @return array
     */
    public static function groupCurlRouteData($name, $icon, $show, $routePrefix, $filter = [])
    {

        $data = self::pluginMenuNameData($name, $routePrefix . '.index', $icon, $show);
        $arr = [
            'create' => $name . lang('添加'),
            'edit' => $name . lang('编辑'),
            'destroy' => $name . lang('删除'),
            'show' => $name . lang('详情')
        ];
        foreach ($arr as $k => $v) {
            if (in_array($v, $filter)) {
                continue;
            }
            $name = $v;
            $routePrefix = $routePrefix . '.' . $k;
            $data['child'][] = self::pluginMenuNameData($name, $routePrefix, '', 0);
        }
        return $data;
    }


    public static function checkPluginFile($file)
    {

        return file_exists(self::getPath() . $file);
    }

    /**
     * 安装菜单
     * @param $ename
     * @return bool
     */
    public static function installMenu($ename)
    {
        $menus = Permission::where('type', $ename)->get()->toArray();
        if (empty($menus)) {


            $pluginNamespace = '\Plugin\Package\\' . $ename . '\\Migrations';
            if (\App\ExtendClass\Plugin::checkPluginFile($ename . '/Migrations/Menu.php')) {
                //直接插入
                //取得数据
                $model = $pluginNamespace . '\Menu';
                $pluginMenu = $model::up();

                if (!empty($pluginMenu)) {

                    //创建根级菜单
                    $root = Permission::create([
                        'name' => '',
                        'guard_name' => 'admin',
                        'type' => $ename,
                        'cn_name' => $model::$name,
                        'menu_name' => $model::$name,
                        'menu_show' => 1,
                        'parent_id' => 0,
                        'icon' => $model::$icon,
                    ]);
                    foreach ($pluginMenu as $k => $v) {

                        $createData = self::routeSetMenu($v, $ename, $root['id']);

                        $createModel = Permission::create($createData);
                        //是否存在子
                        if (isset($v['child']) && !empty($v['child'])) {
                            $menuInsert = [];
                            foreach ($v['child'] as $k2 => $v2) {
                                $menuInsert[] = self::routeSetMenu($v2, $ename, $createModel['id']);
                            }

                            $createModel2 = Permission::insert($menuInsert);
                            if (isset($v2['child']) && !empty($v2['child'])) {
                                $menuInsert = [];
                                foreach ($v2['child'] as $k3 => $v3) {
                                    $menuInsert[] = self::routeSetMenu($v3, $ename, $createModel2['id']);
                                }
                                Permission::insert($menuInsert);
                            }
                        }
                    }

                    //更新菜单缓存
                    Permission::getCache('admin');
                    return true;

                }
            }
        }
        return false;

    }


    public static function routeSetMenu($v, $ename, $pid = 0)
    {
        return [
            'parent_id' => $pid,
            'cn_name' => $v['name'],
            'menu_name' => $v['name'],
            'name' => $v['route'],
            'icon' => $v['icon'],
            'menu_show' => $v['menu_show'],
            'type' => $ename,
            'guard_name' => 'admin',
            'created_at' => date('Y-m-d H:i:s')
        ];
    }

    /**
     * 加载插件的文件导入到并合并数组
     * @param $originConfig
     * @param string $file
     * @return array
     */
    public static function loadPluginConfigArr($originConfig, $file = 'relation.php')
    {
        try {
            $plugins = self::getList();
            if (empty($plugins)) {
                return $originConfig;
            }
            $path = self::getPath();

            foreach ($plugins as $k => $v) {
                $rel = $path . $v . '/' . $file;

                if (file_exists($rel)) {
                    $config = require_once $rel;
                    if (empty($originConfig)) {
                        $originConfig = $config;
                    } else {
                        if (is_array($config)) {
                            $originConfig = array_merge($originConfig, $config);
                        }
                    }

                }
            }
            //不过滤重复
            //$originConfig = array_unique($originConfig);
            return $originConfig;
        } catch (\Exception $e) {
            return $originConfig;
        }

    }

    /**
     * 加载插件中间件
     * @param $group
     * @param $middleware
     * @return array
     */
    public static function loadPluginMiddleware($group, $middleware)
    {
        try {
            $plugins = self::getList();
            if (empty($plugins)) {
                return ['group' => $group, 'middleware' => $middleware];
            }
            $path = self::getPath();
            if (empty($group)) {
                $group = [];
            }
            if (empty($middleware)) {
                $middleware = [];
            }
            foreach ($plugins as $k => $v) {
                $rel = $path . $v . '/kernel.php';

                if (file_exists($rel)) {
                    $config = require_once $rel;

                    if (is_array($config)) {
                        if (isset($config['group'])) {
                            $group = array_merge($group, $config['group']);
                        }
                        if (isset($config['middleware'])) {
                            $middleware = array_merge($middleware, $config['middleware']);
                        }

                    }

                }
            }
            return ['group' => $group, 'middleware' => $middleware];

        } catch (\Exception $e) {
            return ['group' => $group, 'middleware' => $middleware];
        }
    }

    /**
     * 加载插件路由和帮助配置
     * @return bool
     */
    public static function loadPluginRouteHelperConfig()
    {
        try {
            $plugins = self::getList();
            if (empty($plugins)) {
                return false;
            }
            $path = self::getPath();

            foreach ($plugins as $k => $v) {
                //判断路由文件是否存在，存在则加载
                $path = $path . $v;
                $adminRoute = $path . '/Route/admin.php';

                if (file_exists($adminRoute)) {
                    //后台路由前缀是'admin.plugin.';
                    //并且必须是需要登录的中间件和安装过
                    self::addRoute($adminRoute, $v, 'admin.plugin.' . lcfirst($v) . '.admin.', 'admin/plugin/' . $v, ['web', 'admin_auth']);
                }
                $adminRoute = $path . '/Route/front.php';
                if (file_exists($adminRoute)) {
                    //前台路由前缀是'plugin.';
                    self::addRoute($adminRoute, $v, 'plugin.' . lcfirst($v) . '.');
                }
                $helperPath = $path . '/helper.php';
                if (file_exists($helperPath)) {
                    //加载函数
                    require_once $helperPath;
                }
            }
        } catch (\Exception $e) {

        }

    }

    /**
     * 插件路由加载
     * @param array|string $route_path 路由文件
     * @param string $namespace 路由命名控制
     * @param string $route_name 路由命名
     * @param string $prefix 路径前缀
     * @return \Illuminate\Routing\Route|void
     */
    public static function addRoute($route_path, $namespace, $route_name = '', $prefix = '', $middleware = [])
    {
        if (empty($middleware)) {
            $middleware = ['web'];
        }
        Route::middleware($middleware)->name($route_name)->prefix($prefix)
            ->namespace('Plugin\Package\\' . $namespace)
            ->group($route_path);

    }

    /**
     * 加载 Auth 配置
     * @param $originConfig
     * @param string $file
     * @return mixed
     */
    public static function loadPluginAuthConfig($originConfig, $file = 'auth.php')
    {
        try {
            $plugins = self::getList();

            if (empty($plugins)) {
                return $originConfig;
            }
            $path = self::getPath();

            foreach ($plugins as $k => $v) {
                $rel = $path . $v . '/' . $file;

                if (file_exists($rel)) {
                    $config = require_once $rel;
                    if (empty($originConfig)) {
                        $originConfig = $config;
                    } else {
                        if (is_array($config)) {
                            if (isset($config['guards']) && !empty($config['guards'])) {
                                $originConfig['guards'] = array_merge($originConfig['guards'], $config['guards']);
                            }
                            if (isset($config['providers']) && !empty($config['providers'])) {
                                $originConfig['providers'] = array_merge($originConfig['providers'], $config['providers']);
                            }

                        }
                    }

                }
            }
            //不过滤重复
            //$originConfig = array_unique($originConfig);
            return $originConfig;
        } catch (\Exception $e) {
            return $originConfig;
        }

    }
}