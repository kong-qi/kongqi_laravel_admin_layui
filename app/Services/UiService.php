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

namespace App\Services;

class UiService
{
    /**
     * 创建 layui table 的cols json
     * @param $data
     * @return array
     */
    public static function createLayuiTable($data)
    {

        $optiopns = [
            'field',
            'title',
            'width',
            'minWidth',
            'type',
            'LAY_CHECKED',
            'fixed',
            'hide',
            'totalRow',
            'totalRowText',
            'sort',
            'unresize',//是否禁用拖拽列宽
            'edit',//单元格编辑类型
            "event",//自定义单元格点击事件名
            "style",//自定义单元格样式
            "align",//单元格排列方式
            "colspan",//单元格所占列数
            "rowspan",//单元格所占行数
            "templet",//自定义列模板
            "toolbar"//绑定工具条模板
        ];
        $cols = [];
        foreach ($data as $k => $v) {

            foreach ($v as $item_k => $item) {
                if (in_array($item_k, $optiopns)) {
                    if (isset($item_k) && $item_k != '') {
                        $cols[$k][$item_k] = lang($item);
                    }
                }
            }

        }
        return $cols;
    }

    //编辑和删除，其他按钮

    /**
     * php 生成列表 switch 切换
     * @param $item
     * @param $field
     * @param string $id
     * @param string $text
     * @param int $true_value
     * @param int $false_value
     * @return string
     */
    public static function switchTpl( $field,$item, $id = 0, $text = "启用|禁用", $true_value = 1, $false_value = 0,$is_reload=0)
    {

        $value = $item[$field];
        if (!$id) {
            $id = $item['id'];
        }
        //$text=lang($text);
        $html = '<input type="checkbox" data-is_reload="'.$is_reload.'" data-true="' . $true_value . '" data-false_value="' . $false_value . '"  
        lay-skin="switch" lay-text="' . $text . '" lay-filter="table-checked"
                value="' . $value . '" data-id="' . $id . '"  
                data-field="' . $field . '"  ' . ($value == $true_value ? 'checked' : '') . '>';



        return $html;
    }

    public static function linkTpl($name,$url,$is_target=1){
        $target = $is_target ? 'target="_blank"' : '';
        return '<a class="event-link" href="' . $url . '" ' . $target . '>' . $name . '</a> ';
    }
    public static function linkEventTpl($name,$event){

        return '<a class="event-link" lay-event="'.$event.'" href="javascript:void(0)">' . lang($name) . '</a> ';

    }
    public static function editDelTpl($hasEdit=1,$hasDel=1){

        $html=[];
        if($hasEdit){
            $html[]=self::linkEventTpl('编辑','edit');
        }
        if($hasDel){
            $html[]=self::linkEventTpl('删除','del');
        }
        return self::layuiTplArrOutput($html);

    }
    /**
     * 打开iframe
     * @param $name 名称
     * @param $url 地址
     * @param string $tip_title 提示符
     * @param string $w 宽度
     * @param string $h 高度
     * @param integer $parentLayui 是否父级弹出
     * @return string
     */
    public static function layuiTplShowIframe($name, $url, $tipTitle = '', $w = '100%', $h = '100%',$parentLayui=0)
    {
        return '<a class="event-link" title="'.$tipTitle.'" data-title="'.$tipTitle.'" data-parent="'.$parentLayui.'" data-w="' . $w . '" data-h="' . $h . '" 
         title="' . ($tipTitle ?: $name) . '"
         href="javascript:void(0)" data-url="' . $url . '" lay-event="show">' . $name . '</a> ';
    }
    /**
     * 打开iframe 并提交POST
     * @param $name
     * @param $url
     * @param $postUrl
     * @param string $tipTitle
     * @param string $w
     * @param string $h
     * @return string
     */
    public static function layuiTplIframeUrlAndPost($name, $url, $postUrl, $tipTitle = '', $w = '100%', $h = '100%',$parentLayui=0)
    {
        return '<a class="event-link" data-w="' . $w . '" data-h="' . $h . '"  data-title="' . ($tipTitle ?: $name) . '"
         href="javascript:void(0)" data-url="' . $url . '" lay-event="openPost" data-post_url="' . $postUrl . '" data-parent="'.$parentLayui.'" >' . $name . '</a> ';
    }

    public static function layuiTplImg($src,$w='100px',$parentLayui=0){
        return '<img src="'.$src.'" data-src="'.$src.'"  ui-event="viewImg" class="rounded img-fluid" style="width:'.$w.' " data-parent="'.$parentLayui.'">';
    }

    /**
     * 打开一个提交地址
     * @param $name
     * @param $url
     * @param string $tipTitle
     * @param string $w
     * @param string $h
     * @param integer $parentLayui 是否父级弹出
     * @return string
     */
    public static function layuiTplUrlPost($name, $url, $tipTitle = '', $w = '500px', $h = '300px',$parentLayui=0)
    {
        return '<a class="event-link" data-w="' . $w . '" data-h="' . $h . '"  data-title="' . ($tipTitle ?: $name) . '"
         href="javascript:void(0)" lay-event="post" data-url="' . $url . '" data-parent="'.$parentLayui.'">' . $name . '</a> ';
    }

    /**
     * 状态
     * @param $name 名称
     * @param $type 类型值
     * @param $typeClass 状态对应class
     * @return string
     */
    public static function layuiTplStatus($name,$type,$typeClass=['text-danger']){
        return "<span class='".($typeClass[$type]??"")."'></span> ".$name;
    }

    /**
     * 分割
     * @param $arr
     * @return string
     */
    public static function layuiTplArrOutput($arr){
        $html='';
        foreach ($arr as $k=>$v){
            $html.=$v;
            if((count($arr)-1)!=$k){
                $html.='<span class="split"></span>';
            }
        }
        return $html;
    }

    /**
     * tab内嵌打开
     * @param $name
     * @param $url
     * @param string $tips
     * @return string
     */
    public static function linkTabTpl($name,$url,$tips=''){

        return '<a class="event-link" lay-href="' . $url . '" lay-text="'.($tips?:$name).'" >' . $name . '</a> ';
    }

    /**
     * 列表操作：编辑，复制，删除按钮
     * @param int $hasEdit
     * @param int $hasDel
     * @return string
     */
    public static function editDelCopyTpl($hasEdit=1,$hasDel=1){

        $html=[];
        if($hasEdit){
            $html[]=self::linkEventTpl('编辑','edit');
        }
        if($hasEdit){
            $html[]=self::linkEventTpl('复制','copy');
        }
        if($hasDel){
            $html[]=self::linkEventTpl('删除','del');
        }
        return self::layuiTplArrOutput($html);

    }
}