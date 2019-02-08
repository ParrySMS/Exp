<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-8
 * Time: 20:36
 *
 */

function odd(int $region = 20):void
{
    for($i=1;$i<=$region;$i+=2){
        echo "$i ";
    }
}


function randArrMaxMinAvg(int $size = 10,int $rand_min=0,int $rand_max=99):void
{
    $ar = [];
    $min = null;
    $max = null;
    for($i=0,$sum = 0;$i<$size;$i++){//一个个放进数组

        $num = rand($rand_min,$rand_max);
        $ar[] = $num;

        //表示向数组的尾部增加一个数 默认数字索引
        // 如果数组是空的那就是 ar[0] <-- $num
        // 如果数组是末尾是n，那就是 ar[n+1] <-- $num


        //产生数据之后就更新最值

        if(empty($min)||$num<$min){
            $min = $num;
        }

        if(empty($max)||$num>$max){
            $max = $num;
        }

        //顺手一起统计一下数据和 因为后期求平均数要用
        $sum += $num;

    }//end for

    //循环结束之后 算平均
    $avg = $sum/$size;

    echo "max:$max".PHP_EOL;
    echo "min:$min".PHP_EOL;
    echo "avg:$avg".PHP_EOL;

}

function prime1(int $region = 100):void
{
    for($num = 2;$num<=$region;$num++){//循环全部数字

        for($mod_num =2;$mod_num<$num;$mod_num++){
            //拿2到自己本身的数字取余 如果都是不能除尽 那就是质数
            //一旦有一个能除尽 那就不是
            if($num % $mod_num == 0){//除尽
                break;
            }

        }//end mod for

        if($mod_num == $num){//判断是从break跳出来的 还是结束for循环出来的
            //结束for循环出来的 则没有除尽
            echo "$num ";
        }
    }//end num for
}


/** 性能更好的版本 自己思考为什么
 * @param int $region
 */
function prime2(int $region = 100):void
{
    echo '2 ';

    for($num = 3;$num<=$region;$num+=2){

        for($mod_num = 3;$mod_num<sqrt($num);$mod_num+=2){
            if($num % $mod_num == 0){
                break;
            }

        }//end mod for

        if($mod_num == $num){
            echo "$num ";
        }
    }//end num for
}


function primeAvg(int $region = 200):void
{
    $sum = 2;
    for($num = 3,$size = 0;$num<=$region;$num+=2){

        for($mod_num = 3;$mod_num<sqrt($num);$mod_num+=2){
            if($num % $mod_num == 0){
                break;
            }

        }//end mod for

        if($mod_num == $num){
            $sum +=$num;
            $size++;
        }
    }//end num for

    $avg = $sum/$size;

    echo "avg:$avg";
}

function standardDeviation(array $num,int $size = 6):void
{

    //标准差公式 需要平均数
    if(sizeof($num)==$size){//保证是正常参数

        $max = null;
        $min = null;
        for($i=0,$sum=0;$i<$size;$i++){//遍历数组
            $value = $num[$i];

            //更新最值
            if(empty($max)||$value>$max){
                $max = $value;
                $max_index = $i;
            }

            if(empty($min)||$value<$min){
                $min = $value;
                $min_index = $i;
            }

            //求和
            $sum += $value;
        }

        //去掉最值 用和求平均数和标准差
        $sum = $sum - $max - $min;
        $avg = $sum/($size-2);

        //求方差的分子部分和
        for($i=0,$upper_sum=0;$i<$size;$i++){

            if($i == $max_index || $i == $min_index){
                continue; //跳过
            }

            $upper_sum += pow($num[$i]-$avg,2);
        }

        $deviation = sqrt($upper_sum/($size-2));//标准差

        echo round($deviation,2);

    }
}


/** 简化版本 学会利用系统自带的东西
 *
 * @param array $num
 * @param int $size
 */
function stdDevSimple(array $num,int $size = 6):void
{
    if(sizeof($num)==$size) {//保证是正常参数


//    　sort() 函数用于对数组单元从低到高进行排序。
        sort($num,SORT_NUMERIC);

        //直接删除头尾元素
        unset($num[0]);
        unset($num[$size-1]);

        //删除之后会有索引中断问题 重排一下索引
        $num = array_values($num);

//        求平均  array_sum返回数组中所有值的和
        $avg = array_sum($num)/($size-2);


        if(!empty($num)&&sizeof($num)>0) {//非空数组 为了下面用foreach

            $upper_sum = 0; //方差公式分子和
            foreach ($num as $n) {
                //类似for的遍历 详情自学查询foreach用法
                $upper_sum += pow($n - $avg, 2);
            }

            $deviation = sqrt($upper_sum/($size-2));//标准差

            echo round($deviation,2);

        }
    }

}

/** 交换
 * @param int $a
 * @param int $b
 */
function swapInt(int $a,int $b){
    $t = $a;
    $a = $b;
    $b = $t;

    echo "$a $b";
}

