<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-9-27
 * Time: 13:50
 */

$ar = [5,8,6,4,12,5,3,1,89,54];
bubble($ar);
print_r($ar);

/** 冒泡排序
 * @param array $ar
 * @param null $len
 */
function bubble(array & $ar, $len = null)
{
    if ($len === null) {
        $len = sizeof($ar);
    }

    for ($i = 0; $i < $len; $i++) {
        for ($j = $i + 1; $j < $len; $j++) {

            if ($ar[$i] > $ar[$j]) {//swap
                $t = $ar[$i];
                $ar[$i] = $ar[$j];
                $ar[$j] = $t;
            }
        }
    }

}