<?php
/**
 * 字符串转换驼峰峰式，默认第一个字符串大写
 * @param $str
 * @param bool $ucfirst
 * @return string
 */
function convert_under_line($str, $ucfirst = true)
{
    while (($pos = strpos($str, '_')) !== false)
        $str = substr($str, 0, $pos) . ucfirst(substr($str, $pos + 1));

    return $ucfirst ? ucfirst($str) : $str;
}

/**
 * 格式化日期
 * @param $str
 * @param string $format
 * @return false|string
 */
function format_date($str, $format = "Y-m-d")
{
    $datetime = strtotime($str);
    return date($format, $datetime);
}

/**
 * 转换成linux路径
 * @param $path
 * @return mixed
 */
function linux_path($path)
{
    return str_replace("\\", "/", $path);
}

/**
 * 管理员信息
 * @param string $field
 * @return mixed
 */
function admin($field = '')
{
    if (\Illuminate\Support\Facades\Auth::guard('admin')->check()) {
        $info = \Illuminate\Support\Facades\Auth::guard('admin')->user();
        return $field ? $info[$field] : $info;
    }
    return false;

}

/**
 * 根据控制器获取url地址
 * @param $path
 * @param $method
 * @param $option
 */
function admin_url($path, $method = 'index', $option = [])
{
    $controller = 'Admin\\' . ucwords($path) . 'Controller@' . lcfirst(ucwords($method));
    try {
        $url = action($controller, $option);
    } catch (Exception $e) {

        return $controller . lang("这个控制器没有定义") . '<br/>';
    }
    return $url;
}

/**
 * 资源加载__
 * @param $path
 * @return string
 */
function ___($path, $version = '')
{
    if ($version) {
        $version = '?v=' . $version;
    }
    return asset('/static/' . $path) . $version;
}

/**
 * 插件资源路径
 * @param $path
 * @param string $version
 * @return string
 */
function plugin_res($path, $version = '')
{
    if ($version) {
        $version = '?v=' . $version;
    }
    return asset('/static/plugin/' . $path) . $version;
}



/**
 * 配置缓存，永久，不更新则永久
 * @param $config_key 配置名称
 * @param array $data 数据
 * @return \Illuminate\Cache\CacheManager|mixed|string
 * @throws Exception
 */
function config_cache($config_key, $data = [])
{

    try {
        $param = explode('.', $config_key);


        if (empty($param)) {
            return false;
        }

        if (empty($data)) {
            $config = cache($param[0]);

            //是否存在这个缓存
            if (!empty($config)) {
                $config = ($config);
            } else {
                //缓存文件不存在就读取数据库
                $res = \App\Models\Config::where('group_type', $param[0])->get()->toArray();

                $config = [];
                if ($res) {
                    foreach ($res as $k => $val) {
                        $config[$val['ename']] = $val['content'];
                    }
                    //存入缓存
                    \Illuminate\Support\Facades\Cache::forever($param[0], ($config));
                }
            }

            if (count($param) > 0) {

                //判断获取值参数是否存在，如果存在的话，则去，没有存在返回数组
                if (isset($param[1])) {
                    $config = is_array($config) ? $config : [];
                    if (array_key_exists($param[1], $config)) {
                        return $config[$param[1]];
                    }
                } else {
                    return $config = is_array($config) ? $config : false;
                }
            } else {
                return $config;
            }
        } else {
            //添加/更新
            $newArr = [];
            $newData = [];
            $result = \App\Models\Config::where('group_type', $param[0])->get()->toArray();
           // dump($result);
            //dump($data);

            if (count($result) > 0) {

                foreach ($result as $val) {
                    $temp[$val['ename']] = $val['content'];
                }
                foreach ($data as $k => $v) {
                    $newArr = ['ename' => $k, 'content' => trim($v), 'group_type' => $param[0]];

                    if (!isset($temp[$k])) {

                        $r=\App\Models\Config::create($newArr);//新key数据插入数据库


                    } else {
                        if ($v != $temp[$k]) {
                            \App\Models\Config::where("ename", $k)->where('group_type',$param[0])->update($newArr);//缓存key存在且值有变更新此项
                        }

                    }
                }

                //更新后的新的记录
                $newRes = \App\Models\Config::where('group_type', $param[0])->get()->toArray();

                foreach ($newRes as $rs) {
                    $newData[$rs['ename']] = $rs['content'];
                }
            } else {

                foreach ($data as $k => $v) {
                    $newArr[] = ['ename' => $k, 'content' => trim($v), 'group_type' => $param[0]];
                }

                \App\Models\Config::insert($newArr);
                $newData = $data;
            }
            $newData = ($newData);
            \Illuminate\Support\Facades\Cache::forever($param[0], $newData);
        }
    } catch (Exception $exception) {
        return false;
    }

}