/** 其实可以不交换
 * @param int $a
 * @param int $b
 */
function swapInt2(int $a,int $b){
    echo "$b $a";
}



/*** 从小到大排序3个整数 并输出
 *  下面给出四种做法
 *
 * 所有做法都要看得懂

 * @param int $a
 * @param int $b
 * @param int $c
 */

function sort3Int1(int $a, int $b, int $c): void
{ //order a<<b<<c , sort a first

    if ($a > $b) {
        $t = $a;
        $a = $b;
        $b = $t;
    }

    if ($a > $c) {
        $t = $a;
        $a = $c;
        $c = $t;
    }
    //first make the edge number

    if ($b > $c) {
        $t = $b;
        $b = $c;
        $c = $t;
    }

    echo $a . ' ' . $b . ' ' . $c;
}

function sort3Int2(int $a, int $b, int $c): void
{ //order a<<b<<c , sort c first
    if ($c < $b) {
        $t = $c;
        $c = $b;
        $b = $t;
    }
    if ($c < $a) {
        $t = $c;
        $c = $a;
        $a = $t;
    }
    //first make the edge number

    if ($b > $c) {
        $t = $b;
        $b = $c;
        $c = $t;
    }

    echo $a . ' ' . $b . ' ' . $c;
}

function sort3Int3(int $a, int $b, int $c): void
{
    if ($a > $b) {
        $max = $a;
        $min = $b;
    } else {
        $max = $b;
        $min = $a;
    }

    //c to adjust min and max
    if ($c < $min) {
        $min = $c;
    } else if ($c > $max) {
        $max = $c;
    }

    $mid = $a + $b + $c - $min - $max;

    echo $min . ' ' . $mid . ' ' . $max;

}

function sort3Int4(int $a, int $b, int $c): void
{//use  (cond)? T: F
    $min = $a > $b ? $b : $a;
    $max = $a > $b ? $a : $b;

    $min = $c < $min ? $c : $min;
    $max = $c > $max ? $c : $max;

    $mid = $a + $b + $c - $min - $max;

    echo $min . ' ' . $mid . ' ' . $max;
}


/**
 * aabb 完全平方数 下面给出四种做法
 *
 * 主要是熟悉和练习循环
 * 所有做法都要看得懂
 */
function aabb1(): void
{//先满足aabb  再用开根号来校验完全平方数

    for ($a = 1; $a <= 9; $a++) {
        for ($b = 0; $b <= 9; $b++) {
            $num = $a * 1100 + $b * 11;
            $root = sqrt($num);

            //判断整数  浮点数可能有小数误差
            if (abs(round($root) - $root) < 0.0001) {//is int
                echo $num . PHP_EOL;
            }
        }
    }

}

function aabb2(): void
{
    $root = 32;
    while ($root * $root < 9999) {
        $num = $root * $root;
        $root++;

        $aa = intval($num / 100);
        $bb = $num % 100;

        if (intval($aa / 10) == $aa % 10
            && intval($bb / 10) == $bb % 10) {
            echo $num . PHP_EOL;
        }
    }
}

function aabb3(): void
{//先满足四位完全平方数 再校验aabb
    //32*32=2^10=1024 min四位数, 99*99=100^2-200+1 max四位数
    for ($root = 32; $root < 99; $root++) {
        $num = $root * $root;
        $aa = intval($num / 100);
        $bb = $num % 100;

        if (intval($aa / 10) == $aa % 10
            && intval($bb / 10) == $bb % 10) {
            echo $num . PHP_EOL;
        }
    }

}

function aabb4(): void
{
    for ($root = 1; ; $root++) {//直接进入循环 再跳出
        $num = $root * $root;

        if ($num < 1000) continue;
        if ($num > 9999) break;

        $aa = intval($num / 100);
        $bb = $num % 100;

        if (intval($aa / 10) == $aa % 10
            && intval($bb / 10) == $bb % 10) {
            echo $num . PHP_EOL;
        }
    }
}


/** 计算 S = 1! + 2! + ... n! 的末六位
 *
 * 当数据过大 会发现这个方法可能引起异常 比如输入100
 *
 * @param int $n
 * @return int
 */
function last6Bit1 (int $n):int
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


/** 优化数据过大的情况 提前取mod
 * @param int $n
 * @return int
 */
function last6Bit2 (int $n):int
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


/** 看这个程序之前 先把上面的 last6Bit2 数据求和结果输出来看一下
 *
 * 根据规律 改进大数情况
 * @param int $n
 * @return int
 */
function last6Bit3 (int $n):int
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
function last6Bit4 (int $n):int
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


/**
 *这两题答案另附
 *
 * 10. PPT 4逻辑结构-循环分支 Slide11 Demo-menu
 *
 * 11. 用 try catch throw 的 Exception机制，为游戏菜单的两个游戏添加参数检查功能。
 *
 *
 */


// todo：for bath ---> 12 13 random array
