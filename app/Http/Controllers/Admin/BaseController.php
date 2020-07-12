<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\TraitClass\ApiTrait;
use App\TraitClass\BladeTrait;
use App\TraitClass\CheckFormTrait;
use App\TraitClass\RouteTrait;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    use ApiTrait, CheckFormTrait, RouteTrait, BladeTrait;
    public function __construct()
    {
        $this->module='Admin';
        $this->routeInfo($this->module);
        //设置资源版本号
        $this->setResVersion(config_cache_default('config.cache_version',2));
        //设置主题
        $this->setBladeTheme('default');
        //自动视图
        $this->setAutoBlade();
        //视图名称
        $this->getPageName();



    }

}
