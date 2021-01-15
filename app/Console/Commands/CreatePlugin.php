<?php

namespace App\Console\Commands;

use App\Models\Plugin;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreatePlugin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建插件';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $module = $this->ask(lang('请输入插件模块，必须首字母大写例如：Market'));
        //转换大写
        $module = Str::studly($module);

        //判断插件模块是否存在了
        $has_plugin = Plugin::where('ename', $module)->exists();
        if ($has_plugin) {
            return $this->info($module . lang('模块已经存在了'));
        }
        //创建目录
        $create_dir = [
            'Admin', 'Front', 'Migrations', 'Services', 'Models', 'Middleware', 'Route',
        ];
        $plugin_dir = \App\ExtendClass\Plugin::getPath() . $module . '/';
        $plugin_dir = linux_path($plugin_dir);
        // exit($plugin_dir);
        foreach ($create_dir as $k => $v) {
            if (!mkdir($plugin_dir . $v, '0755', 1)) {
                return $this->info($v . lang('目录创建失败'));
            }
        }
        //创建前台控制器
        $this->createFrontController($module);

        //创建迁移文件
        $migration = [
            'Update' => '更新数据库',
        ];

        //创建Install
        $admin_route = $this->createInstall($module);
        $r = file_put_contents($plugin_dir . '/Migrations/Install.php', $admin_route);
        if (!$r) {
            return $this->info(plugin_dir . "/Migrations/Install.php：文件创建失败");
        }
        //创建Seed
        $admin_route = $this->createSeed($module);
        $r = file_put_contents($plugin_dir . '/Migrations/Seed.php', $admin_route);
        if (!$r) {
            return $this->info(plugin_dir . "/Migrations/Seed.php：文件创建失败");
        }

        //创建迁移处理
        foreach ($migration as $k => $v) {
            $html = $this->createMigrate($module, $k, $v);
            $r = file_put_contents($plugin_dir . '/Migrations/' . $k . '.php', $html);
            if (!$r) {
                return $this->info($k . ".php：" . lang('文件创建失败'));
            }
        }

        //创建后台路由
        $admin_route = $this->adminRoute($module);
        $r = file_put_contents($plugin_dir . '/Route/admin.php', $admin_route);
        if (!$r) {
            return $this->info(plugin_dir . "/Route/admin.php：文件创建失败");
        }

        //创建前台路由
        $admin_route = $this->frontRoute($module);
        $r = file_put_contents($plugin_dir . '/Route/front.php', $admin_route);
        if (!$r) {
            return $this->info(plugin_dir . "/Route/front.php：文件创建失败");
        }

        //创建菜单
        $html = $this->createMenu($module);
        $r = file_put_contents($plugin_dir . 'Migrations/Menu.php', $html);
        if (!$r) {
            return $this->info($plugin_dir . 'Migrations/Menu.php：' . lang('文件创建失败'));
        }
        //创建后台
        $create_admin_controller = $this->createAdminController($module);
        //
        $r = file_put_contents($plugin_dir . 'Admin/BaseController.php', $create_admin_controller);
        if (!$r) {
            return $this->info($plugin_dir . "Admin/BaseController.php：文件创建失败");
        }
        //创建后台Curl
        $create_admin_controller = $this->createAdminCurlController($module);
        //
        $r = file_put_contents($plugin_dir . 'Admin/BaseCurlController.php', $create_admin_controller);
        if (!$r) {
            return $this->info($plugin_dir . "Admin/BaseCurlController.php：文件创建失败");
        }

        $create_admin_controller = $this->createAdminCurlIndexController($module);
        //
        $r = file_put_contents($plugin_dir . 'Admin/BaseCurlIndexController.php', $create_admin_controller);
        if (!$r) {
            return $this->info($plugin_dir . "Admin/BaseCurlIndexController.php：文件创建失败");
        }

        //创建前台
        $front_controller = $this->createFrontController($module);
        $r = file_put_contents($plugin_dir . 'Front/BaseController.php', $front_controller);
        if (!$r) {
            return $this->info($plugin_dir . "Front/BaseController.php：文件创建失败");
        }
        //创建Service
        $service = $this->createService($module);
        $r = file_put_contents($plugin_dir . 'Services/QueryWhereServices.php', $service);
        if (!$r) {
            return $this->info($plugin_dir . "Services/SearchService.php：文件创建失败");
        }
        //创建配置文件
        $tips = $this->ask(lang('请输入插件名称(中文无法识别，先写英文后面再改)'));
        $author = $this->ask(lang('请输入插件作者'));
        $config = $this->createConfig($module, $tips, $author);
        file_put_contents($plugin_dir . 'config.php', $config);
        if (!$r) {
            return $this->info($plugin_dir . "config.php：" . lang('创建失败'));
        }

        //创建Kernel
        $create_kernel = $this->createKernel();
        file_put_contents($plugin_dir . 'kernel.php', $create_kernel);
        if (!$r) {
            return $this->info($plugin_dir . "kernel.php：" . lang('创建失败'));
        }
        //createRelation
        $relation = $this->createRelation();
        $r = file_put_contents($plugin_dir . 'relation.php', $relation);
        if (!$r) {
            return $this->info($plugin_dir . "/relation.php：" . lang('创建失败'));
        }

        //create Auth
        $relation = $this->createAuth();
        $r = file_put_contents($plugin_dir . 'auth.php', $relation);
        if (!$r) {
            return $this->info($plugin_dir . "/auth.php：" . lang('创建失败'));
        }

        //创建基本类
        $base_model = $this->createBaseModel($module);
        $r = file_put_contents($plugin_dir . '/Models/BaseModel.php', $base_model);
        if (!$r) {
            return $this->info($plugin_dir . "Models/BaseModel.php：" . lang('创建失败'));
        }

        //创建基本类
        $base_model = $this->createBaseAuthModel($module);
        $r = file_put_contents($plugin_dir . '/Models/BaseAuthModel.php', $base_model);
        if (!$r) {
            return $this->info($plugin_dir . "Models/BaseAuthModel.php：" . lang('创建失败'));
        }
        return $this->info('恭喜您创建完成');

    }


    public function createAdminController($module)
    {
        $php = <<<EOT
<?php

namespace Plugin\Package\\{$module}\\Admin;

use Plugin\Plugin\Controller\Admin\PluginController;

class BaseController extends PluginController
{

}
EOT;

        return $php;

    }

    public function createAdminCurlController($module)
    {
        $php = <<<EOT
<?php

namespace Plugin\Package\\{$module}\\Admin;

use Plugin\Plugin\Controller\Admin\PluginCurlController;

class BaseCurlController extends PluginCurlController
{
}
EOT;

        return $php;

    }

    public function createAdminCurlIndexController($module)
    {
        $php = <<<EOT
<?php

namespace Plugin\Package\\{$module}\\Admin;

class BaseCurlIndexController extends BaseCurlController
{
EOT;
        $php .= '//没有添加和编辑页面
    public function editUrlShow($item)
    {
        $item[\'edit_url\'] = \'\';
        $item[\'edit_post_url\'] = \'\';
        return $item;
    }

    //列表操作按钮去掉
    public function listHandleBtnCreate($item)
    {
        $this->uiBlade[\'btn\'] = [];
    }
    //首页按钮去掉
    public function setOutputHandleBtnTpl($shareData)
    {
        //默认首页顶部添加按钮去掉
        $this->uiBlade[\'btn\']=[];
    }' . "\n" . '
    }' . "\n" . '?>';

        return $php;

    }

    //前台控制器文件
    public function createFrontController($module)
    {
        $php = <<<EOT
<?php

namespace Plugin\Package\\{$module}\\Front;

use Plugin\Plugin\Controller\Front\PluginController;

class BaseController extends  PluginController
{
    

}
EOT;
        return $php;
    }

    public function createMigrate($module, $name, $tips = '')
    {
        $php = <<<EOT
<?php

namespace Plugin\Package\\{$module}\\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\ExtendClass\Plugin;


class {$name}
{
    public static function up()
    {


    }
     public static function back()
    {
       
    }
}
EOT;
        return $php;
    }

    public function createMenu($module)
    {
        $module=(lcfirst($module));
        $php = <<<EOT
<?php

namespace Plugin\Package\\{$module}\\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\ExtendClass\Plugin;


class Menu
{
    public static \$name = '';//根级菜单名称
    public static \$icon = 'fas fa fa-bold';//根级菜单图标
    public static function up()
    {
        /**
         * 必须第一个插件的，其他都是子插件
         * 路有名称路径
         * {$module}.admin.页面控制名称（去除Controller）.控制器方法名称（小驼峰）,例如下面
         * {$module}.admin.categoryExtend.helloWord
         * {$module}.admin.category.hello
         * 查看 app/ExtendClass/Plugin.php 有更多快捷方法
         */
EOT;
        $php .= "\n" . '
         $module=\'' . (($module)) . '\';
        $data = [
            //Plugin::pluginMenuNameData(\'博客配置\', $module.\'.admin.config.index\', 1,1),
           // Plugin::groupCurlRouteData(\'文章管理\', \'fa fa-files\', \'1\', $module.\'.admin.page\'),//一组权限

        ];

        return $data;

    }
     public static function back()
    {
       
    }
}';
        return $php;

    }

    public function createInstall($module)
    {
        $php = <<<EOT
<?php

namespace Plugin\Package\\{$module}\\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class Install
{
 /**
     * 建议表命名：pn_插件标识符(小写)_表名
     */
    public static function up()
    {
EOT;

        $php .= '
        //数据库表前缀
        $prefix = \Illuminate\Support\Facades\DB::connection()->getTablePrefix();';
    $php .=<<<EOT
        //参考
        /**
        if (!Schema::hasTable('pn_blog_categories')) {
            Schema::create('pn_blog_categories', function (Blueprint \$table) {
                \$table->bigIncrements('id');
                \$table->integer('parent_id')->default(0)->comment('父ID');
                \$table->string('name', 120)->comment('名称');
                \$table->string('ename', 120)->index('ename')->nullable()->comment('调用英文名字');
                \$table->integer('sort')->default(0)->comment('排序');
                \$table->tinyInteger('is_checked')->default(1)->comment('状态1:启用,0:禁用');
                \$table->timestamps();
            });
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE " . \$prefix . "pn_blog_categories comment '分类表'");
        }
         */
EOT;
        $php .= "\n".'}
         //回滚移除
     public static function back()
    {
       //例如 Schema::dropIfExists(\'pn_blog_categories\');
    }
}';
        return $php;
    }

    public function createSeed($module){
        $php = <<<EOT
<?php

namespace Plugin\Package\\{$module}\\Migrations;

use Illuminate\Support\Facades\DB;


class Seed
{
    public static function up()
    {
      /*
      例如
      \$category = [
            [
                'name' => '心情',
                'created_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => '分享',
                'created_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => '讨论',
                'created_at'=>date('Y-m-d H:i:s')
            ]
        ];
        DB::table('pn_blog_categories')->insert(\$category);*/
    }
     //回滚填充，暂时用不到
    public static function back()
    {
        DB::table('pn_blog_categories')->truncate();
    }
}
EOT;
return $php;

    }

    public function createService($module)
    {
        $php = <<<EOT
<?php

namespace Plugin\Package\\{$module}\\Services;

use Plugin\Plugin\Services\SearchServices;

class QueryWhereServices extends SearchServices
{
     //这里写的查询条件语句
    //开头格式必须是 whereBy,后面是驼峰形式编写
    //不懂的可以查看plugin/Plugin/Services/QueryWhereTrait.php这里面几个写法参考
}
EOT;
        return $php;
    }

    public function createKernel()
    {
        $php = <<<EOT
<?php
//格式跟app/Http/Kernel.php一致。例如
/*
   return [
        'group'=>[
                 'test' => [
                    \App\Http\Middleware\EncryptCookies::class
                 ]
            ],
        'middleware'=>[
                'test'=>App\Test::class
        ]
   ];
*/
return [
    "group" => [
    ],
    "middleware" => [
    
    ]
];
EOT;
        return $php;
    }

    public function createAuth()
    {
        $php = <<<EOT
<?php

return [
    //格式跟config/auth.php一样
    /*
    例如
     'guards' => [
        'blog_user' => [
            'driver' => 'session',
            'provider' => 'blog_user',
        ]
    ],
    'providers' => [
        'blog_user' => [
            'driver' => 'eloquent',
            'model' => \Plugin\Package\Blog\Models\User::class,
        ],
    ]
    */
   'guards' => [
        'blog_user' => [
           
        ]
    ],
    'providers' => [
        
    ]
];
EOT;
        return $php;

    }

    public function createRelation()
    {
        $php = <<<EOT
<?php
//格式 key=>value
/**
return [
    'admin'=>App\Models\Admin::class,
    'page'=>App\Models\Page::class,
]
*/
return [
   
];
EOT;
        return $php;
    }

    public function createConfig($module, $name, $author = '')
    {
        $arr = [
            'name' => $name,//插件名称
            'version' => '1.0.0',//版本
            'author' => $author,//作者
            'intro' => '',//描述
            'thumb' => 'plugin/' . lcfirst($module) . '/images/intro.jpg',
            'plugin_data' => [
                //这里是附加信息，可以写文档信息
                'doc_url' => '',//文档地址
                'test_url' => '',//演示地址
                'qq' => '',//联系QQ
                'mobile' => '',//手机
                'weixin' => '',//微信
            ]
        ];
        $str = '<?php return ' . var_export($arr, true) . ';';
        return $str;
    }

    public function createBaseModel($model)
    {
        $php = <<<EOT
<?php


namespace Plugin\Package\\{$model}\\Models;

use Plugin\Plugin\Models\PluginBaseModel;
use  Plugin\Package\\{$model}\\Services\QueryWhereServices;
class BaseModel extends PluginBaseModel
{
EOT;
        $php .= '/**
     * 修改查询条件定位到自己的模块Services
     * @param \App\TraitClass\对象类型，传递模型 $model
     * @param \App\TraitClass\数组类型，查询数据， $data
     * @param string $type
     * @return mixed
     */
    public static function getSearchModel($model, $data, $type = \'\')
    {

        $search = new QueryWhereServices($model, $data, $type);
        $search->unsetAllWhere();
        return $search->returnModel();
    }';
        $php .= "\n}";

        return $php;

    }

    public function createBaseAuthModel($model)
    {
        $php = <<<EOT
<?php


namespace Plugin\Package\\{$model}\\Models;

use Plugin\Plugin\Models\PluginAuthModel;
use  Plugin\Package\\{$model}\\Services\QueryWhereServices;

class BaseAuthModel extends PluginAuthModel
{
EOT;
        $php .= '/**
     * 修改查询条件定位到自己的模块Services
     * @param \App\TraitClass\对象类型，传递模型 $model
     * @param \App\TraitClass\数组类型，查询数据， $data
     * @param string $type
     * @return mixed
     */
    public static function getSearchModel($model, $data, $type = \'\')
    {

        $search = new QueryWhereServices($model, $data, $type);
        $search->unsetAllWhere();
        return $search->returnModel();
    }';
        $php .= "\n}";
        return $php;

    }

    public function adminRoute($module)
    {
        $php = "<?php\n" . '

use Illuminate\Support\Facades\Route;

Route::namespace(\'Admin\')->group(function ($route) {


    //前缀，肯定使我们的插件的标识符，需要加水插件前缀
    $checkPermissionRoutePrefix = \'admin.plugin.' . lcfirst($module) . '.\';
    //资源路由数组
    $resource = [
        \'IndexController\',

    ];
    //批量添加控制器
    $batch = [

    ];

    //只有首页
    $only_index = [

    ];

    //首页和添加页面
    $only_index_add = [

    ];
    //首页和添加和编辑页面，没有删除页面
    $only_index_add_edit = [

    ];

    foreach ($resource as $c) {
        //自动获取
        $controller = str_replace(\'Controller\', \'\', $c);

        $route_name = lcfirst($controller);//首字母小写

        $route->group([\'prefix\' => $route_name . \'/\'], function ($route) use ($c, $route_name, $checkPermissionRoutePrefix) {
            $permission_rule = \'permission:\' . $checkPermissionRoutePrefix . $route_name . \'.\';

            $route->get(\'/\', $c . \'@index\')->name($route_name . ".index")->middleware($permission_rule . \'index\');
            $route->get(\'create\', $c . \'@create\')->name($route_name . ".create")->middleware($permission_rule . \'create\');
            $route->get(\'show/{id}\', $c . \'@show\')->name($route_name . ".show")->middleware($permission_rule . \'show\');
            $route->post(\'store\', $c . \'@store\')->name($route_name . ".store")->middleware($permission_rule . \'create\');
            $route->get(\'edit/{id}\', $c . \'@edit\')->name($route_name . ".edit")->middleware($permission_rule . \'edit\');
            $route->put(\'update/{id}\', $c . \'@update\')->name($route_name . ".update")->middleware($permission_rule . \'edit\');
            $route->put(\'delete/\', $c . \'@destroy\')->name($route_name . ".destroy")->middleware($permission_rule . \'destroy\');
            $route->post(\'edit_list/\', $c . \'@editTable\')->name($route_name . ".edit_list")->middleware($permission_rule . \'edit\');
            $route->any(\'/list\', $c . \'@getList\')->name($route_name . ".list")->middleware($permission_rule . \'index\');
            $route->any(\'copy/\', $c . \'@copy\')->name($route_name . ".copy")->middleware($permission_rule . \'create\');
          


        });
    }
    //批量导入和批量添加
    foreach ($batch as $c) {
        //自动获取
        $controller = str_replace(\'Controller\', \'\', $c);
        $route_name = lcfirst($controller);//首字母小写
        $route->group([\'prefix\' => $route_name . \'/\'], function ($route) use ($c, $route_name, $checkPermissionRoutePrefix) {
            $permission_rule = \'permission:\' . $checkPermissionRoutePrefix . $route_name . \'.\';
            $route->get(\'/batch/create\', [\'uses\' => $c . \'@batchCreate\'])->name($route_name . \'.batch_create\')->middleware($permission_rule . "batch");
            $route->post(\'/batch/create/post\', [\'uses\' => $c . \'@batchCreatePost\'])->name($route_name . \'.batch_create_post\')->middleware($permission_rule . "batch");
            $route->post(\'/import/post\', [\'uses\' => $c . \'@importPost\'])->name($route_name . \'.import_post\')->middleware($permission_rule . "import");
            $route->get(\'/import/tpl\', [\'uses\' => $c . \'@importTpl\'])->name($route_name . \'.import\')->middleware($permission_rule . "import");

        });
    }
    //只有首页
    foreach ($only_index as $c) {
        //自动获取
        $controller = str_replace(\'Controller\', \'\', $c);
        $route_name = lcfirst($controller);//首字母小写

        $route->group([\'prefix\' => $route_name . \'/\'], function ($route) use ($c, $route_name, $checkPermissionRoutePrefix) {
            $permission_rule = \'permission:\' . $checkPermissionRoutePrefix . $route_name . \'.\';
            $route->get(\'/\', $c . \'@index\')->name($route_name . ".index")->middleware($permission_rule . \'index\');
            $route->any(\'/list\', [\'uses\' => $c . \'@getList\'])->name($route_name . ".list")->middleware($permission_rule . \'index\');
        });
    }
    //首页和添加页面
    foreach ($only_index_add as $c) {
        //自动获取
        $controller = str_replace(\'Controller\', \'\', $c);
        $route_name = lcfirst($controller);//首字母小写
        $route->group([\'prefix\' => $route_name . \'/\'], function ($route) use ($c, $route_name, $checkPermissionRoutePrefix) {
            $permission_rule = \'permission:\' . $checkPermissionRoutePrefix . $route_name . \'.\';
            $route->get(\'/\', $c . \'@index\')->name($route_name . ".index")->middleware($permission_rule . \'index\');
            $route->any(\'/list\', [\'uses\' => $c . \'@getList\'])->name($route_name . ".list")->middleware($permission_rule . \'index\');
            $route->get(\'create\', $c . \'@create\')->name($route_name . ".create")->middleware($permission_rule . \'create\');
            $route->post(\'store\', $c . \'@store\')->name($route_name . ".store")->middleware($permission_rule . \'create\');
            $route->any(\'copy/\', $c . \'@copy\')->name($route_name . ".copy")->middleware($permission_rule . \'create\');
          
        });
    }
    //首页和添加页面，编辑页面
    foreach ($only_index_add_edit as $c) {
        //自动获取
        $controller = str_replace(\'Controller\', \'\', $c);
        $route_name = lcfirst($controller);//首字母小写
        $route->group([\'prefix\' => $route_name . \'/\'], function ($route) use ($c, $route_name, $checkPermissionRoutePrefix) {
            $permission_rule = \'permission:\' . $checkPermissionRoutePrefix . $route_name . \'.\';
            $route->get(\'/\', $c . \'@index\')->name($route_name . ".index")->middleware($permission_rule . \'index\');
            $route->get(\'create\', $c . \'@create\')->name($route_name . ".create")->middleware($permission_rule . \'create\');
            $route->get(\'show/{id}\', $c . \'@show\')->name($route_name . ".show")->middleware($permission_rule . \'show\');
            $route->post(\'store\', $c . \'@store\')->name($route_name . ".store")->middleware($permission_rule . \'create\');
            $route->get(\'edit/{id}\', $c . \'@edit\')->name($route_name . ".edit")->middleware($permission_rule . \'edit\');
            $route->put(\'update/{id}\', $c . \'@update\')->name($route_name . ".update")->middleware($permission_rule . \'edit\');
            $route->post(\'edit_list/\', $c . \'@editTable\')->name($route_name . ".edit_list")->middleware($permission_rule . \'edit\');
            $route->any(\'/list\', [\'uses\' => $c . \'@getList\'])->name($route_name . ".list")->middleware($permission_rule . \'index\');
            $route->any(\'copy/\', $c . \'@copy\')->name($route_name . ".copy")->middleware($permission_rule . \'create\');
          
        });
    }' . "\n" . '

});' . "\n" . '
?>';
        return $php;
    }

    public function frontRoute($module)
    {
        $module = lcfirst($module);
        $php = '<?php' . "\n" . '

use Illuminate\Support\Facades\Route;

//绑定域名
$domain = config_cache_default(\'' . $module . '.domain\');
//路径
$path = config_cache_default(\'' . $module . '.path\', \'' . $module . '\');

//如果绑定了域名则走域名，如果绑定了路径，则走路径，只能2选一, 如果你需要多个，那你下面改下即可
if ($domain) {
    $route = Route::domain($domain);
} else {
    $route = Route::prefix($path);
}

$route->namespace(\'Front\')->group(function ($route) {
    //写你的路由啊
});' . "\n" . '
?>';
        return $php;
    }
}