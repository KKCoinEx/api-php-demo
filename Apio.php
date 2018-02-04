<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
// 本文件在应用时无需修改，复制到相应的工程文件目录使用
class Apio extends Model
{
    const POST = true;
    /////////////////////////////////////////////////////////////////////////////////////////////////
    // 接口初始化
    // passphrase             : 在本地生成私钥时采用的口令
    // api_key                : 用户从 KKCOIN.COM 获取的字符串，例如：1f614ce13a2bebab9c6d24ead4f5ec8f
    // filepath_to_private_key: 保存私钥文件的路径 例如：file:///usr/local/var/yourprivate.key
    /////////////////////////////////////////////////////////////////////////////////////////////////
    public function init($passphrase, $api_key, $filepath_to_private_key){
        $this->passphrase = $passphrase;
        $this->private_key_file = $filepath_to_private_key; 
        $this->api_url = 'http://api.kkcoin.com/rest/';
        $this->header_api_key = 'kkcoinapikey: '.$api_key;
        $this->header_sign = 'kkcoinsign: ';
        $this->header_timestamp = 'kkcointimestamp: ';
        $this->post = true;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////
    // 业务接口
    /////////////////////////////////////////////////////////////////////////////////////////////////
    // 获取用户账户余额
    public function balance(){
        return $this->rest(__FUNCTION__);
    }
    // 以下尚未调试通过
    public function order($id){
        $payload = array('id' => (string)$id);
        return $this->rest(__FUNCTION__,$payload);
    }
    public function openorders(){
        $payload = array();
        return $this->rest(__FUNCTION__);
    }
    public function trade($xx){
        $payload = array();
        $post_layoad = array('' => (string)$xx);
        return $this->rest(__FUNCTION__, $payload, Apio::POST, $post_layoad);
    }
    public function cancel($orderid){
        $payload = array();
        $post_layoad = array('orderid' => (string)$orderid);
        return $this->rest(__FUNCTION__, $payload, Apio::POST, $post_layoad);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////
    // REST API 统一调用接口
    /////////////////////////////////////////////////////////////////////////////////////////////////
    private function rest($endpoint, $payload = array(), $post = false, $post_layoad = array()){
        // 报文
        $timestamp = time();
        if ($post){
            $message = $endpoint.json_encode($post_layoad).$timestamp;
        }else{
            $message = $endpoint.json_encode($payload).$timestamp;
        }
        // 签名
        $openssl_res = openssl_get_privatekey($this->private_key_file, $this->passphrase);
        $ssl_res = openssl_sign($message, $signature_bin, $openssl_res, OPENSSL_ALGO_SHA256);
        openssl_free_key($openssl_res);
        $signature = base64_encode($signature_bin);
        // 组装
        $query_string = http_build_query($payload);
        $header_array = array(
            $this->header_api_key,
            $this->header_sign.$signature,
            $this->header_timestamp.$timestamp);
        // 输出
        $http_res = curl_init();
        if (empty($query_string)){
            $http_url =  $this->api_url.$endpoint;
        }else{
            $http_url =  $this->api_url.$endpoint.'?'.$query_string;
        }
        curl_setopt($http_res, CURLOPT_URL, $http_url); 
        curl_setopt($http_res, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($http_res, CURLOPT_HTTPHEADER, $header_array);
        if ($post){
            curl_setopt($http_res, CURLOPT_POST, 1);
            curl_setopt($http_res, CURLOPT_POSTFIELDS, $post_layoad);
        }
        $response = curl_exec($http_res); 
        curl_close($http_res);  
        $result = json_decode($response,true);
        return $result;
    }
}