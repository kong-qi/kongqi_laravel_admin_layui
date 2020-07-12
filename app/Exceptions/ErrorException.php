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

namespace App\Exceptions;

use Exception;

class ErrorException extends Exception
{
    public $msg;
    public $code;
    public $data;
    public $title = '提示';
    public $bladeTheme = '';//主题


    public function __construct($params)
    {
        if (!is_array($params)) {
            $this->msg = $params;
        }
        if (array_key_exists('code', $params)) {
            $this->code = $params['code'];
        }
        if (array_key_exists('msg', $params)) {
            $this->msg = $params['msg'];
        }
        if (array_key_exists('data', $params)) {
            $this->data = $params['data'];
        }
        if (array_key_exists('title', $params)) {
            $this->title = $params['title'];
        }
        if (array_key_exists('is_json', $params)) {
            $this->isJson = $params['is_json'];

        }
        if (array_key_exists('blade_prefix', $params)) {
            $this->bladePrefix = $params['blade_prefix'];

        }
        if (array_key_exists('theme', $params)) {
            if ($params['theme']) {
                $this->bladeTheme = $params['theme'] . '.';
            }
        }
        /**
         * 自定义错误blade输出位置
         */
        if (array_key_exists('errorBlade', $params)) {
            if ($params['errorBlade']) {
                $this->bladeTheme = $params['errorBlade'] . '.';
            }
        }
        parent::__construct($this->msg);
    }

    public function render($request)
    {

        if ($request->wantsJson()) {
            return ['code' => $this->code, 'msg' => $this->getMessage(), 'data' => $this->data];
        }
        $blade = $this->bladeTheme . 'customErros.' . $this->code;

        if (!view()->exists($blade)) {
            $blade = 'customErros.' . $this->code;
            if (!view()->exists($blade)) {
                $blade = 'customErros.404';
            }
        }

        return response()->view($blade, ['code' => $this->code, 'msg' => $this->getMessage(), 'title' => $this->title ?: $this->getMessage(), 'data' => $this->data]);

    }
}