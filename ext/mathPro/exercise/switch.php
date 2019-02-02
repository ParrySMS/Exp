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

echo 'choose menu: 1 --> rps, 2 --> numgame, e of q --> exit'.PHP_EOL;

$menu_var = fgets($cmd); //fgets 是读取一整行内容 连换行符都会读进去
//可以用更好的fscanf替代
//例如 fscanf(STDIN,"%d %d",$a,$b); //此代码表示，按照指定格式 整数 空格 整数 读取两个整数变量到a和b里，不再需要用fget逐行读取


//字符替代 找到字符串里的换行符并且 用空'' 替代 换行符号
$menu_var = str_replace(PHP_EOL,'',$menu_var);

//var_dump($menu_var);

switch($menu_var){

    case 'q'.PHP_EOL:
    case 'e'.PHP_EOL:
    case 'e':
    case 'q':

        echo PHP_EOL.'exit'.PHP_EOL;
        break;

    case 1:
        rps($cmd);
        break;

    case 2:
        numgame($cmd);
        break;


}

fclose($cmd);//关闭命令行的输入流

