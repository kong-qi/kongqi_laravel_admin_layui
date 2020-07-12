<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends AuthModel
{
    /**
     * 自动设置密码加密
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        //值存在就更新
        if ($password) {
            $this->attributes['password'] = bcrypt($password);
        }

    }
    public function getNameAttribute()
    {
        //值存在就更新

           return $this->nickname;


    }

}
