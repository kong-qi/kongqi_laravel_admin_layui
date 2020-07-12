<?php
// +----------------------------------------------------------------------
// | KQAdmin [ 基于Laravel后台快速开发后台 ]
// | 快速laravel后台管理系统，集成了，图片上传，多图上传，批量Excel导入，批量插入，修改，添加，搜索，权限管理RBAC,验证码，助你开发快人一步。
// +----------------------------------------------------------------------
// | Copyright (c) 2012~2019 www.haoxuekeji.cn All rights reserved.
// +----------------------------------------------------------------------
// | Laravel 原创视频教程，文档教程请关注 www.heibaiketang.com
// +----------------------------------------------------------------------
// | Author: kongqi <531833998@qq.com>`
// +----------------------------------------------------------------------
// 默认填充数据

namespace Plugin\Package\Blog\Migrations;

use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Plugin\Package\Blog\Models\Category;
use Plugin\Package\Blog\Models\Page;
use Plugin\Package\Blog\Models\User;

class Seed
{
    public static function up()
    {
        $category = [
            [
                'name' => '心情',
                'created_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => '分享',
                'created_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => '讨论',
                'created_at'=>date('Y-m-d H:i:s')
            ]
        ];
        DB::table('pn_blog_categories')->insert($category);

        //随机生成会员
        app(\Illuminate\Database\Eloquent\Factory::class)->define(User::class, function (Faker $faker) {
            return [
                'name' => $faker->name(),
                'account' => $faker->unique()->safeEmail,
                'password' => bcrypt('123456'),
                'created_at'=>date('Y-m-d H:i:s')
            ];
        });
        // 生成数据集合
        $users = factory(User::class)
            ->times(10)
            ->make()->each(function($user,$index){
                $user->thumb='https://www.heibaiketang.com/plugin/forum/images/avatar/'.mt_rand(1,10).'.jpg';
            })
            ->toArray();
        DB::table('pn_blog_users')->insert($users);

        //生成page数据
        //随机生成
        app(\Illuminate\Database\Eloquent\Factory::class)->define(Page::class, function (Faker $faker) {
            return [
                'name' => $faker->name(),
                'content' => $faker->text(),
                'created_at'=>date('Y-m-d H:i:s')
            ];
        });
        $user_ids=User::limit(10)->pluck('id')->toArray();
        $category_ids=Category::limit(3)->pluck('id')->toArray();
        // 生成数据集合
        $faker = app(Faker::class );
        $page = factory(Page::class)
            ->times(100)
            ->make()->each(function ($page, $index) use ($user_ids, $category_ids, $faker)
            {
                $page->user_id = $faker->randomElement($user_ids);
                $page->category_id = $faker->randomElement($category_ids);
            })
            ->toArray();
        DB::table('pn_blog_pages')->insert($page);


    }

    //回滚填充，暂时用不到
    public static function back()
    {
        DB::table('pn_blog_categories')->truncate();
    }
}