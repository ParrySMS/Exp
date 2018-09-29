<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-9-27
 * Time: 13:50
 */

$ar = [5,8,6,4,12,5,3,1,89,54];
print_r(json_encode($ar));
echo "<br/>";

bubble($ar);
print_r(json_encode($ar));
echo "<br/>";


/** 冒泡排序
 * @param array $ar
 * @param null $len
 */
function bubble(array & $ar, $len = null)
{
    if ($len === null) {
        $len = sizeof($ar);
    }

    for ($i = 0; $i < $len-1; $i++) {
        for ($j = 0; $j < $len-$i-1; $j++) {

            if ($ar[$j] > $ar[$j+1]) {//swap
                echo "swap [$j]--[";
                echo $j+1;
                echo ']';

                echo "<br/>";

                $t = $ar[$j];
                $ar[$j] = $ar[$j+1];
                $ar[$j+1] = $t;
            }

        }
        print_r(json_encode($ar));
        echo "<br/>";

    }

}