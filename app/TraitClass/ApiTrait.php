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

trait ApiTrait
{
    public $apiToArray = 0;//API将API转换成数组输出

    /**
     * 输出API格式
     * @param $code 业务代码
     * @param $msg 提示信息
     * @param $data 数据
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function returnApi($code, $msg, $data = [])
    {
        $json_data = [
            'code' => $code,//业务代码
            'msg' => lang($msg),
            'data' => $data
        ];
        if ($this->apiToArray == 1) {
            return $json_data;
        }

        return response()->json($json_data);
    }

    /**
     * 输出API设置数组格式
     */
    public function returnApiData($data)
    {
        if ($this->apiToArray == 1) {
            return $data;
        }
        return response()->json($data);
    }

    /**
     * 正确API返回格式
     * @param string $msg
     * @param array $data
     * @param int $code
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function returnSuccessApi($msg = '成功', $data = [], $code = 200)
    {
        return $this->returnApi($code, $msg, $data);
    }

    /**
     * 错误输出API格式
     * @param string $msg
     * @param array $data
     * @param int $code
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function returnFailApi($msg = '失败', $data = [], $code = 1)
    {
        return $this->returnApi($code, $msg, $data);
    }


}