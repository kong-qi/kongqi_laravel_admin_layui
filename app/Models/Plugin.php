<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plugin extends BaseModel
{
    public static function installDb(){
        $plugins=self::pluck('ename')->toArray();

        $data=\App\ExtendClass\Plugin::autoInstallData($plugins);
        if(!empty($data)){
            return self::insert($data);
        }
        return false;

    }
    public static function getInstall($field = 'arr')
    {
        $type = [
            0 => '未安装',
            1 => '已安装',
        ];

        if ($field === 'arr') {
            return $type;
        }
        return $type[$field] ?? $type;
    }

    /**
     * 取得支付状态
     * @return array|mixed
     */
    public function getInstallNameAttribute()
    {
        return static::getInstall($this->is_install);
    }
}
