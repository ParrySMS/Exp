<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-3
 * Time: 10:51
 */


$cmd=fopen("php://stdin", "r");
//打开命令行的输入文件流 用于读入输入的参数
$socre_ar = [];
$num = 0;

$max = -1;
$min = 101;

$max_index = -1;
$min_index = -1;

while ($num<10) {

    $socre = (int)fgets($cmd);

    if($socre>$max){
        $max = $socre;
        $max_index = $num;
    }

    if($socre<$min){
        $min = $socre;
        $min_index = $num;
    }

    $socre_ar[$num] = $socre;

    $num++;
}


//var_dump($socre_ar);

$socre_ar[$max_index] = 0;
$socre_ar[$min_index] = 0;


for($i=0,$sum=0;$i<10;$i++){
    $sum = $sum + $socre_ar[$i];
}


$avg = $sum/8;

echo PHP_EOL.$avg.PHP_EOL;
//$socre_ar = array();


fclose($cmd);
//关闭命令行的输入流
