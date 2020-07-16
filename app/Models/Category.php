<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends BaseModel
{
    //子级
    public function childs()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->orderBy('id','asc');
    }
}
