<?php
//帮助函数命名建议，pn_插件标识符小驼峰_函数名
/**
 * 取得分类
 * @return mixed
 */
function pn_blog_category()
{
    return \Plugin\Package\Blog\Models\Category::checked()->get();
}

/**
 * 博客会员
 * @param $field
 * @return mixed
 */
function pn_blog_user($field='')
{
    return user($field, 'blog_user');
}

function pn_blog_user_list($limit=10)
{
    return \Plugin\Package\Blog\Models\User::checked()->limit($limit)->orderBy('created_at','desc')->get();
}

?>