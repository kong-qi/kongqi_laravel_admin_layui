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

namespace App\TraitClass;

use Validator;

trait CheckFormTrait
{

    public $checkErrorSuffix = "<br/>";//输出验证表单的后缀连接符

    /**
     * 组定义验证验证表单
     * @param $request_data 来源数据
     * @param $check_data 验证规则
     * @param $message_data 验证规则对应提示
     * @param array $filed_name_data 字段名字对应关系名字
     * @return array 如果空数组，则表示无错误，
     */
    protected function checkForm($request_data, $check_data, $message_data = [], $field_name_data = [])
    {
        $validator = Validator::make($request_data, $check_data, $message_data, $field_name_data);
        if ($validator->fails()) {
            return $validator->errors();
        }

        return [];
    }

    /**
     * 错误输出表单转换格式
     * @param $error
     * @return array|\Illuminate\Http\JsonResponse
     */
    protected function checkFormErrorFormat($error)
    {
        $error = $error->all();
        if (empty($error)) {
            return [];
        }
        $error_str = '';
        $error_arr = [];
        foreach ($error as $k => $v) {

            $error_str .= $v . "*" ;
            if((count($error)-1)!=$k){
                $error_str.=$this->setFormErrorSuffix();
            }
            $error_arr[] = $v;

        }
        return (['msg' => $error_str, 'data' => $error_arr, 'code' => 1]);

    }

    /**
     * 设置错误信息的拼接字符
     * @return string
     */
    public function setFormErrorSuffix()
    {
        return $this->checkErrorSuffix;
    }


}