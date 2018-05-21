## 安装


```

//安装扩展
composer install
//本地环境配置(数据库等配置)
cp .env.example .env
//生成安全秘钥
php artisan key:generate
//生成数据库队列相关表
php artisan queue:table
php artisan queue:failed-table
//生成数据迁移
php artisan migrate:fresh --seed
//生成文件存储软连接
php artisan storage:link
//生成类导航文件(用于编辑器代码跳转,可忽略)
php artisan ide-helper:generate
//后台访问地址(配置的域名/admin),登录账号:admin  密码:123456

```


