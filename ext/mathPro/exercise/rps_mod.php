<?php


$cmd=fopen("php://stdin", "r");//打开命令行的输入文件流 用于读入输入的参数

//fscanf(STDIN,"%d %d",$a,$b); 此代码表示，按照指定格式 整数 空格 整数 读取两个整数变量到a和b里，不再需要用fget逐行读取

echo 'A player:'.PHP_EOL; //输出字符串 并且换行
echo '1 mean rock, 2 mean paper, 3 mean scissors'.PHP_EOL;
$a = fgets($cmd);//获取A输入的参数

echo 'B player:'.PHP_EOL; // 输出字符串并且换行
echo '1 mean rock, 2 mean paper, 3 mean scissors'.PHP_EOL;
$b = fgets($cmd);//获取B输入的参数
$b = -1*$b; //取反

echo "A is $a and B is $b".PHP_EOL;

if($a + $b == 0){
	echo 'draw';
}else if($a%3 + $b== -1){
	echo 'A win';
}else{
	echo 'B win';
}

echo PHP_EOL.'Game Over'.PHP_EOL;

fclose($cmd);//关闭命令行的输入流 

//结束
