<?php

namespace Plugin\Package\Blog\Models;

class User extends BaseAuthModel
{
    public $table = 'pn_blog_users';

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
}