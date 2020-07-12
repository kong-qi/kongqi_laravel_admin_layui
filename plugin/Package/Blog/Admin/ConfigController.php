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

namespace Plugin\Package\Blog\Admin;

use App\Models\Config;
use Illuminate\Http\Request;

class ConfigController extends BaseCurlController
{
    //去掉公共模板
    public $commonBladePath = '';
    public $pageName = '博客配置';

    public function indexShareData()
    {
        $this->setControllerViewPath('commonCurl.');
        $this->setViewPath('config');
        //配置名称，写你的插件标识符，这样不会冲突
        $config_name = \request()->input('group_type', 'blog');
        $config = config_cache($config_name);
        $config = is_array($config) ? $config : [];



        $this->setOutputUiCreateEditForm($config);

    }

    //4.编辑和添加页面表单数据
    public function setOutputUiCreateEditForm($show = '')
    {

        $data = [
            [
                'group_name' => '基础配置',
                'data' => [
                    [
                        'field' => 'group_type',
                        'type' => 'hidden',
                        'name' => '配置类型',
                        'value' => 'blog'//写插件的标识符，小驼峰形式
                    ],
                    [
                        'field' => 'name',
                        'type' => 'text',
                        'name' => '网站名称',
                        'must' => 1,
                        'verify' => 'rq',
                        'default'=>'我的第一个博客'
                    ],
                    [
                        'field' => 'cache_version',
                        'type' => 'text',
                        'name' => '前端缓存版本号',
                        'must' => 1,
                        'verify' => 'rq',
                        'default'=>'1.0'
                    ],
                    [
                        'field' => 'logo',
                        'type' => 'img',
                        'name' => '网站LOGO',
                        'must' => 1,
                        'verify' => 'rq'
                    ],
                    [
                        'field' => 'domain',
                        'type' => 'text',
                        'name' => '访问入口域名',
                        'must' => '',
                        'verify' => '',
                        'mark' => '如果绑定了域名，则目录无效'
                    ],
                    [
                        'field' => 'path',
                        'type' => 'text',
                        'name' => '访问入口路径',
                        'must' => '',
                        'verify' => '',
                        'default' => 'blog',//默认值
                        'mark' => '如果没有绑定域名默认走主域名+这个目录地址'
                    ]
                ]
            ]

        ];

        //赋值到ui数组里面必须是`formShowBtn`的key值,这里会显示按钮图标
        $this->uiBlade['formShowBtn'] = $data;
        $this->uiBlade['show'] = $show;

    }

    public function setModel()
    {
        return new Config();
    }

    public function store(Request $request)
    {
        $config_name = $request->input('group_type', 'blog');
        config_cache($config_name, $request->all());
        $this->insertLog(lang('系统配置成功'));
        return $this->returnSuccessApi('设置成功');

    }

    //去掉按钮
    public function setOutputHandleBtnTpl($shareData)
    {
        return $this->uiBlade['btn'] = [];
    }
}