<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-5-7
 * Time: 15:52
 */
require "./mapreduce.php";

$a = [1, 2, 3];
$b = [4, 5, 'ww', 7];
$c = [8];
$data = [$a, $b, $c, 'ss', 10];

//将元素变成数组
$mapAr = map($data, function ($ar) {
    if (!is_array($ar)) {
        $ar1 = [$ar];
        return $ar1;
    } else {
        return $ar;
    }
});

//两两将数组合并
$res = reduce($mapAr, function ($ar1, $ar2) {
    return array_merge($ar1, $ar2);
});

echo "data:<br/>";
print_r($data);
echo "<br/>";
echo "res:<br/>";
print_r($res);
