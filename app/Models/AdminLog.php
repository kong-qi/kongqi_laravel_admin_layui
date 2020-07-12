<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLog extends BaseModel
{
    public static function addLog($str, $type = 'log')
    {
        $table = new self();
        $table->admin_id = admin('id');
        $table->admin_name = admin('nickname');
        $table->ip = request()->getClientIp();
        $table->type = $type;
        $table->name = $str;
        $table->url = url(request()->path());//操作路径

        return $table->save();
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public static function type($key = 'arr')
    {
        $arr = [
            'log' => '日志',
            'login' => '登录'
        ];
        if ($key === 'arr') {
            return $arr;
        }
        return $arr[$key]??'';
    }
    public function getNameAttribute()
    {
        //值存在就更新

        return self::type($this->type);


    }

}
