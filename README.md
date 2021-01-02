### KongQi Laravel admin 2.0 layui
集成了，图片上传，多图上传，批量Excel导入，批量插入，修改，添加，搜索，权限管理RBAC,验证码，插件一个综合完善后台，助你开发快人一步。     
准许协议MIT，允许你修改和包装，但需要注明版权。

- 作者:空气  
- QQ:531833998  
- 欢迎定制系统，全职提供技术。
- 版权：好学科技所有
- 详细文档地址 https://www.heibaiketang.com/note/cover/9.html
- 后台演示地址 http://testlaravel2.haoxuekeji.cn/admin 
- 账号:kongqi
- 密码:kongqi1688


## 关于后台管理系统

利用laravel框架，打造一款快速开发后台操作，内置了RBAC权限管理，集成了列表api,批量删除，批量增加，Excel批量导入，排序，列表编辑，图片上传，图片多图上传，编辑器，插件安装等。
- 界面采用Layui admin ，结合Layui，简单方便，上手容易
- 对经常用到的一些功能，进行了封装和改造，让代码写的更少。
- 拿到就能快速开发，无需繁琐的搭建一个后台管理系统。
- 代码极少就能完成增删改查。
- 搜索功能进行了改变，减少一大堆的判断，让你写起来更爽
- blade视图自动找到文件模板，免去写很多的视图定位文件，全部自动化。
- blade公用模板，让你经常写的代码全部一次搞定
- ui生成库可以随便插拔更换。
- 利用控制器就能把blade 模板搞定

### 系统说明

- PHP7.2以上版本
- MySQL v5.7.7及更高版本
- Laravel 6.0,低于这个版本也可以，但不能低于 laravel 5.4版本


### 最新学习社区-黑白课堂
https://www.heibaiketang.com

## 安装

## 本地环境

- php 7.2 +
- composer 
- mysql5.77 +




## 安装  

1.  拉取代码  

Github
```
https://github.com/kong-qi/kongqi_laravel_admin_layui.git

```
码云
```
https://gitee.com/kong_qi/kongqi_laravel_admin_layui.git

```

2.设置下你的配置信息 `.env`,在你的根目录下创建一个`.env`

```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:p8XSNhkLVxKPEmM6Poj4oyS6NI5KUQkxpjbT3WwBuIY=
APP_DEBUG=true
APP_URL=http://localhost
LOG_CHANNEL=stack
#数据库相关信息
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lvadminlayui
DB_USERNAME=root
DB_PASSWORD=123456
BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=redis
SESSION_DRIVER=file
SESSION_LIFETIME=120
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

# 系统语言
LANG=cn
#MYSQL严格模式取消
DB_STRICT=false

#配置后台地址
ADMIN_URL=null
#资源文件是否增加http域名前缀
RES_HTTP_URL=null

#上传设置
# 上传目录
UPLOAD_DIR=/upload
# 最大上传大小,单位M
UPLOAD_MAX_SIZE=50

#是否开启调试debug
DEBUGBAR_ENABLED=0
# 是否关闭插件应用，1表示是开启，0表示关闭
OPEN_PLUGIN=1

# 开启后台验证码,ADMIN_OPEN_CAPTCHA=1 表示开启，0关闭
ADMIN_OPEN_CAPTCHA=0
ADMIN_CAPTCHA_TYPE=admin

#默认上传文件类型，支持local,oss,cos,qiniu
FILESYSTEM_DRIVER=local

#七牛上传配置
QINIU_ACCESS_KEY=
QINIU_SECRET_KEY=
##Bucket名字
QINIU_BUCKET=
QINIU_DOMAIN=

#阿里云OSS配置
OSS_ACCESS_ID=
OSS_SECRET_KEY=
##Bucket名字
OSS_BUCKET=
OSS_ENDPOINT=
## 是否开启cnd 域名
OSS_ISCNAME=false
OSS_CDNDOMAIN=''
OSS_SSL=false
OSS_DEBUG=false

# 腾讯云COS配置
#所属地区
COS_REGION=
COS_APP_ID=
COS_SECRET_ID=
COS_SECRET_KEY=
COS_TOKEN=null
#COS桶名称
COS_BUCKET=
#COS访问域名,COS_CDN需要补齐http或https
COS_CDN=
#COS_SCHEME是http还是https
COS_SCHEME=https
COS_CDN_KEY=
COS_ENCRYPT=
```

3.执行安装  Laravel 依赖

