<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-6-21
 * Time: 22:56
 */

set_time_limit(0);//无限时间运行
define("PORT", 8888);
define("LOCAL_IP", "127.0.0.1");

//指定对应的服务
$server = 'udp:' . LOCAL_IP . ':' . PORT;
try {
    //创建udp流 服务端
    $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    if (!$socket) {
        throw new Exception("socket_create() failed");
    }
    //创建命令行流 用来读取命令行输入的东西
    $cmd=fopen("php://stdin", "r"); //打开命令行的输入文件流 用于读入输入的参数
    $msg_in = '---start---';
    echo $msg_in;
    while($msg_in!==false) {
        //给服务端发送信息
        $msg_out = fgets($cmd);
        $msg_out .= ' -- '.date("Y-m-d H:i:s ");//加上时间
        if (!socket_sendto($socket, $msg_out, 100, 0, LOCAL_IP, PORT)){
            throw new Exception("socket_sendto() failed");
        }
        //收服务端的信息
        $msg_in = socket_read($socket, 4*1024); // 获得服务端的输入
        //输出聊天信息
        echo 'From Server-- '.LOCAL_IP.PORT.' --'.PHP_EOL;
        echo "Data: $msg_in".PHP_EOL;
    }

    fclose($cmd);//关闭命令行的输入流
    socket_close($socket);//工作完毕，关闭套接流

} catch (Exception $e) {
    echo $e->getMessage();
    fclose($cmd);//关闭命令行的输入流
    socket_close($socket);//工作完毕，关闭套接流
}
