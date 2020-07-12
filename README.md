
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
http://www.heibaiketang.com

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
​
​
```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:p8XSNhkLVxKPEmM6Poj4oyS6NI5KUQkxpjbT3WwBuIY=
APP_DEBUG=true
APP_URL=http://localhost
​
LOG_CHANNEL=stack
​
#数据库相关信息
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lvadminlayui
DB_USERNAME=root
DB_PASSWORD=123456
​
BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=redis
SESSION_DRIVER=file
SESSION_LIFETIME=120
​
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
​
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"
​
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
​
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1
​
MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
​
# 系统语言
LANG=cn
#MYSQL严格模式取消
DB_STRICT=false
​
#配置后台地址
ADMIN_URL=null
#资源文件是否增加http域名前缀
RES_HTTP_URL=null
​
#上传设置
# 上传目录
UPLOAD_DIR=/upload
# 最大上传大小,单位M
UPLOAD_MAX_SIZE=50
​
​
KONGQI_SERVER=eyJob3N0Ijoid3d3LmtxcDIudGVzdCIsImlwIjoiMTI3LjAuMC4xIiwicG9ydCI6IjgwIn0=
DEBUGBAR_ENABLED=0
# 是否关闭插件应用，1表示是开启，0表示关闭
OPEN_PLUGIN=1
​
# 开启后台验证码,ADMIN_OPEN_CAPTCHA=1 表示开启，0关闭
ADMIN_OPEN_CAPTCHA=0
ADMIN_CAPTCHA_TYPE=admin
​
​
​
​
#默认上传文件类型，支持local,oss,cos,qiniu
FILESYSTEM_DRIVER=local
​
​
#七牛上传配置
QINIU_ACCESS_KEY=
QINIU_SECRET_KEY=
##Bucket名字
QINIU_BUCKET=
QINIU_DOMAIN=
​
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
​
# 腾讯云COS配置
#所属地区
COS_REGION=
COS_APP_ID=
COS_SECRET_ID=
COS_SECRET_KEY=
COS_TOKEN=null
#COS桶名称
COS_BUCKET=
#COS访问域名
COS_CDN=
COS_SCHEME=https
COS_CDN_KEY=
COS_ENCRYPT=
```
​
3.执行安装  Laravel 依赖
​
```
composer install 
```
​
4. 修改数据库信息
数据库引擎必须是`InnoDB` , 字符集 `utf8mb4`  
因为有些同学，他们用了 `mysql8` ,但是默认的引擎使用的 `myisam` ,所以新建库的时候需要改下这个，如果不懂如何操作，就百度下，如何修改数据库默认搜索引擎。 否则安装的时候会报 索引长度问题。
​
```
DB_CONNECTION=驱动
DB_HOST=主机
DB_PORT=端口
DB_DATABASE=数据库名称 
DB_USERNAME=数据库账号
DB_PASSWORD=数据库密码
```
​
5. 绑定一个本地域名到目录下 `public`  
​
6. 重写
​
> Apaceh
​
Apaceh 环境可以不用写，默认自带了，如果没有，则在 `public/.htaccess` 创建,如果你还不会创建这个文件，请使用搜索一下怎么创建，`window`下是不允许直接创建` .`开头的文件。
​
```
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>
​
    RewriteEngine On
​
    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
​
    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]
​
    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```
​
> Nginx
​
```
location / {
    if (!-e $request_filename){
        rewrite  ^(.*)$  /index.php?s=$1  last;   break;
    }
}
```
​
7. 执行数据库迁移
这里已经移除了在线安装
​
```
php artisan migrate
```
​
填充数据
```
php artisan db:seed
​
```
​
8. 登录你的后台
访问地址
​
```
域名/admin
```
​

安装完成，感谢您的使用

## 问题
- 如果文件无法上传，检查你的public/upload是否创建了目录，是否有权限写入,如果没有创建，则需要创建下这个目录
- storage 需要写权限
- public/upload 需要写权限


## 系统截图  


## 贡献

感谢laravel,Layui,Jquery

## License

MIT协议 [MIT license](https://opensource.org/licenses/MIT).
