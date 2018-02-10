## KKCoin.COM API PHP DEMO（WEB）

### 环境要求

- PHP 7.0 以上
- Laravel 5.5 以上

### 下载文件
ApioController.php, web.php

### 生成本地密钥对
程序要求在可访问的目录下存放私钥及公钥文件，因为安全需要，这两个文件已经被我们删除，请自行根据[生成密钥](https://github.com/KKCoinEx/api-wiki/wiki/RESTful-Auth-D1.-generate-key-pair)生成您自己的密钥，并在 ApioControllers.php 程序中修改下面的值

```php
    const API_PRIVATE_KEY = '/yourprivate.key'; // 公钥文件的位置
    const API_PUBLIC_KEY = '/yourpublic.key';   // 私钥文件的位置
    const API_KEY_PASSPHRASE = 'KKCOIN.COM';    // 加密私钥的密码
```

### 生成 Laravel 工程
1. 复制 web.php 到 route 目录
2. 复制 ApioController.php 到 app/Htttp/Controllers

### 配置 Web 服务器指向工程文件 public 目录

### 运行
打开浏览器，输入
```
http://<your host>/balance
http://<your host>/order
http://<your host>/openorders
http://<your host>/trade
http://<your host>/cancel
```
一切顺利的话会得到类似下图的返回结果，您可以利用这个 DEMO 来验证配置和应用，GOOD LUCK！
![demo](https://github.com/KKCoinEx/api-php-demo/blob/master/demo.png)
