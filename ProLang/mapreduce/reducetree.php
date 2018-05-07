<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-5-8
 * Time: 1:20
 */


$a = [1, 2];
$b = [5, 6];
$c = [$a, 3];
$d = [4, $b];
$data = [$c, $d];
/**
 *        data
 *         |
 *     c ----- d
 *     |       |
 *   a---3   4---b
 *   |           |
 * 1---2       5---6
 *
 */
$res = reducetree($data,function ($num1,$num2){
    return $num1*$num2;
});

echo $res;




function reducetree(array $ar, callable $func)
{
    if (sizeof($ar) <= 1) {
        return null;
    }

    if (is_array($ar[0])) {//判断节点 初值递归调用解决左子树
        $ar[0] = reducetree($ar[0], $func);
    }
    $res = $ar[0];
    //多个迭代套用
    foreach ($ar as $key => $a) {
        if ($key != 0) {
            if (is_array($a)) {//判断节点 递归调用解决右边子树
                $a = reducetree($a, $func);
            }
            $res = $func($res, $a);
        }
    }
    return $res;
}


