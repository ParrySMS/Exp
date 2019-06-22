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
    if (!socket_connect($socket, LOCAL_IP, PORT))
        throw new Exception("socket_connect() failed");

    echo'---start---'.PHP_EOL;

    //发送消息到服务端
    $msg_out = 'This is client.php  --' . date('Y-m-d H:i:s');
    if (!socket_write($socket, $msg_out, strlen($msg_out)))
        throw new Exception("socket_write() failed");

    // 获得连接成功的响应
    $buf = socket_read($socket,  1024);
    echo $buf;

    //回复指令
    $cmd = fopen("php://stdin", "r"); //打开命令行的输入文件流 用于读入输入的参数
    $op = fgets($cmd);
    $op = str_replace(PHP_EOL, '', $op);

    if (!socket_write($socket, $op, strlen($op)))
        throw new Exception("socket_write() failed");

    switch ($op) {
        case 'y':
        case 'Y':
            echo 'Please input new file name:';
            $new_file_name = fgets($cmd);
            $new_file_name = str_replace(PHP_EOL, '', $new_file_name);
            fileSave($socket,$new_file_name);
            break;

        case 'n':
        case 'N':
            $msg_out = 'refuse to download'.PHP_EOL;
            echo $msg_out;
    }


    fclose($cmd);//关闭命令行的输入流
    socket_close($socket);//工作完毕，关闭套接流

} catch (Exception $e) {
    echo $e->getMessage();
    fclose($cmd);//关闭命令行的输入流
    socket_close($socket);//工作完毕，关闭套接流
}

/**
 * @param $socket
 * @param $new_file_name
 * @throws Exception
 */
function fileSave(& $socket,$new_file_name){
    //获取服务端数据
    echo 'loading....'.PHP_EOL;
    $buf = socket_read($socket, 10*1024);

    echo 'saving....'.PHP_EOL;
    //保存文件
    $new_file = fopen($new_file_name, "w");
    if(!$new_file)
        throw new Exception("Unable to open file:$new_file_name");

    fwrite($new_file, $buf);
    fclose($new_file);
}