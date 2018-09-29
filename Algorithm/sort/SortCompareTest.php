<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-9-28
 * Time: 22:12
 */


require "Sort.php";


$func = ['bubble', 'insert', 'merge', 'quick', 'selection'];

for () //todo
testForAvg($func,100);


/** 获取长度为len的随机数字数组
 * @param $len
 * @return array
 */
function getArray($len)
{
    $ar = [];
    for ($i = 0; $i < $len; $i++) {
        $ar[] = rand();
    }
    return $ar;
}

/** 遍历方法func 对大小为len的数组进行若干次样本测试
 * @param $func
 * @param $len
 * @param int $sample_num
 */
function testForAvg($func, $len, $sample_num = 20)
{
    $sort = new Sort();
    $ar = getArray($len);

    foreach ($func as $funcname) {
        echo "<br/>";
        echo "sort function: $funcname (),array-len: $len, sample_num:$sample_num";
        echo "<br/>";

        $sum_exc_time = 0;
        for ($num = 0; $num < $sample_num; $num++) {

            $start_time = microtime(true);
            $sort->$funcname($ar);
            $end_time = microtime(true);

            $exc_time = $end_time - $start_time;
            echo " $exc_time ms |";
            $sum_exc_time += $exc_time;
        }

        $avg = $sum_exc_time/$sample_num;
        echo "<br/>";
        echo "avg:$avg ms";
        echo "<br/>";

    }

}


function testForGraph($func)
{
    $sort = new Sort();

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
}