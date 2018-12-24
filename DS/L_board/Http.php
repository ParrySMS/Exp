<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2018-6-17
 * Time: 22:46
 */


class Http
{

    public $curl;

    /**
     * Http constructor.
     */
    public function __construct()
    {
        $this->curl = curl_init();
    }


    /** 模拟get进行url请求
     * @param $url
     * @param array $data
     * @param bool $close 默认执行完毕之后关闭流
     * @return mixed
     * @throws Exception
     */
    public function get($url, array $data = [],$close = true)
    {
        $curl =$this->curl;
        /* 设置验证方式 */
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Accept:text/plain;charset=utf-8',
            'Content-Type:application/x-www-form-urlencoded',
            'charset=utf-8'
        ));
        /* 设置返回结果为流 */
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        /* 设置超时时间*/
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        /* 设置通信方式 */
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        if (!empty($data)) {
            $url = $url . '?' . http_build_query($data);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        $result = curl_exec($curl);
        $error = curl_error($curl);

        if($close){
            curl_close($curl);
        }

        if ($result === false) {
            throw new Exception('Curl error: ' . $error, 501);
//            echo 'Curl error: ' . $error;
//            return null;
        } else {
            return $result;
        }
    }

    /**  模拟post进行url请求
     * @param $url
     * @param array $data
     * @param bool $close 默认执行完毕之后关闭流
     * @return mixed
     * @throws Exception
     */
    public function post($url, array $data = [],$close = true)
    {
        $curl =$this->curl;
//        $ch = curl_init();
        /* 设置验证方式 */
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Accept:text/plain;charset=utf-8',
            'Content-Type:application/x-www-form-urlencoded',
            'charset=utf-8'
        ));
        /* 设置返回结果为流 */
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        /* 设置超时时间*/
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        /* 设置通信方式 */
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        $result = curl_exec($curl);
        $error = curl_error($curl);

        if($close){
            curl_close($curl);
        }
        if ($result === false) {
            throw new Exception('Curl error: ' . $error, 501);
//            return null;
        } else {
            return $result;
        }
    }

}