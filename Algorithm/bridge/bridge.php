<?php

require 'Queue.php';
require 'Map.php';

define('MAX', 100);

//$cmd=fopen("php://stdin", "r");//打开命令行的输入文件流 用于读入输入的参数
//$t = fgets($cmd);//获取输入的参数

//while($t--) {

//点数 边数
$n = rand(4, MAX);
$e = rand(3, 3 * $n);

$map = new Map($n,$e);

echo "remove:".PHP_EOL;
$start_time = microtime(true);
$map->removeEdge();
$end_time = microtime(true);
$time =$end_time - $start_time;
echo "time: $time ms";

//echo "cutCir:".PHP_EOL;
//cutCircle();




//}