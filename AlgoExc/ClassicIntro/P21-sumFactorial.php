<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-1-23
 * Time: 21:19
 *
 * 输入n, 计算 S = 1! + 2! + ... n! 的末六位（不含前导0）。
 * n < 10^6
 * n! 表示阶乘， 是前n个正整数之积
 * 样例输入：10
 * 样例输出：37913
 *
 */

define('MOD',1000000);


//fscanf(STDIN, "%d", $num);

//time
for($num = 10;$num<10000;$num*=2) {
    echo PHP_EOL."num: $num:".PHP_EOL;

    $start_time = microtime(true);
    echo f4($num);
    $end_time = microtime(true);

    $time = 1000 * ($end_time - $start_time);
    echo PHP_EOL . "time:$time ms" . PHP_EOL;


}

/** with bug  eg: input 100
 * @param int $n
 * @return int
 */
function f1 (int $n):int
{
    for($fnum = 1,$sum = 0;$fnum<=$n;$fnum++){
        for($multi_num = 1,$fa_res = 1;$multi_num<=$fnum;$multi_num++){
            $fa_res *= $multi_num;// 计算 fnum!
        }

        $sum += $fa_res; // 求和 重复到n
//        echo $fnum."! = ".$fa_res.PHP_EOL;
//        echo $sum.PHP_EOL;

    }

    return $sum%1000000;

}


/** 提前取mod
 * @param int $n
 * @return int
 */
function f2 (int $n):int
{
    for($fnum = 1,$sum = 0;$fnum<=$n;$fnum++) {
        for ($multi_num = 1, $fa_res = 1; $multi_num <= $fnum; $multi_num++) {
            $fa_res = ($fa_res * $multi_num) % MOD;// 计算 fnum!
        }

        $sum = ($sum + $fa_res) % MOD; // 求和 重复到n
//        echo $fnum . '! mod = ' . $fa_res . PHP_EOL;
//        echo 'sum-mod:'.$sum . PHP_EOL;

    }
    return $sum;

}


/** 改进大数情况
 * @param int $n
 * @return int
 */
function f3 (int $n):int
{
    if($n>25) $n =25;//发现的规律

    for($fnum = 1,$sum = 0;$fnum<=$n;$fnum++) {
        for ($multi_num = 1, $fa_res = 1; $multi_num <= $fnum; $multi_num++) {
            $fa_res = ($fa_res * $multi_num) % MOD;// 计算 fnum!
        }

        $sum = ($sum + $fa_res) % MOD; // 求和 重复到n
//        echo $fnum . '! mod = ' . $fa_res . PHP_EOL;
//        echo 'sum-mod:'.$sum . PHP_EOL;

    }
    return $sum;

}

/** 改进大数 保存中途结果减少循环
 * @param int $n
 * @return int
 */
function f4 (int $n):int
{
    if($n>25) $n =25;//发现的规律

    $fa_res = [];
    $fa_res[] = 1;

    for($fnum = 1,$sum = 0;$fnum<=$n;$fnum++) {

        if (empty($fa_res[$fnum])){
            $fa_res[$fnum] = ($fnum * $fa_res[$fnum-1])%MOD; // 利用上一次的保存结果
        }

        $sum = ($sum + $fa_res[$fnum]) % MOD; // 求和 重复到n
    }

    return $sum;

}






