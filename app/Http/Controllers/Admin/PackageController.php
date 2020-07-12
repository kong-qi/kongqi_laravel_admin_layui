<?php

namespace App\Http\Controllers\Admin;


use App\Models\Admin;
use App\Models\Permission;
use App\Models\Plugin;
use App\Models\Role;
use App\Services\UiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Plugin\Package\Blog\Models\Page;

class PackageController extends BaseCurlIndexController
{
    //页面信息
    public $pageName = '插件';
    public $denyCommonBladePathActionName = [];


    //1.设置模型
    public function setModel()
    {
        $this->model = new Plugin();

    }

    //首页提示说明
    public function indexTips()
    {
        return '这里的删除只是删除插件库里面的数据，并不会删除目录和安装过的数据库';
    }

    //2.首页设置列表显示的信息
    public function indexCols()
    {
        //自动安装插件插入表数据
        Plugin::installDb();



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
                'field' => 'name',
                'minWidth' => 120,
                'title' => '插件',
                'align' => 'center',
                'edit' => 1
            ],
            [
                'field' => 'ename',
                'minWidth' => 100,
                'title' => '标识符',
                'align' => 'center'
            ],
            [
                'field' => 'version',
                'width' => 80,
                'title' => '版本',
                'align' => 'center'
            ],
            [
                'field' => 'author',
                'minWidth' => 80,
                'title' => '作者',
                'align' => 'center',
            ],
            [
                'field' => 'install_name_html',
                'width' => 100,
                'title' => '安装状态',
                'align' => 'center',
            ],

            [
                'field' => 'handle',
                'minWidth' => 180,
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
                'field' => 'query_like_name',
                'type' => 'text',
                'name' => '插件',
            ],
            [
                'field' => 'query_like_author',
                'type' => 'text',
                'name' => '作者',
            ],

            [
                'field' => 'query_is_install',
                'type' => 'select',
                'name' => '是否安装',
                'on' => '',
                'data' => array_merge([['id' => '', 'name' => '全部']], $this->uiService->trueFalseData())

            ]

        ];
        //赋值到ui数组里面必须是`search`的key值
        $this->uiBlade['search'] = $data;
    }


    //编辑
    public function listHandleBtnCreate($item)
    {
        $data = [];
        if ($item->is_install == 0) {
            $data[] = UiService::layuiTplUrlPost(
                '安装',
                action($this->getRouteInfo('controller_name') . '@handlePost', ['type' => 'install', 'id' => $item['id']]),
                '确定安装吗？',
                '250px',
                '150px'
            );
        } else {
            $data[] = UiService::layuiTplUrlPost(
                '卸载',
                action($this->getRouteInfo('controller_name') . '@handlePost', ['type' => 'remove', 'id' => $item['id']]),
                '确定卸载吗？',
                '250px',
                '150px'
            );
            if ($item->is_menu) {
                $data[] = UiService::layuiTplUrlPost(
                    '移除菜单',
                    action($this->getRouteInfo('controller_name') . '@handlePost', ['type' => 'removeMenu', 'id' => $item['id']]),
                    '确定移除菜单吗？',
                    '250px',
                    '150px'
                );
            } else {
                $data[] = UiService::layuiTplUrlPost(
                    '安装菜单',
                    action($this->getRouteInfo('controller_name') . '@handlePost', ['type' => 'installMenu', 'id' => $item['id']]),
                    '确定安装菜单吗？',
                    '250px',
                    '150px'
                );
            }

        }

        return UiService::layuiTplArrOutput($data);

    }

    public function setListOutputItemExtend($item)
    {
        $item->install_name_html = UiService::layuiTplStatus($item->installName, $item->is_install, [0 => 'status-wait',
            1 => 'status-success',
        ]);
        return $item;
    }

    public function handlePost($type, $id, Request $request)
    {
        $plugin = $this->model->where('id', $id)->first();
        $ename = convert_under_line($plugin->ename);
        $pluginNamespace = '\Plugin\Package\\' . $ename . '\\Migrations';
        switch ($type) {
            //安装
            case 'install':
                try {
                    if ($plugin->is_install) {
                        return $this->returnSuccessApi('已安装');
                    }
                    $model = $pluginNamespace . '\Install';
                    //执行安装数据库
                    $model::up();
                    //如果填充文件存在，执行填充数据库
                    if (\App\ExtendClass\Plugin::checkPluginFile($ename . '/Migrations/Seed.php')) {
                        $model = $pluginNamespace . '\Seed';
                        //执行安装数据库
                        $model::up();
                    }
                    DB::beginTransaction();
                    //最后安装菜单
                    \App\ExtendClass\Plugin::installMenu($ename);
                    //更新插件状态
                    $plugin->is_install = 1;
                    $plugin->is_menu = 1;
                    $r = $plugin->save();

                    //写入到安装的缓存目录中

                    $storage_install_path = linux_path(storage_path('plugin')) . '/' . $plugin->ename;

                    $file_r = file_put_contents($storage_install_path, date('Y-m-d H:i:s'));

                    if ($r && $file_r) {
                        DB::commit();
                        return $this->returnSuccessApi('安装成功');
                    }
                    return $this->returnFailApi('安装失败');
                } catch (\ErrorException $e) {
                    return $this->returnFailApi(lang('安装失败') . $e->getMessage());
                }

                break;
            case 'remove':
                try {
                    DB::beginTransaction();
                    //删除菜单
                    Permission::where('type', $ename)->delete();
                    //更新菜单缓存

                    $model = $pluginNamespace . '\Install';
                    //执行安装数据库
                    $model::back();
                    $plugin->is_install = 0;
                    $r = $plugin->save();
                    //写入到安装的缓存目录中
                    $storage_install_path = linux_path(storage_path('plugin')) . '/' . $plugin->ename ;
                    $file_r = 1;
                    if (file_exists($storage_install_path)) {
                        $file_r = unlink($storage_install_path);
                    }

                    if ($r && $file_r) {
                        DB::commit();
                        Permission::getCache('admin');
                        return $this->returnSuccessApi('卸载成功');
                    }
                    DB::rollBack();
                    return $this->returnFailApi(lang('卸载失败'));
                } catch (\ErrorException $e) {
                    return $this->returnFailApi(lang('卸载失败') . $e->getMessage());
                }

                break;
            case 'removeMenu':
                try {
                    //删除菜单
                    Permission::where('type', $ename)->delete();
                    //更新菜单缓存
                    Permission::getCache('admin');
                    $plugin->is_menu = 0;
                    $plugin->save();
                    return $this->returnSuccessApi('菜单清除成功');
                } catch (\ErrorException $e) {
                    return $this->returnFailApi(lang('菜单清除失败') . $e->getMessage());
                }

                break;
            case 'installMenu':
                try {
                    $r = \App\ExtendClass\Plugin::installMenu($ename);
                    if ($r) {
                        $plugin->is_menu = 1;
                        $plugin->save();
                        return $this->returnSuccessApi('安装成功');
                    }
                    return $this->returnFailApi('安装失败');
                } catch (\ErrorException $e) {
                    return $this->returnFailApi(lang('卸载成功') . $e->getMessage());
                }

                break;
        }
    }


    //首页按钮去掉
    public function setOutputHandleBtnTpl($shareData)
    {
        //默认首页顶部添加按钮去掉
        $this->uiBlade['btn'] = $this->defaultHandleBtnDelTpl($shareData);
    }


}
