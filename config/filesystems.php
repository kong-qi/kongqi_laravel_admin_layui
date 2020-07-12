<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],
        //七牛
        'qiniu' => [
            'driver' => 'qiniu',
            'domains' => [
                'default' => env('QINIU_DOMAIN',''), //你的七牛CDN域名
                'https' => '',         //你的HTTPS域名
                'custom' => '',                //Useless 没啥用，请直接使用上面的 default 项
            ],
            'access_key' => env('QINIU_ACCESS_KEY',''),  //AccessKey
            'secret_key' => env('QINIU_SECRET_KEY',''),  //SecretKey
            'bucket' =>env('QINIU_BUCKET',''),  //Bucket名字
            'notify_url' => '',  //持久化处理回调地址
            'access' => 'public',  //空间访问控制 public 或 private
            'hotlink_prevention_key' => null, // CDN 时间戳防盗链的 key。 设置为 null 则不启用本功能。
        ],
        //阿里云OSS
        'oss' => [
            'driver' => 'oss',
            'access_id' => env('OSS_ACCESS_ID',''),
            'access_key' => env('OSS_SECRET_KEY',''),
            'bucket' => env('OSS_BUCKET',''),
            'endpoint' => env('OSS_ENDPOINT',''), // OSS 外网节点或自定义外部域名
            //'endpoint_internal' => '<internal endpoint [OSS内网节点] 如：oss-cn-shenzhen-internal.aliyuncs.com>', // v2.0.4 新增配置属性，如果为空，则默认使用 endpoint 配置(由于内网上传有点小问题未解决，请大家暂时不要使用内网节点上传，正在与阿里技术沟通中)
            'cdnDomain' => env('OSS_CDNDOMAIN',false), // 如果isCName为true, getUrl会判断cdnDomain是否设定来决定返回的url，如果cdnDomain未设置，则使用endpoint来生成url，否则使用cdn
            'ssl' => env('OSS_SSL',false), // true to use 'https://' and false to use 'http://'. default is false,
            'isCName' => env('OSS_ISCNAME',''), // 是否使用自定义域名,true: 则Storage.url()会使用自定义的cdn或域名生成文件url， false: 则使用外部节点生成url
            'debug' => env('OSS_DEBUG',false),
        ],
        //腾讯云COS
        'cos' => [
            'driver' => 'cosv5',
            'region'          => env('COS_REGION', 'ap-guangzhou'),
            'credentials'     => [
                'appId'     => env('COS_APP_ID',''),
                'secretId'  => env('COS_SECRET_ID',''),
                'secretKey' => env('COS_SECRET_KEY',''),
                'token'     => env('COS_TOKEN',null),
            ],
            'timeout'         => env('COS_TIMEOUT', 60),
            'connect_timeout' => env('COS_CONNECT_TIMEOUT', 60),
            'bucket'          => env('COS_BUCKET',''),
            'cdn'             => env('COS_CDN',''),
            'scheme'          => env('COS_SCHEME', 'https'),
            'read_from_cdn'   => env('COS_READ_FROM_CDN', false),
            'cdn_key'         => env('COS_CDN_KEY'),
            'encrypt'         => env('COS_ENCRYPT', false),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
