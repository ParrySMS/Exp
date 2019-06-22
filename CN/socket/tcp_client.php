<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-6-21
 * Time: 22:20
 */



set_time_limit(0);//无限时间运行
define("PORT", 8888);
define("LOCAL_IP", "127.0.0.1");
try {
    //创建socket
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if (!$socket)
        throw new Exception("socket_create() failed");

    //发起主动的连接
    if(! socket_connect($socket, LOCAL_IP, PORT))
        throw new Exception("socket_connect() failed");

    //发送消息到服务端
    $msg = 'This is client.php  --'.date('Y-m-d H:i:s');
    if(!socket_write($socket, $msg, strlen($msg)))
        throw new Exception("socket_write() failed");

    //从服务端接收信息
    $buf = socket_read($socket, 4*1024); // 获得客户端的输入

    echo "client-buf-get:$buf".PHP_EOL;

    socket_close($socket);//工作完毕，关闭套接流

} catch (Exception $e) {
    echo $e->getMessage();
    socket_close($socket);//工作完毕，关闭套接流
}
