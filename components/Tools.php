<?php
/**
 * Tools.php
 * Descriptions:文件描述
 * Author:大圣翻译
 * Created on 2019/8/14 15:59
 */
namespace api\components;

use yii\base\Component;

//私钥文件
define('ICLOD_CERT_PATH',dirname(__FILE__).'/pri.key' );
//公钥文件
define('ICLOD_CERT_PUBLIC_PATH',dirname(__FILE__).'/pub.key' );
class Tools extends Component
{

    public function curl($url, $data)
    {
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, false);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data)));
        //设置post数据
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        return $data;
    }


    /**
     * 生成签名
     *
     * @param $data
     * @return string
     */
   public function sign($data)
   {
       $priKey = file_get_contents(ICLOD_CERT_PATH);
       $res = openssl_get_privatekey($priKey);
       openssl_sign($data, $sign, $res);
       openssl_free_key($res);
       //base64编码
       $sign = base64_encode($sign);
       return $sign;
   }


    /**
     * 数据加密
     *
     * @param $data
     * @return string
     */
   public function rsa($data)
   {
       $encryptData = "";
       $priKey = file_get_contents(ICLOD_CERT_PATH);
       $res = openssl_get_privatekey($priKey);
       openssl_private_encrypt($data, $encryptData, $res,OPENSSL_PKCS1_PADDING);
       openssl_free_key($res);
       return base64_encode($encryptData);
   }


    /**
     * 数据解密
     *
     * @param $data
     * @return string
     */
   public function decryptRSA($data)
   {
       $decryptData = '';
       $publickey = file_get_contents(ICLOD_CERT_PUBLIC_PATH);
       $res = openssl_pkey_get_public($publickey);
       $result= openssl_public_decrypt(base64_decode($data), $decryptData, $res);
       return $decryptData;
   }


    /**
     * 数据验签
     *
     * @param $data
     * @return bool
     */
   public function verify($data)
   {
       $publickey = file_get_contents(ICLOD_CERT_PUBLIC_PATH);
       $res = openssl_get_publickey($publickey);
       $result = (bool)openssl_verify($data['signedValue'], base64_decode($data['sign']), $res);
       openssl_free_key($res);
       return $result;
   }

}