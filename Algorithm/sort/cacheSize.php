<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-1-6
 * Time: 21:33
 */
define('SIZE',1024*1024);
require "./Sort.php";


$s = new Sort();


$ar = [];
for($i=0;$i<4*SIZE;$i++){
    $ar[] = (int)0;
}

try {
    for ($k = 2; $k < SIZE; $k++) {

        $start_time = microtime(true);
		$key = 0;
		for ($i = 0; $i < SIZE; $i ++) {
			$key = ($key + $k-1)%SIZE;
			$ar[$key]++;
		}

        $end_time = microtime(true);
        $time = 1000 * $end_time - 1000*$start_time;
        $s->exc_log('CacheSizePC2', 4 * SIZE, $k, $time);
//        echo "k:$k,time:$time".PHP_EOL;
    }
    echo 'done';
}catch (Exception $e){
    echo $e->getMessage();
}
