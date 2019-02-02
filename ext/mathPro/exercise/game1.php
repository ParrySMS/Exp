<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-2
 * Time: 14:55
 */




function rps($cmd):void
{

    echo 'A player:' . PHP_EOL; //输出字符串 并且换行
    echo '1 mean rock, 2 mean paper, 3 mean scissors' . PHP_EOL;
    $a = (int)fgets($cmd);//获取A输入的参数

    echo 'B player:' . PHP_EOL; // 输出字符串并且换行
    echo '1 mean rock, 2 mean paper, 3 mean scissors' . PHP_EOL;
    $b = (int)fgets($cmd);//获取B输入的参数
    $b = -1 * $b; //取反

    echo "A is $a and B is $b" . PHP_EOL;

    if ($a + $b == 0) {
        echo 'draw';
    } else if ($a % 3 + $b == -1) {
        echo 'A win';
    } else {
        echo 'B win';
    }
    echo PHP_EOL . 'Game Over' . PHP_EOL;

}
