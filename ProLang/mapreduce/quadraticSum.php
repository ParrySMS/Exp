<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-5-7
 * Time: 15:04
 */

require "./mapreduce.php";


$data = [1, 2, 3, 4];

$mapAr = map($data, function ($num, $index = 2) {
    return pow($num, $index);
});

$res = reduce($mapAr, function ($num1, $num2) {
    return $num1 + $num2;
});

echo $res;