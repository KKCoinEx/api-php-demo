## KKCOIN.COM PHP DEMO

### 环境要求

- PHP 7.0 以上
- Laravel 5.5 以上

clone 本项目到本地，配置好 web 服务器即可运行

### 演示 RSA 密钥对
在 storage/ 目录下，加密口令 KKCOIN.COM

- yourprivate.key  # 私钥文件
- yourpublic.key   # 公钥文件

### 路由配置
在 route/web.php

### DEMO 代码
程序代码在 app/Http/Controllers/ApioContorller.php

### 运行
打开浏览器，输入
```
http://<your host>/balance
http://<your host>/order
http://<your host>/openorders
http://<your host>/trade
http://<your host>/cancel
```
一切顺利的话，会得到下面这样结果
![demo](https://github.com/KKCoinEx/api-php-demo)
