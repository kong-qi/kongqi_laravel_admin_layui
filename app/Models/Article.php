<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends BaseModel
{
    //
    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
}
