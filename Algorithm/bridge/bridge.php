<?php

require 'Queue.php';
require 'Map.php';

define('MAX', 400);

//$cmd=fopen("php://stdin", "r");//打开命令行的输入文件流 用于读入输入的参数
//$t = fgets($cmd);//获取输入的参数

//while($t--) {

//点数 边数
$n = rand(50, MAX);
$e = rand(3, 3 * $n);


echo "remove:".PHP_EOL;
$start_time = microtime(true);
//removeEdge();
echo "cutCir:".PHP_EOL;
//cutCircle();




//}