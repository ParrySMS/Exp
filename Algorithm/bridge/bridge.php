<?php

require 'Queue.php';
require 'Map.php';
require 'CloseEdge.php';
require 'UFSet.php';

define('MAX', 10);

//$cmd=fopen("php://stdin", "r");//打开命令行的输入文件流 用于读入输入的参数
//$t = fgets($cmd);//获取输入的参数

//while($t--) {

//点数 边数
$n = rand(4, MAX);
$e = rand(3, 3 * $n);
$map = new Map($n, $e);

try {

    while(1) {
        $start_time = microtime(true);
        $num1 = $map->removeEdge();
        $end_time = microtime(true);
        $time1 = 1000*($end_time - $start_time);
        $mx1 = $map->mx;

        $start_time = microtime(true);
        $num2 = $map->markCircleEdge();
        $end_time = microtime(true);
        $time2 = 1000*($end_time - $start_time);
        $mx2 = $map->mx;

        $map->mx = $mx1;
        $map->try = true;
        $start_time = microtime(true);
        $num3 = $map->markCircleEdge();
        $end_time = microtime(true);
        $time3 = 1000*($end_time - $start_time);
        $mx3 = $map->mx;

        if($time1 <=> $time2 && $time1 <=>$time3){

            echo PHP_EOL . "removeEdge:" . PHP_EOL;
            echo "num: $num1 " . PHP_EOL;
            echo "time: $time1 ms" . PHP_EOL;
            $map->mx = $mx1;
            $map->echoMx();

            echo PHP_EOL . "markCircleEdge:" . PHP_EOL;
            echo "num: $num2 " . PHP_EOL;
            echo "time: $time2 ms" . PHP_EOL;
            $map->mx = $mx2;
            $map->echoMx();

            echo PHP_EOL . "markCircleEdge--add:" . PHP_EOL;
            echo "num: $num3 " . PHP_EOL;
            echo "time: $time3 ms" . PHP_EOL;
            $map->mx = $mx3;
            $map->echoMx();

            break;
        }
    }

}catch(Exception $e){
    echo $e->getCode().': '.$e->getMessage().PHP_EOL;
}
//echo "cutCir:".PHP_EOL;
//cutCircle();




//}