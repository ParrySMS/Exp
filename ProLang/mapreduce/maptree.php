<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-5-8
 * Time: 0:57
 */
//n叉树 最左为0 最右为n-1

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
$res = maptree($data,function ($num){
    return $num+10;
});

echo "data:<br/>";
print_r($data);
echo "<br/>";
echo "res:<br/>";
print_r($res);



function maptree(array $ar, callable $func)
{
    unset($out);
    $out = array();
    //遍历进行函数使用
    foreach ($ar as $a) {
        if (is_array($a)) {//如果是节点则递归
            $a = maptree($a, $func);
            $out[] = $a;

        } else {
            $out[] = $func($a);
        }
    }
    return $out;
}
