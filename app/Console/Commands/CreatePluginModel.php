<?php

namespace App\Console\Commands;

use App\Models\Plugin;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreatePluginModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:model {module} {name} {isAuth?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建插件模型 传递模块 模型名字';

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
        $module = $this->argument('module');
        $name= $this->argument('name');
        $isAuth= $this->argument('isAuth')??0;

        $plugin_model_dir=\App\ExtendClass\Plugin::getPath().$module.'/Models/';
        $plugin_model_dir=linux_path(($plugin_model_dir));
        $model_html=$this->createModel($name,$module,$isAuth);

        $r=file_put_contents($plugin_model_dir.$name.'.php',$model_html);
        if($r)
        {
           return $this->info(lang('创建成功'));
        }
        return $this->error(lang('创建失败'));


    }




    public function createModel($name,$module,$isAuth=0){
        $bname=$isAuth==1?'BaseAuthModel':'BaseModel';
        $php=<<<EOT
<?php

namespace Plugin\Package\\{$module}\\Models;


class {$name} extends {$bname}
{
   
}
EOT;
        return $php;

    }

}