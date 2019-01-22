<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-1-22
 * Time: 18:43
 *
 * 输出所有形如aabb的四位完全平方数（即前两位数字相等，后两位数字也相等）
 *
 *
 */

function f1(): void
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

function f2(): void
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

function f3(): void
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

function f4(): void
{
    for ($root = 1; ; $root++) {
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

f4();

