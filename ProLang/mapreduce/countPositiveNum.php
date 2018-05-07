<?php

require "./mapreduce.php";


$data = [1, 2, 3, -4, 4, 2, -5];

//用0 1来标记是否为正数
$mapAr = map($data, function ($num) {
    return $num > 0 ? 1 : 0;
});

//把0 1的数组相加
$res = reduce($mapAr, function ($num1, $num2) {
    return $num1 + $num2;
});

echo $res;