```
composer install 
```

4.修改数据库信息


数据库引擎必须是`InnoDB` , 字符集 `utf8mb4`  
因为有些同学，他们用了 `mysql8` ,但是默认的引擎使用的 `myisam` ,所以新建库的时候需要改下这个，如果不懂如何操作，就百度下，如何修改数据库默认搜索引擎。 否则安装的时候会报 索引长度问题。

```
DB_CONNECTION=驱动
DB_HOST=主机
DB_PORT=端口
DB_DATABASE=数据库名称 
DB_USERNAME=数据库账号
DB_PASSWORD=数据库密码
```

5.绑定一个本地域名到目录下 `public`  


6.重写

> Apaceh

Apaceh 环境可以不用写，默认自带了，如果没有，则在 `public/.htaccess` 创建,如果你还不会创建这个文件，请使用搜索一下怎么创建，`window`下是不允许直接创建` .`开头的文件。

```
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```


> Nginx

```
location / {
    if (!-e $request_filename){
        rewrite  ^(.*)$  /index.php?s=$1  last;   break;
    }
}
```

7.执行数据库迁移
这里已经移除了在线安装

```
php artisan migrate
```

填充数据
```
php artisan db:seed

```

8.登录你的后台
访问地址

```
域名/admin
```

后台默认账号：`kongqi`  
密码：`kongqi1688`


安装完成，感谢您的使用

## 问题
- 如果文件无法上传，检查你的public/upload是否创建了目录，是否有权限写入,如果没有创建，则需要创建下这个目录
- storage 需要写权限
- public/upload 需要写权限


## 系统截图  
![](https://heibaiketang.oss-cn-shenzhen.aliyuncs.com/system/0.png
)  
![](https://heibaiketang.oss-cn-shenzhen.aliyuncs.com/system/01.png
)  
![](https://heibaiketang.oss-cn-shenzhen.aliyuncs.com/system/1.png
)  
![](https://heibaiketang.oss-cn-shenzhen.aliyuncs.com/system/2.png
)  
![](https://heibaiketang.oss-cn-shenzhen.aliyuncs.com/system/3.png
)  
![](https://heibaiketang.oss-cn-shenzhen.aliyuncs.com/system/4.png
)  
![](https://heibaiketang.oss-cn-shenzhen.aliyuncs.com/system/5.png
)  

## 新手入门快速开发
## 新手入门
我们安装完之后，第一步就是想做我们的数据的增删改查列表这些，那么我们需要哪些步骤了。我们系统已经给你们封装好了方法，只有根据用即可，当然你也可以完成按`Laravel`的写法写，这个不冲突，2者都可以，做到共存，随心编程。

比如我们创建一个控制器
```
php artisan make:controller Admin\NewsController
```
创建模型和数据表
```
php artisan make:model Models\News -m
```
修改数据模型,继承下基本
```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends BaseModel
{
    //
}
```

