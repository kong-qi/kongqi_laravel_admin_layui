<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminInitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $admins = [
            [
                'nickname' => '超级管理员',
                'account' => 'kongqi',
                'session_token' => '2uKZYdXMapsmUvTCvqbNin4yNCbOpGvMk8LstseA',
                'password' => bcrypt('kongqi1688'),
                'is_root'=>1
            ]
        ];
        DB::table('admins')->truncate();
        DB::table('admins')->insert($admins);
        $permissions = array(
            array('id' => '1','name' => '0','type' => 'default','sort' => '98','parent_id' => '0','icon' => 'layui-icon layui-icon-group','cn_name' => '权限管理','menu_name' => '权限管理','menu_show' => '1','guard_name' => 'admin','created_at' => '2020-05-19 03:55:45','updated_at' => '2020-07-11 16:00:35'),
            array('id' => '2','name' => 'admin.admin.index','type' => 'default','sort' => '0','parent_id' => '1','icon' => 'fa fa-user','cn_name' => '管理员','menu_name' => '管理员','menu_show' => '1','guard_name' => 'admin','created_at' => '2020-05-19 03:56:38','updated_at' => '2020-05-19 14:35:59'),
            array('id' => '3','name' => 'admin.admin.create','type' => 'default','sort' => '0','parent_id' => '2','icon' => '','cn_name' => '管理员添加','menu_name' => '管理员添加','menu_show' => '1','guard_name' => 'admin','created_at' => NULL,'updated_at' => '2020-05-19 03:59:23'),
            array('id' => '4','name' => 'admin.admin.edit','type' => 'default','sort' => '0','parent_id' => '2','icon' => '','cn_name' => '管理员编辑','menu_name' => '管理员编辑','menu_show' => '1','guard_name' => 'admin','created_at' => NULL,'updated_at' => '2020-05-19 03:59:24'),
            array('id' => '5','name' => 'admin.admin.destroy','type' => 'default','sort' => '0','parent_id' => '2','icon' => '','cn_name' => '管理员删除','menu_name' => '管理员删除','menu_show' => '1','guard_name' => 'admin','created_at' => NULL,'updated_at' => '2020-05-19 03:59:22'),
            array('id' => '6','name' => 'admin.admin.show','type' => 'default','sort' => '0','parent_id' => '2','icon' => '','cn_name' => '管理员详情','menu_name' => '管理员详情','menu_show' => '1','guard_name' => 'admin','created_at' => NULL,'updated_at' => '2020-05-19 03:59:22'),
            array('id' => '7','name' => 'admin.adminRole.index','type' => 'default','sort' => '0','parent_id' => '1','icon' => 'fa fa-users','cn_name' => '角色管理','menu_name' => '角色管理','menu_show' => '1','guard_name' => 'admin','created_at' => '2020-05-19 03:58:59','updated_at' => '2020-05-19 03:59:02'),
            array('id' => '8','name' => 'admin.adminRole.create','type' => 'default','sort' => '0','parent_id' => '7','icon' => NULL,'cn_name' => '角色管理添加','menu_name' => '角色管理添加','menu_show' => '1','guard_name' => 'admin','created_at' => NULL,'updated_at' => '2020-05-19 03:59:21'),
            array('id' => '9','name' => 'admin.adminRole.edit','type' => 'default','sort' => '0','parent_id' => '7','icon' => NULL,'cn_name' => '角色管理编辑','menu_name' => '角色管理编辑','menu_show' => '1','guard_name' => 'admin','created_at' => NULL,'updated_at' => '2020-05-19 03:59:20'),
            array('id' => '10','name' => 'admin.adminRole.destroy','type' => 'default','sort' => '0','parent_id' => '7','icon' => NULL,'cn_name' => '角色管理删除','menu_name' => '角色管理删除','menu_show' => '1','guard_name' => 'admin','created_at' => NULL,'updated_at' => '2020-05-19 03:59:21'),
            array('id' => '11','name' => 'admin.adminRole.show','type' => 'default','sort' => '0','parent_id' => '7','icon' => NULL,'cn_name' => '角色管理详情','menu_name' => '角色管理详情','menu_show' => '1','guard_name' => 'admin','created_at' => NULL,'updated_at' => '2020-05-19 03:59:19'),
            array('id' => '12','name' => 'admin.adminPermission.index','type' => 'default','sort' => '0','parent_id' => '1','icon' => 'fa fa-filter','cn_name' => '权限规则','menu_name' => '权限规则','menu_show' => '1','guard_name' => 'admin','created_at' => '2020-05-19 04:01:18','updated_at' => '2020-05-19 05:20:14'),
            array('id' => '13','name' => 'admin.adminPermission.create','type' => 'default','sort' => '0','parent_id' => '12','icon' => NULL,'cn_name' => '权限规则添加','menu_name' => '权限规则添加','menu_show' => '1','guard_name' => 'admin','created_at' => NULL,'updated_at' => '2020-05-19 04:01:47'),
            array('id' => '14','name' => 'admin.adminPermission.edit','type' => 'default','sort' => '0','parent_id' => '12','icon' => NULL,'cn_name' => '权限规则编辑','menu_name' => '权限规则编辑','menu_show' => '1','guard_name' => 'admin','created_at' => NULL,'updated_at' => '2020-05-19 04:01:46'),
            array('id' => '15','name' => 'admin.adminPermission.destroy','type' => 'default','sort' => '0','parent_id' => '12','icon' => NULL,'cn_name' => '权限规则删除','menu_name' => '权限规则删除','menu_show' => '1','guard_name' => 'admin','created_at' => NULL,'updated_at' => '2020-05-19 04:01:46'),
            array('id' => '16','name' => 'admin.adminPermission.show','type' => 'default','sort' => '0','parent_id' => '12','icon' => NULL,'cn_name' => '权限规则详情','menu_name' => '权限规则详情','menu_show' => '1','guard_name' => 'admin','created_at' => NULL,'updated_at' => '2020-05-19 04:01:45'),
            array('id' => '17','name' => 'admin.home','type' => 'default','sort' => '1000','parent_id' => '0','icon' => 'layui-icon layui-icon-home','cn_name' => '首页','menu_name' => '首页','menu_show' => '1','guard_name' => 'admin','created_at' => '2020-05-19 05:46:26','updated_at' => '2020-07-11 16:17:33'),
            array('id' => '18','name' => '0','type' => 'default','sort' => '99','parent_id' => '0','icon' => 'layui-icon layui-icon-set-fill','cn_name' => '网站配置','menu_name' => '网站配置','menu_show' => '1','guard_name' => 'admin','created_at' => '2020-05-19 06:10:06','updated_at' => '2020-07-11 16:00:20'),
            array('id' => '19','name' => 'admin.article.index','type' => 'default','sort' => '0','parent_id' => '0','icon' => 'layui-icon layui-icon-list','cn_name' => '文章资讯','menu_name' => '文章资讯','menu_show' => '1','guard_name' => 'admin','created_at' => '2020-05-19 06:12:04','updated_at' => '2020-07-11 16:02:47'),
            array('id' => '20','name' => 'admin.article.create','type' => 'default','sort' => '0','parent_id' => '19','icon' => NULL,'cn_name' => '文章资讯添加','menu_name' => '文章资讯添加','menu_show' => '0','guard_name' => 'admin','created_at' => NULL,'updated_at' => '2020-05-19 06:13:21'),
            array('id' => '21','name' => 'admin.article.edit','type' => 'default','sort' => '0','parent_id' => '19','icon' => NULL,'cn_name' => '文章资讯编辑','menu_name' => '文章资讯编辑','menu_show' => '0','guard_name' => 'admin','created_at' => NULL,'updated_at' => '2020-05-19 06:13:21'),
            array('id' => '22','name' => 'admin.article.destroy','type' => 'default','sort' => '0','parent_id' => '19','icon' => NULL,'cn_name' => '文章资讯删除','menu_name' => '文章资讯删除','menu_show' => '0','guard_name' => 'admin','created_at' => NULL,'updated_at' => '2020-05-19 06:13:19'),
            array('id' => '23','name' => 'admin.article.show','type' => 'default','sort' => '0','parent_id' => '19','icon' => NULL,'cn_name' => '文章资讯详情','menu_name' => '文章资讯详情','menu_show' => '0','guard_name' => 'admin','created_at' => NULL,'updated_at' => '2020-05-19 06:13:18'),
            array('id' => '24','name' => 'admin.config.index','type' => 'default','sort' => '0','parent_id' => '18','icon' => '','cn_name' => '基础配置','menu_name' => '基础配置','menu_show' => '1','guard_name' => 'admin','created_at' => '2020-05-19 06:28:37','updated_at' => '2020-05-19 06:28:37'),
            array('id' => '26','name' => 'admin.category.index','type' => 'default','sort' => '0','parent_id' => '0','icon' => 'layui-icon layui-icon-templeate-1','cn_name' => '分类栏目','menu_name' => '分类栏目','menu_show' => '1','guard_name' => 'admin','created_at' => '2020-05-19 06:38:38','updated_at' => '2020-07-11 16:02:18'),
            array('id' => '27','name' => 'admin.category.create','type' => 'default','sort' => '0','parent_id' => '26','icon' => NULL,'cn_name' => '分类栏目添加','menu_name' => '分类栏目添加','menu_show' => '0','guard_name' => 'admin','created_at' => NULL,'updated_at' => NULL),
            array('id' => '28','name' => 'admin.category.edit','type' => 'default','sort' => '0','parent_id' => '26','icon' => NULL,'cn_name' => '分类栏目编辑','menu_name' => '分类栏目编辑','menu_show' => '0','guard_name' => 'admin','created_at' => NULL,'updated_at' => NULL),
            array('id' => '29','name' => 'admin.category.destroy','type' => 'default','sort' => '0','parent_id' => '26','icon' => NULL,'cn_name' => '分类栏目删除','menu_name' => '分类栏目删除','menu_show' => '0','guard_name' => 'admin','created_at' => NULL,'updated_at' => NULL),
            array('id' => '30','name' => 'admin.category.show','type' => 'default','sort' => '0','parent_id' => '26','icon' => NULL,'cn_name' => '分类栏目详情','menu_name' => '分类栏目详情','menu_show' => '0','guard_name' => 'admin','created_at' => NULL,'updated_at' => NULL),
            array('id' => '31','name' => 'admin.category.batch','type' => 'default','sort' => '0','parent_id' => '26','icon' => NULL,'cn_name' => '分类栏目批量添加','menu_name' => '分类栏目批量添加','menu_show' => '0','guard_name' => 'admin','created_at' => NULL,'updated_at' => NULL),
            array('id' => '32','name' => 'admin.log.index','type' => 'default','sort' => '0','parent_id' => '0','icon' => 'layui-icon layui-icon-list','cn_name' => '操作日志','menu_name' => '操作日志','menu_show' => '1','guard_name' => 'admin','created_at' => '2020-05-19 16:37:39','updated_at' => '2020-07-11 16:01:20'),
          );
        if (env('OPEN_PLUGIN', 1)) {
            $permissions[]=['id' => '33', 'name' => 'admin.package.index', 'type' => 'default', 'sort' => '0', 'parent_id' => '0', 'icon' => 'layui-icon layui-icon-star-fill', 'cn_name' => '插件管理', 'menu_name' => '插件管理', 'menu_show' => '1', 'guard_name' => 'admin', 'created_at' => '2020-05-19 16:37:39', 'updated_at' => '2020-05-19 16:37:39'];
        }
        DB::table('permissions')->truncate();
        DB::table('permissions')->insert($permissions);

    }
}
