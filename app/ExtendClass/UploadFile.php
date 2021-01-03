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

namespace App\ExtendClass;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Auth;
use AnyUpload;

class UploadFile
{
    protected static $uploadPath;//上传目录路径
    protected static $uploadMaxSize;//上传最大大小,单位M

    /**
     * 上传配置
     * @param string $type 上传类型
     * @return array
     */
    public static function config($type = 'images')
    {
        self::$uploadPath = config('admin.upload_dir');
        $upload_path = self::$uploadPath;
        $max_size = config('admin.upload_max_size');;
        $max_size = 1024 * 1024 * $max_size;//50M默认，这里只是上传限制，还需要修改你的php.ini文件
        $config = [
            'fileType' => $type,
            'nameMd5' => 'md5',
            "maxSize" => $max_size, /* 上传大小限制，单位B */
            "compressEnable" => true, /* 是否压缩图片,默认是true */
            "urlPrefix" => "", /* 图片访问路径前缀 */
            "pathFormat" => $upload_path . "/images/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
        ];
        switch ($type) {
            case 'image':
                $config['allowFiles'] = [".png", ".jpg", ".jpeg", ".gif", ".bmp", ".ico"];
                break;
            case 'zip':
                $config['allowFiles'] = ['zip', ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2", ".tar.gz"];
                $config['pathFormat'] = $upload_path . "/zips/{yyyy}{mm}{dd}/{time}{rand:6}"; /* 上传保存路径,可以自定义保存路径和文件名格式 */
                break;
            case
            'file':
                $config['allowFiles'] = [
                    ".png", ".jpg", ".jpeg", ".gif", ".bmp",
                    ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg", ".wmv",
                    ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid",
                    ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2", ".cab", ".iso", ".tar.gz", ".tar",
                    ".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".pdf", ".txt", ".md", ".xml", ".psd", ".ai", ".cdr"
                ];
                $config['pathFormat'] = $upload_path . "/files/{yyyy}{mm}{dd}/{time}{rand:6}"; /* 上传保存路径,可以自定义保存路径和文件名格式 */
                break;
            case 'video':
                $config['allowFiles'] = [".mp4"];
                $config['pathFormat'] = $upload_path . "/video/{yyyy}{mm}{dd}/{time}{rand:6}"; /* 上传保存路径,可以自定义保存路径和文件名格式 */
                break;
            case 'office':
                $config['allowFiles'] = [
                    ".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".pdf", ".txt"
                ];
                $config['pathFormat'] = $upload_path . "/office/{yyyy}{mm}{dd}/{time}{rand:6}"; /* 上传保存路径,可以自定义保存路径和文件名格式 */
                break;
            default:
                $config['allowFiles'] = [".png", ".jpg", ".jpeg", ".gif", ".bmp"];
                break;
        }

        return $config;
    }


    public static function addFileDb($result, $model_id = '0', $model_type = 'admin')
    {

        $data = [
            'oss_type' => $result['oss_type'],
            'path' => $result['path'],
            'origin_path' => $result['origin_path'],//路径不加域名的
            'filename' => $result['filename'],
            'size' => $result['size'],
            'tmp_name' => $result['tmp_name'],
            'user_id' => $model_id,
            'user_type' => $model_type,
            'type' => $result['type'],
            'ext' => $result['ext'],
            'group_id' => $result['group_id'] ?: 0,

        ];
        return File::create($data);
    }

    /**
     * 加入系统文件系统，一般用于外部存储，例如阿里云，七牛，腾讯云
     * @param $aburl
     * @param $url
     * @return bool
     */
    public static function addOss($aburl, $url,$oss_type='oss')
    {
        $r = Storage::disk($oss_type)->put($url, file_get_contents($aburl));
        return $r;
    }

    public static function upload($form_file_name = "file", $config_type = 'image', $upload_method = 'image',
                                  $group_id = 0, $thumbs = [], $oss_type = "local", $create_id = '0', $create_type = 'admin')
    {
        if ($create_id == 0 && $config_type == 'admin') {
            $create_id = admin('id') ?: 0;
        }
        $config = self::config($config_type);
        //判断是否压缩图片,
        if (!empty($thumbs) && is_array($thumbs)) {
            $config['thumbs'] = $thumbs;
        }

        AnyUpload::config($form_file_name, $config, $upload_method);
        $result = AnyUpload::getFileInfo();
        $result['view_src'] = $result['path'];
        if ($result['type'] != 'image') {
            $img_pic = 'file.jpg';
            $img_pic = ___('/admin/images/' . $img_pic);

            if (in_array($result['ext'], ['.xlsx', '.xls'])) {
                $img_pic = 'excel.jpg';
                $img_pic = ___('/admin/images/' . $img_pic);
            }
            if (in_array($result['ext'], ['.doc', '.docx'])) {
                $img_pic = 'word.jpg';
                $img_pic = ___('/admin/images/' . $img_pic);
            }
            if (in_array($result['ext'], ['zip', ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2"])) {
                $img_pic = 'zip.jpg';
                $img_pic = ___('/admin/images/' . $img_pic);
            }
            if (in_array($result['ext'], ['zip', ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2"])) {
                $img_pic = 'zip.jpg';
                $img_pic = ___('/admin/images/' . $img_pic);
            }
            if (in_array($result['ext'], [
                ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg", ".wmv",
                ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid", ".cab", ".iso",
                ".ppt", ".pptx", ".pdf", ".txt", ".md", ".xml", ".psd", ".ai", ".cdr"
            ])) {
                $img_pic = 'file.jpg';
                $img_pic = ___('/admin/images/' . $img_pic);
            }
            //预览图片地址
            $result['view_src'] = ($img_pic);

        }

        $result['oss_type'] = $oss_type;
        //上传成功
        if ($result['is_upload'] == 1) {
            //如果是OSS
            if ($oss_type != 'local') {
                $result['oss_type'] = $oss_type;
                if (self::addOss($result['ab_path'], $result['origin_path'],$oss_type)) {
                    self::deleteLocalFile($result['ab_path'], 0);//删除自己路径
                    $result['oss_url'] = Storage::disk($oss_type)->url($result['origin_path']);
                    $result['oss_thumb_url'] = $result['oss_url'];
                    if ($result['type'] == 'image') {
                        $result['view_src'] = $result['oss_url'];
                    }
                    $result['path'] = $result['oss_url'];
                }

            }

            $result['group_id'] = $group_id;
            self::addFileDb($result, $create_id, $create_type);//入库
        }

        return $result;
    }

    /**
     * 删除本地图片
     * @param $filepath
     * @param int $del_db
     * @return bool
     */
    public static function deleteLocalFile($filepath, $del_db = 1)
    {
        if (is_array($filepath)) {
            foreach ($filepath as $v) {
                self::deleteLocalFile($v);
            }
        }
        $ofilename = $filepath;
        //附加前缀

        if (is_dir($filepath)) {
            return false;
        } elseif (file_exists($filepath)) {
            $r = unlink($filepath);
            if ($r) {
                if ($del_db) {
                    File::where('ab_path', $ofilename)->delete();
                }

                return true;

            }
            return false;
        }

    }

    /**
     * OSS图片删除
     * @param $filepath
     * @return bool
     */
    public static function deleteOssFile($filepath)
    {
        $filepath = is_array($filepath) ? $filepath : [$filepath];
        $r = Storage::delete($filepath);
        if ($r) {
            //从数据库里面删除
            File::whereIn('ab_path', $filepath)->delete();
            return true;
        }
        return false;
    }

    /**
     * 文件删除选择
     * @param string $url
     * @param int $is_oss
     * @return bool
     */
    public static function deleteFile($url = '')
    {
        $oss_type = env('FILESYSTEM_DRIVER', 'local');
        if ($oss_type != 'local') {
            return self::deleteOssFile($url);
        } else {
            return self::deleteLocalFile($url);
        }

    }


}