## KKCoin.COM API PHP DEMO（WEB）

### 环境要求

- PHP 7.0 以上
- Laravel 5.5 以上

### 下载文件
- [ApioController.php](https://github.com/KKCoinEx/api-php-demo/blob/master/ApioController.php) // 控制器
- [web.php](https://github.com/KKCoinEx/api-php-demo/blob/master/web.php) // 路由
- [customize.example.php](https://github.com/KKCoinEx/api-php-demo/blob/master/src/customize.example.php) // 配置文件

### 生成本地密钥对
程序要求在可访问的目录下存放私钥及公钥文件，因为安全需要，这两个文件未上传至 GitHub，请自行根据[生成密钥](https://github.com/KKCoinEx/api-wiki/wiki/RESTful-Auth-D1.-generate-key-pair)生成密钥，并在 ApioControllers.php 程序中修改下面的值

```php
    const API_PRIVATE_KEY = '/yourprivate.key'; // 公钥文件的位置
    const API_PUBLIC_KEY = '/yourpublic.key';   // 私钥文件的位置
    const API_KEY_PASSPHRASE = 'KKCOIN.COM';    // 加密私钥的密码
```

### 生成 Laravel 工程
1. 复制 web.php 到 route 目录
2. 复制 ApioController.php 到 app/Htttp/Controllers
3. 复制 customize.example.php 到 app/Htttp/Controllers/customize.php

### 配置 Web 服务器指向工程文件 public 目录

### 运行
打开浏览器，输入以下指令，能得到程序内设置的默认参数的输出，也可以根据需要修改参数
```
http://<your host>/balance // 查询账户余额

http://<your host>/order // 查询订单状态

http://<your host>/openorders // 查询有效委托

http://<your host>/trade // 委托下单

http://<your host>/cancel // 取消委托
```
一切顺利的话会得到类似下图的返回结果，欢迎利用这个 DEMO 来验证配置和应用，GOOD LUCK！
![demo](https://github.com/KKCoinEx/api-php-demo/blob/master/chart/demo.png)
