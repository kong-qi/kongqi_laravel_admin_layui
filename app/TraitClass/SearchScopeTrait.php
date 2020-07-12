<?php

namespace App\TraitClass;

use App\Services\SearchServices;
use Illuminate\Support\Facades\Schema;

trait SearchScopeTrait
{
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    /**
     * sort desc 排序
     * @param $query
     * @return mixed
     */
    public function scopeSortDesc($query)
    {
        return $query->orderBy('sort', 'desc');
    }

    /**
     * sort asc排序
     * @param $query
     * @return mixed
     */
    public function scopeSortAsc($query)
    {
        return $query->orderBy('sort', 'asc');
    }

    /**
     * id desc 排序
     * @param $query
     * @return mixed
     */
    public function scopeIdDesc($query)
    {
        return $query->orderBy('id', 'desc');
    }

    /**
     * id asc 排序
     * @param $query
     * @return mixed
     */
    public function scopeIdAsc($query)
    {
        return $query->orderBy('id', 'asc');
    }

    /**
     * is_checked ='1' 查询条件
     * @param $query
     * @return mixed
     */
    public function scopeChecked($query)
    {
        return $query->where('is_checked', 1);
    }

    /**
     * 检查is_checked 值是否为空，存在则增加条件，不存在则不检查
     * @param $query
     * @param $value
     * @return mixed
     */
    public function scopeCheckValue($query, $value)
    {
        if ($value === '') {
            return $query;
        }
        return $query->where('is_checked', $value);
    }

    /**
     * 查询是否需要查询软删除数据
     * @param $query
     * @param $value 1表示查询，其他表示不查询
     * @return mixed
     */
    public function scopeWithDelIf($query, $value)
    {
        if ($value == 1) {
            return $query->withTrashed();
        }
        return $query;
    }

    /**
     * 状态status=1条件
     * @param $query
     * @return mixed
     */
    public function scopeStatus($query)
    {
        return $query->where('status', 1);
    }

    /**
     * 范围搜索查询设置
     * @param $query 查询句柄query
     * @param array $data 需要的查询的参数数组
     * @return bool
     */
    public function scopeSearch($query, array $data, $query_prefix = '')
    {
        if (empty($data)) {
            return $query;
        }
        foreach ($data as $k => $v) {
            if ($v['value'] === '') {
                return $query;
            }
            //增加前缀，链表时候用
            $k = $query_prefix . $k;
            switch ($v['type']) {
                case '>':
                case '>=':
                case '<>':
                case '!=':
                case '<':
                case '<=':
                case '=':
                    $query->where($k, $v['type'], $v['value']);
                    break;
                case 'in':
                    $query->whereIn($k, $v['value']);
                    break;
                case 'between':
                    if (is_array($v['value'])) {
                        $query->whereBetween($k, $v['value']);
                    }
                    break;
                case 'raw':
                    if (is_array($v['value']) && count($v['value']) == 2) {
                        $query->whereRaw($v['value'][0], [$v['value'][1]]);
                    }
                    break;
                case 'like':
                    $query->whereRaw($k . ' like ?', ["%" . $v['value'] . "%"]);
                    break;
                case 'right_like':
                    $query->whereRaw($k . ' like ?', [$v['value'] . "%"]);
                    break;
                case 'left_like':
                    $query->whereRaw($k . ' like ?', ["%" . $v['value']]);
                    break;
                case 'like_sql':
                    $query->whereRaw($v['value']);
                    break;

            }
        }
        return $query;
    }

    /**
     * 搜索模型实列化
     * @param $model 对象类型，传递模型
     * @param $data 数组类型，查询数据，
     * @param string $type 类型
     * @return mixed 返回对象模型
     */
    public static function getSearchModel($model, $data, $type = '')
    {

        $search = new SearchServices($model, $data, $type);
        $search->unsetAllWhere();
        return $search->returnModel();
    }

    /**
     * 取得这个模型的字段
     * @return mixed
     */
    public function getModelField()
    {
        $table = $this->getTable();
        $data = Schema::getColumnListing($table);
        return $data;

    }

    /**
     * 数组查询条件
     * @param $query
     * @param $where 如果是字符则字符串查询，如果是数组则数组查询
     * @param $field
     * @return bool
     */
    public function scopeWhereArrOrString($query, $where, $field)
    {
        if ($where == '') {
            return $query;
        }
        if (is_array($where)) {
            return $query->whereIn($field, $where);
        }
        if (is_string($where)) {
            return $query->where($field, $where);
        }
    }
    public function scopeWhereIf($query,$field, $where)
    {

        if ($where == '') {
            return $query;
        }
        if (is_array($where)) {
            return $query->whereIn($field, $where);
        }
        if (is_string($where)) {
            return $query->where($field, $where);
        }
    }

    /**
     * 多个模糊搜索like模糊搜索
     * @param $query
     * @param $where 查询条件，必须是数组
     * @param string $prefix
     * @return bool
     */
    public function scopeWhereLike($query, $where, $prefix = 'or')
    {
        if (empty($where) || is_string($where)) {
            return $query;
        }
        $where_arr = [];
        $sql = '';
        foreach ($where as $k => $v) {
            if(empty($v)){
                continue;
            }
            $sql = " $k like ? " . $prefix;
            $where_arr[] = '%' . $v . '%';
        }
        $sql = substr($sql, 0, -3);
        if (!empty($where_arr)) {
            return $query->whereRaw($sql, $where_arr);
        }
        return $query;

    }

}
