<?php

namespace App\Services;

class Layui implements Ui
{
    public $show;



    /**
     * 创建按钮
     * @param $data
     */
    public function createBtn($data)
    {

        foreach ($data as $k => &$v) {
            $v['class'] = $v['class'] ?? 'btn-primary';
            $v['id'] = $v['id'] ?? '';
            $v['data'] = $v['data'] ?? [];
            $v['name']=lang($v['name']);
            if(!empty($v['data'])){
                $html=[];
                foreach ($v['data'] as $k2=>$v2){
                    $html[]=$k2.'='.$v2.' ';
                }
                $v['data']=$html;
            }


        }
        //dd($data);
        return $data;
    }


    /**
     * 批量生成模板数据
     * @param $data
     * @param string $show
     * @return string
     */
    public function createFormInput($data, $show = '')
    {

        $this->show = $show;

        $group_data = [];
        $is_group = 0;

        foreach ($data as $k => $item) {
            //判断是否存在组分类，如果是的话，需要切割哦
            if (isset($item['group_name'])) {
                $is_group = 1;
                if (!empty($item['data'])) {
                    $group_data[$k]['name'] = $item['group_name'];
                    foreach ($item['data'] as $k2 => $v) {
                        //如果是自定义html
                        $group_data[$k]['data'][] = $this->createFormInputItem($v);

                    }
                }

            } else {

                $group_data[] = $this->createFormInputItem($item);

            }

        }

        return ['is_group' => $is_group, 'data' => $group_data];
    }

    /**
     * 生成模板数据项目
     * @param $data
     * @param string $show
     * @return string
     */
    public function createFormInputItem($v)
    {
        $v['name'] = lang($v['name']);
        $v['id'] = $v['id'] ?? $v['field'];

        /*if (isset($v['remove']) && $v['remove'] == 1) {
            return false;
        }*/

        //如果单独设置了，则传递单的
        if ($this->show) {
            if(!isset($v['value'])){
                $v['value'] =  ($this->show[$v['field']] ?? '');
            }
        } else {
            $v['value'] = $v['value'] ?? ($v['default'] ?? '');
        }
        //placeholder提示
        $v['tips'] = $v['tips'] ?? '';
        //附加class
        $v['addClass'] = $v['addClass'] ?? '';

        //附加属性
        $v['attr'] = $v['attr'] ?? '';

        $v['tips'] = $v['tips'] ? lang($v['tips']) : $v['name'];

        switch ($v['type']) {

            case 'date':
            case 'datetime':
                $v['event']=$v['type'];
                $v['type'] = 'text';
                $v['attr'] = $v['attr'] ?? '';
                $v['attr'] = $v['attr'] . ' data-lang="' . env('lang') . '" ';
                break;
            case 'img':
            case 'imgMore':
                //上传路径接口
                $v['upload_url'] = $v['upload_url'] ?? '';//单独设置上传接口地址
                $v['file_type'] = $v['file_type'] ?? '';//上传文件类型
                $v['oss_type'] = $v['oss_type'] ?? 'local';//上传文件类型
                $v['accept_type'] = $v['accept_type'] ?? '';//前端接受的文件上传类型，默认是images
                $v['group_id'] = $v['group_id'] ?? '';//分组ID
                $v['place_url'] = $v['place_url'] ?? '';//单独设置文件空间地址
                $v['value_name'] = $v['value_name'] ?? 'path';

                $up_attr = 'data-value_name=' . $v['value_name'];
                if ($v['upload_url']) {
                    $up_attr .= ' data-upload_url=' . $v['upload_url'] . ' ';
                }
                if ($v['file_type']) {
                    $up_attr .= ' data-file_type=' . $v['file_type'] . ' ';
                }
                if ($v['accept_type']) {
                    $up_attr .= ' data-accept_type=' . $v['accept_type'] . ' ';
                }
                if ($v['oss_type']) {
                    $up_attr .= ' data-oss_type=' . $v['oss_type'] . ' ';
                }

                $place_attr = 'data-value_name=' . $v['value_name'];
                if ($v['place_url']) {
                    $place_attr .= ' data-place_url=' . $v['place_url'] . ' ';
                }
                if ($v['file_type']) {
                    $place_attr .= ' data-file_type=' . $v['file_type'] . ' ';
                }
                if ($v['group_id']) {
                    $place_attr .= ' data-group_id=' . $v['group_id'] . ' ';
                }
                if ($v['oss_type']) {
                    $place_attr .= ' data-oss_type=' . $v['oss_type'] . ' ';
                }
                $v['place_attr'] = $place_attr;
                $v['up_attr'] =  $up_attr;
                $v['addClass'] = $v['addClass'] . ' upload-area-input';

                if ($this->show && $v['type']=='imgMore') {
                    $v['value'] = $this->show[$v['field']] ?? '';
                    $v['data'] = $v['value'] ? json_decode($v['value'], 1) : [];
                }
                break;

        }

        return $v;
    }


    /**
     * 搜索生成
     * @param $data
     * @return string
     */
    public function createFormSearchInput($data)
    {
        foreach ($data as $k => &$v) {
            if (isset($v['remove']) && $v['remove'] == 1) {
                continue;
            }

            $v['default'] = $v['default'] ?? '';
            $v['value'] = $v['value'] ?? $v['default'];
            $v['addClass']= $v['addClass']??'';
            $v=$this->createFormInputItem($v);

        }
        return $data;
    }



    /**
     * 是否数组
     * @return array
     */
    public function trueFalseData($addAll = 0)
    {

        $data = [];
        if ($addAll) {
            $data[] = [
                'id' => '',
                'name' => '全部'
            ];
        }
        $data[] = [
            'id' => '1',
            'name' => '是'
        ];
        $data[] = [
            'id' => '0',
            'name' => '否'
        ];
        return $data;
    }

    public function allDataArr($name = '全部', $id = '')
    {
        $data[] = [
            'id' => $id,
            'name' => $name
        ];
        return $data;
    }

    /**
     * 合并成 id和name键值对
     * @param int $addAll
     * @param $modelData
     * @param string $allName
     * @param int $allId
     * @param array $fields
     * @return array
     */
    public function mergeModelData($addAll = 1, $modelData, $allName = '根级', $allId = 0, $fields = [])
    {
        $data = [

        ];
        if ($addAll) {
            $data[] = [
                'id' => $allId,
                'name' => $allName
            ];
        }

        if (empty($fields)) {
            $model_data = key_value_arr_to_select($modelData);
        } else {
            $model_data = array_to_key($modelData, 'id', $fields);
        }

        return array_merge($data, $model_data);

    }

    /**
     * 树形数据用于 select
     * @param $data
     * @param int $depth
     * @param string $id
     * @param string $name
     * @return array
     */
    public function treeData($data, $parentId = 0, $depth = 4, $id = 'id', $name = 'name')
    {

        $data = get_tree_option($data, $parentId);
        $ndata = [];
        foreach ($data as $k => $v) {
            $ndata[] = [
                'id' => $v[$id],
                'name' => str_repeat("-", $v['depth'] * $depth) . $v[$name]
            ];
        }


        return $ndata;
    }


}