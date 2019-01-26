<?php
//题目内容 参见 P15E1.5.6-Exc10.jpg



/**
 * 输入三个整数 输出他们的平均值 保留3位小数
 * @param  int $x
 * @param  int $y
 * @param  int $z
 * @return [float]
 */
function average(int $x, int $y, int $z): float
{
    $num = ($x + $y + $z) / 3.0;


    return round($num, 3); //法1
    // return number_format($num, 3); //法 2
    // return sprintf("%.3f",$num);  //法3
}

/** 华氏度转摄氏度
 * @param int $f
 * @return float
 */
function temperature(int $f): float
{
    $c = 5 * ($f - 32) / 9.0;

    return round($c, 3); //法1
    // return number_format$$c, 3); //法 2
    // return sprintf("%.3f",$c);  //法3
}


/** 求 1 到 n 的和
 * @param int $n
 * @return int
 */
function sumN(int $n): int
{
    return (1 + $n) * $n / 2; //求和公式
}


/** 求三角函数
 * @param int $angle
 * @param bool $return_array 是否返回布尔值
 * @return mixed
 */
function sincos(int $angle, bool $return_array = false)
{
    $sin = sin($angle);
    $cos = cos($angle);

    echo "sin:$sin" . PHP_EOL;
    echo "cos:$cos" . PHP_EOL;

    if ($return_array) {
        return [$sin, $cos];
    }
}


/** 两点之间距离
 * @param float $x1
 * @param float $y1
 * @param float $x2
 * @param float $y2
 * @return float
 */
function distance(float $x1, float $y1, float $x2, float $y2): float
{
    return sqrt(pow($x1 - $x2, 2) + pow($y1 - $y2, 2));
}


/** 取余法判断奇偶
 * @param int $num
 * @param bool $return_bool
 * @return mixed
 */
function odd1(int $num, bool $return_bool = false)
{
    $res = $num % 2 == 0 ? 'yes' : 'no';

    echo $res . PHP_EOL;

    if ($return_bool) {
        return $num % 2 == 0;
    }

}


/** 末位字符判断法 判断奇偶
 * @param int $num
 * @param bool $return_bool 是否返回布尔值
 * @return bool
 */
function odd2(int $num, bool $return_bool = false)
{
    $last_num = substr((string)$num, -1);

    switch ($last_num) {
        case '1':
        case '3':
        case '5':
        case '7':
        case '9':
            echo 'no' . PHP_EOL;
            if ($return_bool) {
                return true;
            }
            break;

        case '0':
        case '2':
        case '4':
        case '6':
        case '8':
            echo 'yes' . PHP_EOL;
            if ($return_bool) {
                return false;
            }
            break;
    }

}


/** 折扣计算
 * 用可变参数的方式，便于灵活调整函数情况（或者也可以用常量的方法来处理）
 * @param int $num 购买数量
 * @param float $price_per_unit 单位价格
 * @param float $price_get_discount 打折的价格线（超过即打折）
 * @param float $discount 打折系数
 * @param int prec 小数保留位数
 * @return float
 */
function discount(int $num, float $price_per_unit = 95, float $price_get_discount = 300, float $discount = 0.85, int $prec = 2): float
{
    $sum = $num * $price_per_unit;

    return $sum < $price_get_discount ? round($sum, $prec) : round($discount * $sum, $prec);

}

/** 求绝对值
 * @param float $num
 * @return float
 */
function absNum(float $num): float
{
    return $num < 0 ? -1 * round($num, 2) : round($num, 2);
}

/** 交换顺序使得按照 a<b<c 排序
 * 先找斜边--最长边c
 * 然后 勾股定理
 * @param int $a
 * @param int $b
 * @param int $c
 */
function triangle1(int $a, int $b, int $c): void
{

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

    //勾股定理- 毕达哥拉斯定理
    if ($a * $a + $b * $b == $c * $c) {
        echo 'yes' . PHP_EOL;

    } else {
        echo 'no' . PHP_EOL;
    }

}

/** 条件判断 用min mid max 排序
 * 先找斜边--最长边max
 * 然后 勾股定理
 * @param int $a
 * @param int $b
 * @param int $c
 */
function triangle2(int $a, int $b, int $c): void
{
    $min = $a > $b ? $b : $a;
    $max = $a > $b ? $a : $b;

    $min = $c < $min ? $c : $min;
    $max = $c > $max ? $c : $max;

    $mid = $a + $b + $c - $min - $max;

    $res = $min * $min + $mid * $mid == $max * $max ? 'yes' : 'no';

    echo $res.PHP_EOL;
}


/** 闰年条件
 * 能被4整除而不能被100整除
 * 或 能被400整除
 *
 * && 与的优先级高
 *
 * @param int $year
 */
function year1(int $year):void
{
    //可读性不好
    $res = $year%4==0 && $year%100!=0 || $year%400 == 0 ? 'yes':'no';
    echo $res.PHP_EOL;

}

/**
 * @param int $year
 */
function year2(int $year):void
{
    $res = 'no'; //先假设一个值

    //列出不满足假设的情况 修改假设

    if( $year%4==0 && $year%100!=0 ){
        $res = 'yes';

    }else if($year%400 == 0){
        $res = 'yes';
    }

    echo $res.PHP_EOL;
}

