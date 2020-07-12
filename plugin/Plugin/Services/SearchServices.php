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
namespace Plugin\Plugin\Services;

use Illuminate\Support\Facades\DB;

/**
 * 设置搜索条件的类，使用流程
 * $search = new SearchServices($model, $data, $type);//$model =new User();$data=['user_id'=>22]
 * $search->returnModel();
 * Class SearchServices
 * @package App\Services
 */
class SearchServices
{
    public static $where = [];//组合后的查询条件数组
    public $model;//查询的模型
    public $wherePrefix = 'whereBy';//查询前缀符号
    public $param = [];//查询条件原始数据数组
    protected $queryPrefix = '';//查询前缀，一般用于连表需要用到，指定那个表的查询条件
    use PluginQueryWhereTrait;


    /**
     * SearchServices constructor.
     * @param $model 模型
     * @param array $param 参数
     * @param string $query_prefix 查询前缀，链表的时候会用到
     */
    public function __construct($model, $param = [], $query_prefix = "")
    {
        $this->model = $model;
        $this->param = $param;//查询条件
        $this->queryPrefix = $query_prefix;

    }


    /**
     * 将原始传递过来的查询数组转换成各个方法搜索条件方法
     * @param array $where
     * @return bool
     */
    public function setWhere(array $where)
    {

        foreach ($where as $k => $v) {
            if ($v === NULL && $v != 0) {
                return false;
            }
            //转换方法字符串方法名字
            $str = convert_under_line($k);
            $action = $this->wherePrefix . $str;

            if (method_exists($this, $action)) {
                if ($v !== '' && $v !== NULL) {
                    //执行方法
                    $this->$action($v);
                }
            }
        }
    }


    /**
     * 执行渲染输出
     */
    public function render()
    {
        //清空查询键值对
        $this->unsetAllWhere();
        //设置搜索条件

        $this->setWhere($this->param);
        //执行搜索范围赋值
        $this->querySearch();
    }

    /**
     * 完全移除搜索条件
     *
     */
    public function unsetAllWhere()
    {
        self::$where = [];
    }

    /**
     * 设置查询条件后返回模型
     * @return mixed
     */
    public function returnModel()
    {
        $this->render();
        return $this->model;
    }

    /**
     * 返回模型的统计总量count()方法
     * @param string $field
     * @return mixed
     */
    public function totalNumber($field = 'id')
    {
        $this->render();
        return $this->model->count($field);
    }

    /**
     * 返回模型的累积相加总量sum()
     * @param string $field
     * @return mixed
     */
    public function totalSum($field = 'id')
    {
        $this->render();
        return $this->model->sum($field);
    }


    /**
     * 给model类型执行搜索范围
     * @return mixed
     */
    public function querySearch()
    {
        if (empty(self::$where)) {
            return $this->model;
        }

        //这里去使用模型里面的search搜索访问方法
        //scopeSearch
        //app/TraitClass/SearchScopeTrait.php
        return $this->model = $this->model->search(self::$where, $this->queryPrefix);
    }

    /**
     * 查询语句加入到搜索静态数组里面
     * @param $where
     * @return array
     */
    public function addWhere($where)
    {
        return self::$where = self::$where + $where;
    }


    /**
     * 取得查询语句
     * @return array
     */
    public function getWhere()
    {
        return self::$where;
    }

    /**
     * 查询多个组合的和值，比如sum(number),sum(price)
     * @param $data
     * @param $filed_arr 比如：['number','price']
     * @return array
     */
    public function getSumArr($filed_arr)
    {

        $this->unsetAllWhere();
        $this->render();
        $model = $this->model;
        $raw_arr = [];
        foreach ($filed_arr as $k => $v) {
            $raw_arr[] = DB::raw('SUM(' . $v . ') as ' . $v);
        }
        $sum_arr = $model->first($raw_arr);
        if (empty($sum_arr)) {
            return [];
        }
        $sum_arr = $sum_arr->toArray();
        return ($sum_arr);
    }

    /**
     * 查询多个组合的数量，比如count(number),count(price)
     * @param $data
     * @param $filed_arr 比如：['number','price']
     * @return array
     */
    public function getCountArr($filed_arr)
    {

        $this->unsetAllWhere();
        $this->render();
        $model = $this->model;
        $raw_arr = [];
        foreach ($filed_arr as $k => $v) {
            $raw_arr[] = DB::raw('COUNT(' . $v . ') as ' . $v);
        }
        $sum_arr = $model->first($raw_arr);
        if (empty($sum_arr)) {
            return [];
        }
        $sum_arr = $sum_arr->toArray();
        return ($sum_arr);
    }


}