/**
 * 取得配置，可以设置默认值
 * @param $config_key 配置KEY
 * @param string $defualt 默认值
 * @param string $group_type 类型
 * @return \Illuminate\Cache\CacheManager|int|mixed|string
 * @throws Exception
 */
function config_cache_default($config_key, $defualt = '')
{
    $data = config_cache($config_key);
    if ($data == '') {
        return $defualt ? $defualt : 0;
    }
    return $data;
}

/**
 * 将上下级转换成树形
 * @param array $list
 * @param string $pk
 * @param string $pid
 * @param string $child
 * @param int $root
 * @return array
 */
function tree($list = [], $pk = 'id', $pid = 'parent_id', $child = '_child', $root = 0)
{

    // 创建Tree
    $tree = [];
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = [];
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        //转出ID对内容
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];

            } else {

                if (isset($refer[$parentId])) {

                    $parent =& $refer[$parentId];

                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 数组转成某个键值作为索引
 * @param $data
 * @param string $key
 * @return array
 */
function array_to_key($data, $key = 'id', $fields = [])
{
    if (empty($data)) {
        return [];
    }
    $arr = [];
    if (!empty($fields)) {
        foreach ($data as $k => $v) {
            foreach ($fields as $v2){
                $arr[$v[$key]][$v2]=$v[$v2];
            }
        }
    } else {
        foreach ($data as $k => $v) {
            $arr[$v[$key]] = $v;
        }
    }
    return $arr;
}

/**
 * 1维数组键值对转化成select 类型输出
 * @param $arr
 * @return array
 */
function key_value_arr_to_select($arr)
{
    if (empty($arr)) {
        return [];
    }
    $data = [];
    foreach ($arr as $k => $v) {
        $data[] = [
            'id' => $k,
            'name' => $v
        ];
    }
    return $data;
}


/**
 * 取得路径
 * @param $path 路径
 * @param int $abs_path 是否绝对路径
 * @param string $type 类型取得路径还是文件，默认是目录
 * @return array|bool
 */
function get_dir($path, $abs_path = 0, $type = 'dir')
{
    $path_file = scandir($path);
    if (empty($path_file)) {
        return false;
    }
    $path_arr = [];
    $file_arr = [];

    foreach ($path_file as $k => $v) {
        if (in_array($v, ['.', '..'])) {
            continue;
        }

        if (is_dir($path . $v)) {
            $path_arr[] = $abs_path ? $path . $v : $v;
        } elseif (is_file($path . $v)) {
            $file_arr[] = $abs_path ? $path . $v : $v;
        }
    }

    if ($type == 'dir') {
        return $path_arr;
    } else {
        return $file_arr;
    }
}

/**
 * 路由地址，替换原来的路由方法
 * @param $name
 * @param array $para
 * @return string
 */
function nroute($name, $para = [])
{
    try {
        return route($name, $para);
    } catch (Exception $exception) {
        return $exception->getMessage();
    }
}
/**
 * 路由地址，替换原来的路由方法
 * @param $name
 * @param array $para
 * @return string
 */
function proute($name, $para = [])
{
    try {
        return route('plugin.'.$name, $para);
    } catch (Exception $exception) {
        return $exception->getMessage();
    }
}

/**
 * 判断是否手机端
 * @return bool
 */
function is_mobile_client()
{
// 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return true;
    }
    // 判断手机发送的客户端标志,兼容性有待提高,把常见的类型放到前面
    if (isset ($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = [
            'android',
            'iphone',
            'samsung',
            'ucweb',
            'wap',
            'mobile',
            'nokia',
            'sony',
            'ericsson',
            'mot',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'ipod',
            'blackberry',
            'meizu',
            'netfront',
            'symbian',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp'
        ];
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}

/**
 * 有深度的树形，一般用于select
 * @param $data 数据数组
 * @param $parent_id 父ID
 * @return array
 */
function get_tree_option($data, $parent_id)
{
    $stack = [$parent_id];
    $child = [];
    $added = [];
    $options = [];
    $obj = [];
    $loop = 0;
    $depth = -1;
    foreach ($data as $node) {
        $pid = $node['parent_id'];
        if (!isset($child[$pid])) {
            $child[$pid] = [];
        }
        array_push($child[$pid], $node['id']);
        $obj[$node['id']] = $node;
    }

    while (count($stack) > 0) {
        $id = $stack[0];
        $flag = false;
        $node = isset($obj[$id]) ? $obj[$id] : null;
        if (isset($child[$id])) {
            for ($i = count($child[$id]) - 1; $i >= 0; $i--) {
                array_unshift($stack, $child[$id][$i]);
            }
            $flag = true;
        }
        if ($id != $parent_id && $node && !isset($added[$id])) {
            $node['depth'] = $depth;
            $options[] = $node;
            $added[$id] = true;
        }
        if ($flag == true) {
            $depth++;
        } else {
            if ($node) {
                for ($i = count($child[$node['parent_id']]) - 1; $i >= 0; $i--) {
                    if ($child[$node['parent_id']][$i] == $id) {
                        array_splice($child[$node['parent_id']], $i, 1);
                        break;
                    }
                }
                if (count($child[$node['parent_id']]) == 0) {
                    $child[$node['parent_id']] = null;
                    $depth--;
                }
            }
            array_shift($stack);
        }
        $loop++;
        if ($loop > 5000) return $options;
    }
    unset($child);
    unset($obj);
    return $options;
}

/**
 * 判断是否https
 * @return bool
 */
function is_https()
{
    if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
        return true;
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
        return true;
    } elseif (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
        return true;
    }
    return false;
}

/**
 * 输出地址
 * @param $path
 * @param int $is_https 是否强制https
 * @return bool|\Illuminate\Contracts\Routing\UrlGenerator|string
 */
function to_url($path, $is_https = 0)
{
    //判断是否HTTPS
    if (is_https()) {
        $is_https = 1;
    }
    if (empty($path)) {
        return false;
    }
    //替换地址
    if ($is_https) {
        $path = str_replace('http://', 'https://', $path);
        $path = url($path, [], $is_https);
    }
    return $path;
}

/**
 * 取得资源url
 * @param $path
 * @return bool|\Illuminate\Contracts\Routing\UrlGenerator|string
 */
function res_url($path)
{
    //是否配置设置了资源单独域名或补齐域名
    $res_url = env('RES_HTTP_URL', '');
    //判断是否开启了补齐域名，去.env获取，默认补齐

    if ($res_url) {
        if (is_https()) {
            $path = str_replace('http://', 'https://', $path);
        }

        $path = str_replace($res_url, $res_url, $path);
        return to_url($res_url . $path);
    } else {
        return $path;
    }

}


/**
 * 获取用户
 * @param $field
 * @param string $guard 认证器
 * @return mixed
 *
 */
function user($field, $guard = '')
{
    $user = \Illuminate\Support\Facades\Auth::guard($guard)->user();
    return $field ? $user[$field] : $user;
}

/**
 * 取得当前路由名字
 * @return null|string
 */
function get_current_name()
{
    return \Illuminate\Support\Facades\Route::currentRouteName();
}

function lang($key = null, $replace = [], $locale = null)
{
    if (is_null($key)) {
        return $key;
    }
    /**
     * * 表示加载全部，默认情况下，
     * 如果这个语言包格式没有数据会取找备用的数据,在 app.php配置下，修改fallback_locale为其他即可，
     * 如果不想修改，则使用下面的方法替换
     */
    if ($key == "*") {
        $lang_josn_file = app()->langPath() . '\\' . app()->getLocale() . '.json';
        $filesystem = new Illuminate\Filesystem\Filesystem();
        if ($filesystem->exists($lang_josn_file)) {
            try {
                $decoded = json_decode($filesystem->get($lang_josn_file), 1);
                return $decoded;
            } catch (ErrorException $exception) {
                return [];
            }

        }
        return [];

    }

    return trans($key, $replace, $locale);
}

/**
 * 检查权限
 * @param $route_name
 * @param string $prefix
 * @return bool
 */
function acan($route_name, $prefix = '')
{

    if (env('CHECK_ADMIN_DEBUG')) {
        return true;
    }
    //如果是超级管理员就不走角色规则了
    if (admin('is_root')) {
        return true;
    }
    //设置了不进行验证的规则
    if (in_array($route_name, config('admin.admin_menu_no_check_can'))) {
        return true;
    }

    return admin()->can($prefix . $route_name);
}

/**
 * 检查拥有任意一个里面的权限
 * @param $permissions
 * @return bool
 */
function acan_anys($permissions)
{
    if (admin('is_root')) {
        return true;
    }
    foreach ($permissions as $k => $v) {
        if (in_array($v, config('admin.admin_menu_no_check_can'))) {
            return true;
        }
    }
    return admin()->hasAnyPermission($permissions);
}

/**
 * 检验验证必须保护全部权限
 * @param $permissions
 * @return bool
 */
function acans($permissions)
{
    if (admin('is_root')) {
        return true;
    }
    foreach ($permissions as $k => $v) {
        if (in_array($v, config('admin.admin_menu_no_check_can'))) {
            unset($permissions[$k]);//移除判断
        }
    }
    return admin()->hasAnyPermissions($permissions);
}

/**
 * 后台菜单
 * @param string $type
 * @return mixed
 */
function admin_menu($type = '')
{
    return \Illuminate\Support\Facades\Cache::get('admin_menu', \App\Models\Permission::getCache());
}
function naction($name,$pram=[]){
    try{
        return action($name,$pram);
    }catch (Exception $e ){
        return '';
    }
}