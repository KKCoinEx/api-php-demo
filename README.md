## KKCOIN.COM API PHP DEMO（WEB）

### 环境要求

- PHP 7.0 以上
- Laravel 5.5 以上

clone 本项目到本地，配置好 web 服务器即可运行

### 演示 RSA 密钥对
程序要求在 storage/ 目录下存放私钥及公钥文件，因为安全需要，这两个文件已经被我们删除，请自行根据[生成密钥](https://github.com/KKCoinEx/api-wiki/wiki/RESTful-Auth-D1.-generate-key-pair)生成您自己的密钥，并在程序中修改下面的值

```php
    const API_PRIVATE_KEY = '/storage/yourprivate.key';
    const API_PUBLIC_KEY = '/storage/yourpublic.key';
    const API_KEY_PASSPHRASE = 'KKCOIN.COM';
```

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
一切顺利的话，会得到类似下图的返回结果，您可以利用这个 DEMO 来验证本地配置和应用，GOOD LUCK！
![demo](https://github.com/KKCoinEx/api-php-demo/blob/master/demo.png)

## KKCOIN.COM API PHP DEMO（CLI）

### 环境要求

- PHP 7.0 以上

### DEMO 代码
程序代码在 Apio.php

### 运行
$ php Apio.php balance  
$ php Apio.php order  
$ php Apio.php openorders  
$ php Apio.php trade  
$ php Apio.php cancel  
