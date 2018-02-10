<?php
require('customize.php');

/////////////////////////////////////////////////////////////////////////////////////////////////
// 命令行入口
/////////////////////////////////////////////////////////////////////////////////////////////////
$Apio = new ApioController;
$method = $argv[1];
$params = array_slice($argv,2);
if (!empty($params)){
    $Apio->$method($params);
}else{
    $Apio->$method();
}

class ApioController {
    const API_HEADER_KEY  = 'kkcoinapikey: ';
    const API_HEADER_SIGN = 'kkcoinsign: ';
    const API_HEADER_TIME = 'kkcointimestamp: ';

/////////////////////////////////////////////////////////////////////////////////////////////////
// REST API 统一调用接口
/////////////////////////////////////////////////////////////////////////////////////////////////
    private function rest($endpoint, $payload = array(), $get = true){
        $path = getcwd();
        $timestamp = time();
        $private_key_file = $path.API_PRIVATE_KEY;  
        $public_key_file = $path.API_PUBLIC_KEY;
        ksort($payload, SORT_STRING | SORT_FLAG_CASE);
        $message = $endpoint.json_encode($payload).$timestamp;
        $method = $get?'GET':'POST';

        //self::dump('私钥文件：'.$private_key_file);   
        //self::dump('公钥文件: '.$public_key_file);     
        //self::dump('私钥口令: '.self::API_KEY_PASSPHRASE);   
        self::dump('路由节点：'.$endpoint);
        self::dump('访问方式：'.$method);
        self::dump('时 间 戳：'.$timestamp);
        self::dump('参数数组：'.json_encode($payload));
        self::dump('消息报文：'.$message);

        $openssl_res = openssl_get_privatekey('file://'.$private_key_file, API_KEY_PASSPHRASE);
        $ssl_res = openssl_sign($message, $signature_bin, $openssl_res, OPENSSL_ALGO_SHA256);
        openssl_free_key($openssl_res);
        $signature = base64_encode($signature_bin);
        self::dump('Base64后的签名：\n'.$signature);
        $header_array = array(
            self::API_HEADER_KEY.API_KEY,
            self::API_HEADER_SIGN.$signature,
            self::API_HEADER_TIME.$timestamp);
        // 输出
        $http_res = curl_init();
        if ($get){
            if (empty($payload)){
                $http_url =  API_REST_URL.$endpoint;
            }else{
                $http_url =  API_REST_URL.$endpoint.'?'.http_build_query($payload);
            }
        }else{
            $http_url =  API_REST_URL.$endpoint;
            curl_setopt($http_res, CURLOPT_POST, 1);
            curl_setopt($http_res, CURLOPT_POSTFIELDS, $payload);
        }
        self::dump('开始访问：'.$http_url);
        //self::dump('组装好的定制HEADER数组：\n'.json_encode($header_array));
        curl_setopt($http_res, CURLOPT_URL, $http_url); 
        curl_setopt($http_res, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($http_res, CURLOPT_HTTPHEADER, $header_array);
        $response = curl_exec($http_res);
        curl_close($http_res);
        echo "服务器返回：\n";
        return $response;
    }

    function dump($exp)
    {
        print_r($exp);
        print_r("\n"); 
    }

/////////////////////////////////////////////////////////////////////////////////////////////////
// 业务入口
/////////////////////////////////////////////////////////////////////////////////////////////////
    // 获取用户账户余额
    public function balance(){
        $response = self::rest(__FUNCTION__);
        var_dump($response);
        $arr = json_decode($response,true);
        if (is_null($arr)){
            print_r($response);
        }else{
            $bal = array();
            foreach ($arr as $key => $value) {
                if (intval($value['bal']) > 0){
                    $bal[] = $value;
                }
            }
            var_dump($bal);            
        }
    }
    public function order($params = array('20180207000000000147')){
        $payload = array('id' => $params[0]);
        $response = self::rest(__FUNCTION__,$payload);
        $arr = json_decode($response,true);
        var_dump($arr);
    }
    public function openorders($params = array("EOS_ETH")){
        $payload = array('symbol' => $params[0]);
        $response = self::rest(__FUNCTION__,$payload);
        $arr = json_decode($response,true);
        var_dump($arr);
    }
    public function trade($params = 
        array('KK_ETH', 'LIMIT', 'BUY', '0.01', '1000')){
        $payload['symbol'] = $params[0];
        $payload['ordertype'] = $params[1];        
        $payload['orderop'] = $params[2];            
        $payload['price'] =  $params[3];               
        $payload['amount']=  $params[4];       
        $response = self::rest(__FUNCTION__, $payload, false);
        $arr = json_decode($response,true);
        var_dump($arr);
    }
    public function cancel($params = array('20180207000000000147')){
        $payload = array('id' => $params[0]);
        $response = self::rest(__FUNCTION__, $payload, false);
        $arr = json_decode($response,true);
        var_dump($arr);
    }
}
