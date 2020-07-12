<?php

namespace App\TraitClass;

use Illuminate\Http\Request;

trait GetListTrait
{

    public $rq;
    public $isGetListData;

    /**
     * 列表数据
     * limit 分页数
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse|string
     */
    public function getList(Request $request)
    {
        $this->rq = $request;
        $page = $request->input('page', 1);
        $pagesize = $request->input('limit', 30);

        $order_by_name = $this->orderByName();
        $order_by_type = $this->orderByType();
        $debug = $request->input('debug', 0);
        //如果开始没有数据，直接返回空的
        if (!method_exists($this, 'getModel')) {
            return $this->returnApi(200, '没有初始化模型2', []);
        }

        if (!$this->getModel()) {
            return $this->returnApi(200, '没有初始化模型', []);
        }

        $model = $this->getSearchModel($this->setSearchParam($request->all()));
        $model = $this->addListSearchWhere($model);
        $total = $model->count();
        //是否是否关联数据等操作
        $model = $this->setModelRelaction($model);
        $model = $this->orderBy($model, $order_by_name, $order_by_type);
        $result = $model->forPage($page, $pagesize)->get();

        //显示内容设置
        $arr_data = $this->listOutputData($result);
        return $this->listOutputJson($total, $arr_data, $debug);
    }

    public function listOutputJson($total, $data, $debug = "0")
    {
        $json = [
            'code' => 200,
            'msg' => $total > 0 ? '请求数据成功' : '暂无数据',
            'count' => $total,
            'data' => $data,
            'other' => $this->listOutputOtherData($total, $data)
        ];
        if ($debug) {
            return dd($data);
        }
        if ($this->isGetListData) {
            return $json;
        }
        return $this->returnApiData($json);
    }

    /**
     * 数据列表其他数据输出，可用于统计内容输出附加
     * @param int $total
     * @param array $data
     */
    public function listOutputOtherData($total = 0, $data = [])
    {

    }

    /**
     * 列表输出格式
     * @param $result
     * @return array
     */
    public function listOutputData($result)
    {
        $data = [];
        foreach ($result as $k => $v) {
            //列表输出格式单项目设置
            $v = $this->setListOutputItem($v);
            $data[] = $v;
        }
        return $data;
    }

    /**
     * 列表输出格式单项目设置
     * @param $item
     * @return mixed
     */
    public function setListOutputItem($item)
    {
        $item = $this->editUrlShow($item);
        $item = $this->setListOutputItemExtend($item);

        return $item;
    }

    //编辑的地址赋值
    public function editUrlShow($item)
    {
        $item['edit_url'] = '';
        $item['edit_post_url'] = '';
        return $item;

    }

    /**
     * 列表输出格式单项目附加设置
     * @param $item
     * @return mixed
     */
    public function setListOutputItemExtend($item)
    {
        return $item;
    }


    /**
     * 排序字段名字
     * @return mixed
     */
    public function orderByName()
    {
        return $this->rq->input('sort', 'id');
    }

    /**
     * 排序类型
     * @return mixed
     */
    public function orderByType()
    {
        return $this->rq->input('order', 'desc') ?: 'desc';
    }

    /**
     * 设置排序方法
     * @param $model
     * @param $order_id
     * @param $order_type
     * @return mixed
     */
    public function orderBy($model, $order_by_name, $order_by_type)
    {

        if ($order_by_name == 'id') {
            return $model->orderBy($order_by_name, $order_by_type);
        } else {
            return $model->orderBy($order_by_name, $order_by_type)->orderBy('id', 'desc');
        }

    }

    /**
     * 设置搜索模型的POST数据
     * 比如需要手动追加这里附加
     * @param $data
     * @return mixed
     */
    public function setSearchParam($data)
    {

        return $data;
    }

    /**
     * 设置搜索条件参数
     * @param $data
     * @return mixed
     */
    public function getSearchModel($data, $type = '')
    {
        $model = $this->getModel()->getSearchModel($this->getModel(), $data, $type);
        return $model;
    }


    /**
     * 设置相关增加搜索条件或者其他的操作
     * @param $model
     * @return mixed
     */
    public function setModelRelaction($model)
    {
        return $model;
    }


}