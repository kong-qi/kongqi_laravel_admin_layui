<?php
return [
    //不进行权限验证的路由名称
    'admin_menu_no_check_can' => [
        'admin.home'
    ],
    //上传目录
    'upload_dir' => env('UPLOAD_DIR', '/upload'),
    //上传大小,单位M
    'upload_max_size'=> env('UPLOAD_MAX_SIZE', 50)
];
?>