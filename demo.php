<?php 
    $kkapi = new Apio;
    // 初始化接口，在调用业务接口前必须完成初始化，建议密钥口令在执行时录入，避免写入程序
    // passphrase             : 在本地生成私钥时采用的口令，例如：KKCOIN.COM
    // api_key                : 用户从 KKCOIN.COM 获取的字符串，例如：1f614ce13a2bebab9c6d24ead4f5ec8f
    // filepath_to_private_key: 保存私钥文件的路径 例如：file:///usr/local/var/yourprivate.key
    $kkapi->init('KKCOIN.COM','1f614ce13a2bebab9c6d24ead4f5ec8f','file:///usr/local/var/yourprivate.key');
    // 调用获取余额接口
    $result = $kkapi->balance();
    // 响应处理
    if ((isset($result['status_code']))){
        dd('Ooooops! KKCOIN resopnse: '.$result['message']);
    }else{
        var_dump($result); 
    }
    // 调用取消委托接口
    $result = $kkapi->cancel(201801280756363559);
    // 响应处理
    if ((isset($result['status_code']))){
        dd('Ooooops! KKCOIN response: '.$result['message']);
    }else{
        var_dump($result); 
    }
