<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-6-22
 * Time: 12:56
 */

set_time_limit(0);//无限时间运行
define("PORT", 8888);
define("LOCAL_IP", "127.0.0.1");

define("FILE_NAME", "local.php");
define("PATH", __DIR__ . '\\');

$path_file = PATH . FILE_NAME;
try {

    //创建socket
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if (!$socket)
        throw new Exception("socket_create() failed");

    //绑定
    if (!socket_bind($socket, LOCAL_IP, PORT))
        throw new Exception("socket_bind() failed");

    //监听
    if (!socket_listen($socket, 4))
        throw new Exception("socket_listen() failed");

    //绑定监听之后就等待着另一个socket
    $msgsock = socket_accept($socket);
    if (!$msgsock)
        throw new Exception("socket_accept() failed");

    echo'---start---'.PHP_EOL;

    //连接成功之后 接收客户端消息
    $msg_in = socket_read($msgsock, 1024);
    echo $msg_in;

    //  发送文件名到客户端
    $msg = 'server: ' . FILE_NAME . ' --' . date('Y-m-d H:i:s') . PHP_EOL;
    $msg .= 'Are you need to download? (y/n)';

    if (!socket_write($msgsock, $msg, strlen($msg)))
        throw new Exception("socket_write() failed");

    //接收客户信息
    $msg_in = socket_read($msgsock, 1024); // 获得客户端的输入
    $msg_in = str_replace(PHP_EOL, '', $msg_in);

    switch ($msg_in) {
        case 'y':
        case 'Y':
            fileTran($msgsock,$path_file);
            break;

        case 'n':
        case 'N':
            $msg = 'refuse to download' . FILE_NAME;
            if (!socket_write($msgsock, $msg, strlen($msg)))
                throw new Exception("socket_write() failed");
    }


    socket_close($socket);//工作完毕，关闭套接流

} catch (Exception $e) {
    echo $e->getMessage();
    socket_close($socket);//工作完毕，关闭套接流
}

/**
 * @param & $msgsock
 * @param $path_file
 * @throws Exception
 */
function fileTran(& $msgsock, $path_file)
{

    //确认文件存在
    if (!file_exists($path_file)) {
        throw new Exception("$path_file NOT FOUND");
    }

    //只读模式 二进制流 传输
    $handle = fopen($path_file, 'rb');
    $contents = fread($handle, filesize(FILE_NAME));//读取文件
    if (!socket_write($msgsock, $contents, strlen($contents)))
        throw new Exception("socket_write() failed");


}