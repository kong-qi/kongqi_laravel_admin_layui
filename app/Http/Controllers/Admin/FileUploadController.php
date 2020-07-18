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

namespace App\Http\Controllers\Admin;

use App\Models\File;
use App\Models\FileGroup;
use Illuminate\Http\Request;
use App\ExtendClass\UploadFile;

class FileUploadController extends BaseController
{
    //
    public function handle($type, Request $request)
    {
        $editor_api=$request->input('editor_api',0);

        if ($type == 'upload') {
            return $this->upload($request);
        }
        if ($type == 'list') {
            if($editor_api && $request->input('file_type')=='video'){
                $this->setViewPath('video');
                return $this->display();
            }
            $this->setViewPath('list');
            return $this->getList($request);
        }
        if ($type == 'video') {
            $this->setViewPath('video');
            return $this->display();
        }

        if ($type == 'api') {
            return $this->getApi($request);
        }
        if ($type == 'addGroup') {
            return $this->addGroup($request);
        }
        if ($type == 'getGroup') {
            return $this->getGroup($request);
        }
        if ($type == 'icon') {
            $this->setViewPath('icon');
            return $this->display();
        }

    }



    public function getGroup()
    {
        $list = FileGroup::get()->toArray();

        return $this->returnSuccessApi('请求成功', $list);
    }

    /**
     * 添加分组
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function addGroup(Request $request)
    {
        $name = $request->input('name');

        $error = $this->checkForm($request->all(), ['name' => 'required|unique:file_groups,name']);

        if (count($error) > 0) {
            return $this->checkFormErrorFormat($error);
        };
        $data = [
            'name' => $name
        ];

        $r = FileGroup::create($data);

        if ($r) {
            return $this->returnSuccessApi(lang('添加成功'), $r);
        }
        return $this->returnFailApi(lang('添加失败'));
    }

    protected function upload($request)
    {
        $files = $request->input('files', 'file');
        $file_type = $request->input('file_type', 'image');
        $group_id = $request->input('group_id', '0');
        $method = $request->input('method', 'upload');
        $oss_type = $request->input('oss_type', config('filesystems.default'));
        $r = UploadFile::upload($files, $file_type, $method, $group_id, [],$oss_type , admin('id'));
        return response()->json($r);
    }

    public function getList($request)
    {
        $list = FileGroup::get()->toArray();

        return $this->display(['groups'=>$list]);
    }

    protected function getApi($request)
    {
        $file_type = $request->input('file_type', '');
        $oss_type = $request->input('oss_type', '');
        $offset = $request->input('offset', 1);
        $pagesize = $request->input('limit', 1);
        $offset = ($offset - 1) * $pagesize;
        $key = $request->input('key', '');
        $group_id = $request->input('group_id', '');

        $model = new File();
        if ($file_type) {
            if ($file_type == 'file') {
                $model = $model->whereIn('type', ['office', 'video', 'zip']);
            } else {
                $model = $model->where('type', $file_type);
            }

        }
        if ($key) {
            $model = $model->where('tmp_name', 'like', '%' . $key . '%');
        }
        if ($group_id) {
            $model = $model->where('group_id', $group_id);
        }
        if ($oss_type) {
            $model = $model->where('oss_type', $oss_type);
        }
        $total = $model->where('user_type', 'admin')->count();
        $data = $model->where('user_type', 'admin')->where('user_id', admin('id'))->skip($offset)->take($pagesize)->orderBy('id', 'desc')->get()->toArray();
        $str = '';

        foreach ($data as $key => $v) {
            $v['view_src'] = $v['path'];
            if ($v['type'] != 'image') {
                $img_pic = ($v['path']);
                if (in_array($v['ext'], ['.xlsx', '.xls'])) {
                    $img_pic = 'excel.jpg';
                    $img_pic = ___('/admin/images/' . $img_pic);
                }
                if (in_array($v['ext'], ['.xlsx', '.xls'])) {
                    $img_pic = 'excel.jpg';
                    $img_pic = ___('/admin/images/' . $img_pic);
                }
                if (in_array($v['ext'], ['.doc', '.docx'])) {
                    $img_pic = 'word.jpg';
                    $img_pic = ___('/admin/images/' . $img_pic);
                }
                if (in_array($v['ext'], ['zip', ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2"])) {
                    $img_pic = 'zip.jpg';
                    $img_pic = ___('/admin/images/' . $img_pic);
                }
                if (in_array($v['ext'], ['zip', ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2"])) {
                    $img_pic = 'zip.jpg';
                    $img_pic = ___('/admin/images/' . $img_pic);
                }
                if (in_array($v['ext'], [
                    ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg", ".wmv",
                    ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid", ".cab", ".iso",
                    ".ppt", ".pptx", ".pdf", ".txt", ".md", ".xml", ".psd", ".ai", ".cdr"
                ])) {
                    $img_pic = 'file.jpg';
                    $img_pic = ___('/admin/images/' . $img_pic);
                }
                $v['view_src'] = $img_pic;
            }

            if ($v['type'] == 'video') {
                $img_html = '<video   src="' . $v['path'] . '"  controls="controls"  class="img-fluid  maxH6rem w-100"></video>';
            } else {
                $img_html = ' <div class="file-choose-list-item-img "  style="background-image: url('.$v['view_src'].')" ></div>';
            }

            $str .= '<div class="file-choose-list-item upload-area-more-item" 
                    data-tmp_name="' . $v['tmp_name'] . '" 
                    data-ext="' . $v['ext'] . '" 
                    data-type="' . $v['type'] . '" 
                    data-path="' . $v['path'] . '" 
                    data-view_src="' . $v['view_src'] . '" 
                    data-oss_type="' . $v['oss_type'] . '" 
                    data-origin_path="' . $v['origin_path'] . '">
                    ' . $img_html . '
                    <div class="file-choose-list-item-name" data-tips="tooltip" title="'.$v['tmp_name'].'">' . (mb_substr($v['tmp_name'],0,20)) . '</div>
                    <div class="file-choose-list-item-ck layui-form"><div class="layui-unselect layui-form-checkbox " lay-skin="primary"><i class="layui-icon layui-icon-ok"></i></div></div>
                    </div>';

        }

        $list = [
            'total' => $total,
            'contents' => $str,
            'pagesize' => $pagesize
        ];
        $debug = $request->input('debug', 0);
        if ($debug) {
            return dump($list);
        }
        return response()->json($list);
    }
}
