## KKCoin.COM API PHP Demo（CLI）

### 环境要求

- PHP 7.0 以上

### 下载文件

- [kkapi.php](https://github.com/KKCoinEx/api-php-demo/blob/master/kkapi.php)
- [customize.example.php](https://github.com/KKCoinEx/api-php-demo/blob/master/customize.example.php), 改名为 customize.php

### 生成本地密钥对
程序要求在可访问的目录下存放私钥及公钥文件，因为安全需要，这两个文件未上传至 GitHub，请自行根据[生成密钥](https://github.com/KKCoinEx/api-wiki/wiki/RESTful-Auth-D1.-generate-key-pair)生成密钥，并在 customize.php 程序中修改下面的值

```php
    const API_PRIVATE_KEY = '/yourprivate.key'; // 公钥文件的位置
    const API_PUBLIC_KEY = '/yourpublic.key';   // 私钥文件的位置
    const API_KEY_PASSPHRASE = 'KKCOIN.COM';    // 加密私钥的密码
```

### 运行

```
$ php kkapi.php balance
$ php kkapi.php order  
$ php kkapi.php openorders  
$ php kkapi.php trade  
$ php kkapi.php cancel  
```