修改数据库迁移
```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('标题');
            $table->integer('views')->default(0)->comment('查看量');
            $table->string('thumb')->comment('缩略图')->nullable();
            $table->text('content')->comment('正文内容');
            $table->integer('is_checked')->default(0)->comment('状态');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}


```
```
php artisan migrate
```
编写路由 `Route/admin.php`
![描述](https://www.heibaiketang.com/upload/images/20200713/31329953003f53ac2d2d5840c76de1df37448.png)  
后台菜单添加下  
![描述](https://www.heibaiketang.com/upload/images/20200713/49cf84d0c33bffca9f1ee75184d5470e3769.png)  
![描述](https://www.heibaiketang.com/upload/images/20200713/73490a95481669d08bdc442b329440de71549.png)  
添加之后刷新就可以看到菜单了。

### 步骤如下
- 0.数据模型，数据表，路由准备好
- 1.设置数据模型
- 2.首页搜索部分
- 3.首页按钮
- 4.首页数据列表字段显示
- 5.首页数据字段附加
- 6.添加和编辑页面字段输出
- 7.添加编辑数据验证
- 8.操作数据的监听

### 编写过程
刚才我们创建了`NewsController`这个控制器，继承下CURL控制器
```
<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;

class NewsController extends BaseCurlController
{
    
}

```

**1.这里操作之前需要定义好模型和数据**

```
  public $pageName='新闻管理';
 public function setModel()
    {
        return $this->model = new News();
    }

```

**2.设置首页列表数据**

```
//2.首页的数据表格数组
    public function indexCols()
    {
        //这里99%跟layui的表格设置参数一样
        $data = [
            [
                'type' => 'checkbox'
            ],
            [
                'field' => 'id',
                'width' => 80,
                'title' => '编号',
                'sort' => 1,
                'align' => 'center'
            ],
            [
                'field' => 'name',
                'minWidth' => 150,
                'title' => '名称',
                'align' => 'center',

            ],

            [
                'field' => 'is_checked_html',
                'minWidth' => 80,
                'title' => '状态',
                'align' => 'center',
            ],
            [
                'field' => 'created_at',
                'minWidth' => 150,
                'title' => '发布时间',
                'align' => 'center'
            ],
            [
                'field' => 'handle',
                'minWidth' => 150,
                'title' => '操作',
                'align' => 'center'
            ]
        ];
        //要返回给数组
        return $data;
    }
```
![描述](https://www.heibaiketang.com/upload/images/20200713/45f7661de53cb3edd73437f25a2e538073802.png)  

现在就看到这样了。我们还需要增加搜索
```
 //3.设置搜索表单部分
    public function setOutputSearchFormTpl($shareData)
    {
        $data = [
            [
                'field' => 'id',
                'type' => 'text',
                'name' => 'ID',
            ],
            [
                'field' => 'query_like_name',//这个搜索写的查询条件在app/TraitClass/QueryWhereTrait.php 里面写
                'type' => 'text',
                'name' => '名称',
            ],

            [
                'field' => 'query_is_checked',
                'type' => 'select',
                'name' => '是否启用',
                'default' => '',
                'data' => $this->uiService->trueFalseData(1)

            ]

        ];
        //赋值到ui数组里面必须是`search`的key值
        $this->uiBlade['search'] = $data;
    }
```
![描述](https://www.heibaiketang.com/upload/images/20200713/b703ad8d352b4501c7dda9a9d02872946377.png)  

看到搜索部分了吧

**3.添加和编辑的数据列表  **

```
 //4.编辑和添加页面表单数据
    public function setOutputUiCreateEditForm($show = '')
    {

        $data = [
            [
                'field' => 'name',
                'type' => 'text',
                'name' => '标题',
                'must' => 1,
                'verify' => 'rq'
            ],
            [
                'field' => 'views',
                'type' => 'number',
                'name' => '查看量',
                'must' => 1,
                'verify' => 'rq',
                'default'=>0
            ],
            [
                'field' => 'thumb',
                'type' => 'img',
                'name' => '缩略图',
                'verify' => 'img'
            ],
            [
                'field' => 'is_checked',
                'type' => 'radio',
                'name' => '是否启用',
                'verify' => '',
                'default' => 1,
                'data' => $this->uiService->trueFalseData()
            ],
            [
                'field' => 'content',
                'type' => 'editor',
                'name' => '内容',
                'verify' => 'rq',
                'must' => 1
            ]

        ];

        //赋值到ui数组里面必须是`form`的key值
        $this->uiBlade['form'] = $data;
    }
```
![描述](https://www.heibaiketang.com/upload/images/20200713/4a5fb27f99fff1058f7fa7aa9bf72d523708.png)  
感觉弹窗不够大，来修改下
```
 public function layuiOpenWidth()
    {
        return '700px'; // TODO: Change the autogenerated stub
    }
    public function layuiOpenHeight()
    {
        return '800px'; // TODO: Change the autogenerated stub
    }
```
![描述](https://www.heibaiketang.com/upload/images/20200713/eb62d6afeb0ddfd7bba0bd8781ae601685154.png)  

![描述](https://www.heibaiketang.com/upload/images/20200713/71087f3cb6964a1699b10a28149c4cae8748.png)  
添加就可以了。这样我们就完成了，最简单的增删改查。

我们还需要加后端数据**表单验证**  
```
//5.表单验证
    public function checkRule($id = '')
    {
        //$id不为空是表示编辑操作
        //这里我都写公用，所以写一个
        return [
            'name'=>'required',
            'content'=>'required',
            'views'=>'required'
        ];
    }
    //6.表单对应的字段
    public function checkRuleFieldName()
    {
        return [
            'name'=>'标题',
            'content'=>'正文',
            'views'=>'查看量'
        ];
    }
```

这样就完成了最基本的**增删改查操作**

## 贡献

感谢laravel,Layui,Jquery

## License

MIT协议 [MIT license](https://opensource.org/licenses/MIT).