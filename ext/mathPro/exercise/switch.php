<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-2
 * Time: 14:25
 */
require './game1.php';
require './game2.php';


$cmd=fopen("php://stdin", "r");//打开命令行的输入文件流 用于读入输入的参数

echo 'choose menu: 1 --> rps, 2 -->numgame, e of q  -->exit';

$menu_var = (string)fgets($cmd);



switch($menu_var){

    case 'q':
    case 'e':
        echo PHP_EOL.'exit'.PHP_EOL;
        break;

    case 1:
    case '1':
        rps($cmd);
        break;

    case 2:
    case '2':
        numgame($cmd);
        break;


}

fclose($cmd);//关闭命令行的输入流

