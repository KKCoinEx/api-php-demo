<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

require('customize.php');

class ApioController extends Controller{
    // 获取用户账户余额
    public function balance(Request $request){
        $this->rest(__FUNCTION__);
    }
    public function order(Request $request){
        $id = 111;
        $payload = array('id' => (string)$id);
        $this->rest(__FUNCTION__,$payload);
    }
    public function openorders(Request $request){
        $payload = array('symbol' => "EOS_ETH");
        $this->rest(__FUNCTION__,$payload);
    }
    public function trade(Request $request){
        $payload['symbol'] = "EOS_ETH";
        $payload['ordertype'] = 'LIMIT';        //1-LIMIT 2-MARKET 3-STOP 4-STOP_LIMIT
        $payload['orderop'] = 'BUY';            //1-BUY 2-SELL
        $payload['price'] = 0.01;               //价格
        $payload['amount']= 10;                 //数量

        $payload['price'] = (string)$payload['price'];
        $payload['amount'] = (string)$payload['amount'];
        $this->rest(__FUNCTION__, $payload, false);
    }
    public function cancel(Request $request){
        $orderid = '1234234234234';
        $payload = array();
        $payload = array('id' => (string)$orderid);
        $this->rest(__FUNCTION__, $payload, false);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////
    // REST API 统一调用接口
    /////////////////////////////////////////////////////////////////////////////////////////////////
    private function rest($endpoint, $payload = array(), $get = true){
        $passphrase = API_KEY_PASSPHRASE;
        $path = storage_path();
        $private_key_file = 'file://'.$path.API_PRIVATE_KEY; 
        dump('私钥文件：'.$private_key_file);        
        dump('私钥口令: '.$passphrase); 
        $public_key_file = 'file://'.$path.API_PUBLIC_KEY; 
        dump('公钥文件: '.$public_key_file);     
        //$contents = File::get($path.API_PUBLIC_KEY);
        //print_r("<code>$contents</code>");
        $api_url = API_REST_URL;
        $header_api_key = 'kkcoinapikey: '.API_KEY;
        $header_sign = 'kkcoinsign: ';
        $header_timestamp = 'kkcointimestamp: ';
        // 签名 & 组装
        $timestamp = time();
        if ($get){
            dump('路由：'.$endpoint.' 访问方式： GET   时间戳：'.$timestamp);
        }else
        {
            dump('路由：'.$endpoint.' 访问方式： POST  时间戳：'.$timestamp);          
        }
        dump('参数数组：'.json_encode($payload));
        ksort($payload, SORT_STRING | SORT_FLAG_CASE);
        $message = $endpoint.json_encode($payload).$timestamp;
        dump('组装好的消息报文：'.$message);
        $openssl_res = openssl_get_privatekey($private_key_file, $passphrase);
        $ssl_res = openssl_sign($message, $signature_bin, $openssl_res, OPENSSL_ALGO_SHA256);
        openssl_free_key($openssl_res);
        $signature = base64_encode($signature_bin);
        //dump('Base64后的签名：'.$signature);
        $header_array = array(
            $header_api_key,
            $header_sign.$signature,
            $header_timestamp.$timestamp);
        // 输出
        $http_res = curl_init();
        if ($get){
            $http_url =  $api_url.$endpoint.'?'.http_build_query($payload);
        }else{
            $http_url =  $api_url.$endpoint;
            curl_setopt($http_res, CURLOPT_POST, 1);
            curl_setopt($http_res, CURLOPT_POSTFIELDS, $payload);
        }
        dump('组装好的访问地址：'.$http_url);
        dump('组装好的定制HEADER数组：'.json_encode($header_array));
        curl_setopt($http_res, CURLOPT_URL, $http_url); 
        curl_setopt($http_res, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($http_res, CURLOPT_HTTPHEADER, $header_array);
        $response = curl_exec($http_res);
        curl_close($http_res);
        dump('服务器返回：'.$response);
    }

    function dump($exp)
    {
        print "<BR>"; var_dump($exp); print "<BR>"; 
    }
}
