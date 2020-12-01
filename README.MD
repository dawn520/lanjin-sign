# 使用方法
1.安装php7.0以上版本，及其OpenSSL扩展，及php-fpm，及composer
2.安装nginx1.14及以上版本，并配置配置如下
```nginx
     root /var/www/sign/;
     index index.php index.html index.htm;
     location / {
          try_files $uri $uri/ /index.php$is_args$args;
     }
     location ~ \.php$ {
         try_files $uri /index.php =404;
         fastcgi_pass php-upstream;
         fastcgi_index index.php;
         fastcgi_buffers 16 16k;
         fastcgi_buffer_size 32k;
         fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
         include fastcgi_params;
     }

```
3.进入项目目录，执行
```shell
composer install
cp .env.example .env
```
4.修改.env文件中的配置
```env
HASH_KEY=qjqZ9Oonkybrb7dw04vhMOCnPQalFghn
HASH_IV=jEQOa944TdE1FsL2
```
