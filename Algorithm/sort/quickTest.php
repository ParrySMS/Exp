<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-9-28
 * Time: 22:12
 */

set_time_limit(0);

require "./Sort.php";

try {
    //$func = ['bubble', 'insert', 'merge', 'quick', 'selection'];

    testForGraph(['quick'],10100,50000,100);


}catch(Exception $e){
    echo $e->getMessage();
    echo PHP_EOL;
}
/** 获取长度为len的随机数字数组
 * @param $len
 * @return array
 */
function getArray($len)
{
    for ($i = 0; $i < $len; $i++) {
        $ar[] = rand();

    }
    echo "create an array[$len]";
    echo PHP_EOL;
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

    foreach ($func as $funcname) {
//        echo "<br/>";
        echo PHP_EOL;
        echo "sort function: $funcname ( )";
        echo PHP_EOL;
        echo "array's len: $len, sample:$sample_num";
        echo PHP_EOL;
//        echo "<br/>";

        $sum_exc_time = 0;
        for ($num = 0; $num < $sample_num; $num++) {

            unset($ar);
            $ar = getArray($len);

            $start_time = microtime(true);
            $sort->$funcname($ar);
            $end_time = microtime(true);

            $exc_time = $end_time - $start_time;
            echo " $exc_time s ";
            echo PHP_EOL;
            $sum_exc_time += $exc_time;

        }

        $avg = $sum_exc_time / $sample_num;
//        echo "<br/>";
        echo PHP_EOL;
        echo "avg:$avg s";
//        echo "<br/>";
        echo PHP_EOL;


    }

}


/** 分别对指定规模与步长遍历记录执行时间
 * @param $func
 * @param $start
 * @param $end
 * @param $step
 * @throws Exception
 */
function testForGraph($func,$start,$end,$step)
{

//遍历每一种方法
    foreach ($func as $funcname) {

        $sort = new Sort();

        echo "sort function: $funcname ( )";
        echo PHP_EOL;

        for ($len = $start; $len <= $end; $len = $len + $step) {
            excSort($funcname, $len,$sort);
        }


    }
    echo "finish all";
    echo PHP_EOL;
}


/** 以某个函数funcname 对规模为len的数组进行样本测试
 * @param $funcname
 * @param $len
 * @param int $sample_num
 * @throws Exception
 */
function excSort($funcname, $len, Sort $sort,$sample_num = 20){

    //每个规模-每次20个样本
    $sum_exc_time = 0;
    for ($num = 0; $num < $sample_num; $num++) {
        unset($ar);
        $ar = getArray($len);//生成随机数数组

        $start_time = microtime(true);

        $sort->$funcname($ar);

        $end_time = microtime(true);

        $exc_time = $end_time - $start_time;
        $sum_exc_time += $exc_time;
        $sort->exc_log($funcname,$len,$num,$exc_time);
    }
    $avg = $sum_exc_time / $sample_num;

    $sort->exc_log($funcname,$len,'avg',$avg);
}