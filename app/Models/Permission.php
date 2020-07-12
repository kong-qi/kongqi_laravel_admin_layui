<?php
// +----------------------------------------------------------------------
// | KongQiAdminBase [ Laravel快速后台开发 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012~2019 http://www.kongqikeji.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kongqi <531833998@qq.com>`
// +----------------------------------------------------------------------
namespace App\Models;

use App\TraitClass\SearchScopeTrait;
use Illuminate\Support\Facades\Cache;

class Permission extends \Spatie\Permission\Models\Permission
{

    use SearchScopeTrait;

    protected $guarded = [];

    //子级
    public function childs()
    {
        return $this->hasMany('App\Models\Permission', 'parent_id', 'id')->orderBy('sort','desc');
    }
    public static function getCache($guard_name='admin'){

        Cache::forget("spatie.permission.cache");
        $permission=self::whereIf('guard_name',$guard_name)->orderBy('sort','desc')->get()->toArray();
        Cache::forever('admin_menu',tree($permission));
        return $permission;
    }

}
