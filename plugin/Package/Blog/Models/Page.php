<?php

namespace Plugin\Package\Blog\Models;



class Page extends BaseAuthModel
{
    public $table = 'pn_blog_pages';

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}