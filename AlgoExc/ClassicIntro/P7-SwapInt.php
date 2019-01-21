<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-1-21
 * Time: 23:24
 *
 * 输入两个整数 a 和 b
 * 交换两者的值
 * 然后输出
 *
 * 样例输入 824 16
 * 样例输出 16 824
 *
 *
 */

fscanf(STDIN,"%d %d",$a,$b);

$func1 = function (int $a, int $b){
    $t = $a;
    $a = $b;
    $b = $t;

    echo $a.' '.$b;
};

$func2 = function (int $a, int $b){ //without more temp var
    $a = $a+$b; //a = sum
    $b = $a-$b; // newb <- sum-b = a
    $a = $a-$b; // a <- sum-newb = sum-a = b

    echo $a.' '.$b;
};


$func3 = function (int $a, int $b){// best one
    echo $b.' '.$a;
};

//exc
$func3($a,$b);