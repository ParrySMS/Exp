<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-6-19
 * Time: 10:52
 *
 * 获取本地机的名称和IP地址。
 * 获取网站www.csdn.net的IP地址，如果存在多个IP地址，要求全部返回。
 * 使用URL类下载深圳大学首页http://www.szu.edu.cn，并统计下载得到网页文件的大小
 */
set_time_limit(0);//无限时间运行

echo "Local Connection" . PHP_EOL;

define("PORT", 12345);
define("LOCAL_IP", "127.0.0.1");
//define("CON_TYPE", SOCK_STREAM);//SOCK_STREAM是tcp SOCK_DGRAM是udp


try {
//创建socket
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

    if ($socket) {
        echo "socket_create() OK." . PHP_EOL;
    } else {
        echo "socket_create() failed" . PHP_EOL;
    }

//绑定
    socket_bind($socket, LOCAL_IP, PORT);

//获取本地名称和ip地址
    if (socket_getsockname($socket, $addr, $port)) {
        echo '[socketname] ';
        echo 'addr is ' . $addr . ':' . $port . PHP_EOL;
    }

//获取指定url的ip地址
    $url = "www.csdn.net";
    $host_ip = gethostbyname($url);
    echo '[host-IP]: ';
    echo $host_ip.PHP_EOL;


    //统计下载所得网页文件大小
    $url = "https://www.szu.edu.cn/";
    $result = get($url);
    echo strlen($result).' Byte'.PHP_EOL;
    echo strlen($result)/1024 .' MB'.PHP_EOL;


    socket_close($socket);//工作完毕，关闭套接流


}catch (Exception $e){
    var_dump($e);
    socket_close($socket);//工作完毕，关闭套接流
}

function get($url, array $data = [])
{
    $ch = curl_init();
    /* 设置验证方式 */
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept:text/plain;charset=utf-8',
        'Content-Type:application/x-www-form-urlencoded',
        'charset=utf-8'
    ));
    /* 设置返回结果为流 */
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    /* 设置超时时间*/
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    /* 设置通信方式 */
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    if (!empty($data)) {
        $url = $url . '?' . http_build_query($data);
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if ($result === false) {
        throw new Exception('Curl error: ' . $error, 501);
//            echo 'Curl error: ' . $error;
//            return null;
    } else {
        return $result;
    }
}