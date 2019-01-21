<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-1-22
 * Time: 0:02
 *
 * 从小到大排序3个整数
 *
 * 输入 2 53 1
 * 输出 1 2 53
 *
 */




fscanf(STDIN, "%d %d %d", $a,$b,$c);
f4($a,$b,$c);


function f1(int $a, int $b, int $c): void
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

function f2(int $a, int $b, int $c): void
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

function f3(int $a, int $b, int $c): void
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

function f4(int $a, int $b, int $c): void
{//use  (cond)? T: F
    $min = $a > $b ? $b : $a;
    $max = $a > $b ? $a : $b;

    $min = $c < $min ? $c : $min;
    $max = $c > $max ? $c : $max;

    $mid = $a + $b + $c - $min - $max;

    echo $min . ' ' . $mid . ' ' . $max;
}
