<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-5-7
 * Time: 15:08
 */

/**
 * 备注： php有自己原生的函数 array_map() 和 array_reduce()
 */

function map(array $ar,callable $func )
{
    unset($out);
    $out = array();
    //遍历进行函数使用
    foreach ($ar as $a) {
        $out[] = $func($a);
    }
    return $out;
}


function reduce(array $ar, callable $func)
{
    if (sizeof($ar) <= 1) {
        return null;
    }
    if (sizeof($ar) == 2) {
        return $func($ar[0], $ar[1]);
    }
    $res = $ar[0];
    //多个迭代套用
    foreach ($ar as $key => $a) {
        if ($key != 0) {
            $res = $func($res, $a);
        }
    }
    return $res;
}