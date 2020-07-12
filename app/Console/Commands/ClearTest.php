<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove_admin_test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '移除后台测试数据';

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
        //移除后台测试数据，保护有分类和页面文章管理
        $controller=[
            'CategoryController.php',
            'ArticleController.php'
        ];
        $model=[
            'Article.php',
            'Category.php'
        ];
        //删除文件
        foreach ($controller as $k=>$v){
            $path=linux_path(app_path('/Http/Controllers/Admin')).'/';
            unlink($path.$v);
        }
        //删除文件
        foreach ($model as $k=>$v){
            $path=linux_path(app_path('/Models')).'/';
            unlink($path.$v);
        }
        $this->info(lang('删除成功'));

    }
}
