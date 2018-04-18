## 安装


```

//安装扩展
composer install
//本地环境配置
cp .env.example .env
//生成安全秘钥
php artisan key:generate
//生成类导航文件(用于编辑器代码跳转)
php artisan ide-helper:generate
//生成数据迁移
php artisan migrate:fresh --seed
```


