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
//用于迁移数据表的

namespace Plugin\Package\Blog\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Install
{
    /**
     * 建议表命名：pn_插件标识符(小写)_表名
     */
    public static function up()
    {
        $prefix = \Illuminate\Support\Facades\DB::connection()->getTablePrefix();

        //分类
        if (!Schema::hasTable('pn_blog_categories')) {
            Schema::create('pn_blog_categories', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('parent_id')->default(0)->comment('父ID');
                $table->string('name', 120)->comment('名称');
                $table->string('ename', 120)->index('ename')->nullable()->comment('调用英文名字');
                $table->integer('sort')->default(0)->comment('排序');
                $table->tinyInteger('is_checked')->default(1)->comment('状态1:启用,0:禁用');

                $table->timestamps();
            });
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE " . $prefix . "pn_blog_categories comment '分类表'");
        }
        if (!Schema::hasTable('pn_blog_pages')) {
            Schema::create('pn_blog_pages', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name', 120)->comment('名称');
                $table->integer('category_id')->default(0)->index('category')->comment('分类id');
                $table->integer('user_id')->default(0)->index('user_id')->comment('会员ID');
                $table->text('content')->comment('内容');
                $table->integer('view_numbers')->default(0)->comment('查看人数');
                $table->integer('sort')->default(0)->comment('排序');
                $table->tinyInteger('is_checked')->default(1)->comment('状态1:启用,0:禁用');

                $table->timestamps();
            });
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE " . $prefix . "pn_blog_pages comment '文章表'");
        }
        if (!Schema::hasTable('pn_blog_users')) {
            Schema::create('pn_blog_users', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name', 120)->comment('会员名称');
                $table->string('thumb', 255)->comment('头像');
                $table->string('account', 120)->unique()->comment('会员账号');
                $table->string('password', 120)->unique()->comment('密码');
                $table->tinyInteger('is_checked')->default(1)->comment('状态1:启用,0:禁用');
                $table->timestamp('email_verified_at')->comment('邮箱验证时间')->nullable();
                $table->string('remember_token')->comment('记住密码token')->nullable();
                $table->string('session_token')->nullable()->comment('登录TOKEN');
                $table->timestamps();
            });
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE " . $prefix . "pn_blog_users comment '会员表'");
        }

    }

    //回滚移除
    public static function back()
    {
        Schema::dropIfExists('pn_blog_categories');
        Schema::dropIfExists('pn_blog_pages');
        Schema::dropIfExists('pn_blog_users');
    }
}