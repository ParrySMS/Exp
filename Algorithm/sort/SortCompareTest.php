<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-9-28
 * Time: 22:12
 */

require "./Medoo/Medoo.php";
require "./Medoo/database_info.php";
require "Node.php";
require "SingleLInkList.php";
require "Sort.php";

$sort = new Sort();

$func = ['bubble','insert','merge','quick','selection'];

//遍历每一种方法
foreach ($func as $funcname) {
//小规模 10-1000 每次增加10
    for ($len = 10; $len < 1000; $len = $len + 10) {

        //每次50个样本
        for ($size = 0; $size < 50; $size++) {

            $ar = getArray($len);

            $start_time = microtime(true);

            $sort->$funcname($ar);

            $end_time = microtime(true);

            $exc_time = $end_time - $start_time;

            //todo  log(func,size,time,len)
        }
    }

    //todo 中规模
    for ($len = 1000; $len < 10000; $len = $len + 100) {

    }

    //todo 大规模
    for ($len = 10000; $len < 100000; $len = $len + 10000) {

    }

}


function getArray($len)
{
    $ar = [];
    for ($i = 0; $i < $len; $i++) {
        $ar[] = rand();
    }
    return $ar;
}