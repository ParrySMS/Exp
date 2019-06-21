<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-6-21
 * Time: 21:48
 */


set_time_limit(0);//无限时间运行
define("PORT", 8888);
define("LOCAL_IP", "127.0.0.1");
try {
    //创建socket
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if (!$socket)
        throw new Exception("socket_create() failed");

    //绑定
    if(!socket_bind($socket, LOCAL_IP, PORT))
        throw new Exception("socket_bind() failed");

    //监听
    if(!socket_listen($socket, 4))
        throw new Exception("socket_listen() failed");

    //绑定监听之后就等待着另一个socket
    $msgsock = socket_accept($socket);
    if (!$msgsock)
        throw new Exception("socket_accept() failed");

    //发送消息到客户端
    $msg = 'socket_accept.This is server.php  --'.date('Y-m-d H:i:s');
    if(!socket_write($msgsock, $msg, strlen($msg)))
        throw new Exception("socket_write() failed");

    //从客户端接收信息
    $buf = socket_read($msgsock, 4*1024); // 获得客户端的输入


    echo "server-buf-get:[$buf]".PHP_EOL;

    socket_close($socket);//工作完毕，关闭套接流

} catch (Exception $e) {
    var_dump($e);
    socket_close($socket);//工作完毕，关闭套接流
}
