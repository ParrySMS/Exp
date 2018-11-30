<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-9-27
 * Time: 11:29
 */

$ar = [5, 8, 6, 4, 12, 5, 3, 1, 89, 54];

echo "input: <br/>";
print_r(json_encode($ar));
echo "<br/>";

selection($ar);

echo "result: <br/>";
print_r(json_encode($ar));
echo "<br/>";

/** 优化的选择排序
 * @param array $ar
 * @param null $len
 */
function selection(array & $ar, $len = null)
{
    if ($len === null) {
        $len = sizeof($ar);
    }


    for ($left = 0, $right = $len - 1; $left < $right; $left++, $right--) {
        $min = $left; //consider left as min_index and max_index
        $max = $right;

        for ($j = $left + 1; $j <= $right; $j++) {//find min_index max_index

            if ($ar[$j] <= $ar[$min]) {
                $min = $j;
            }

            if ($ar[$j] >= $ar[$max]) {
                $max = $j;
            }

        }
        //check min_index and swap
        if ($min != $left) {
            $t = $ar[$left];
            $ar[$left] = $ar[$min];
            $ar[$min] = $t;
        }

        if ($max != $right) {
            $t = $ar[$right];
            $ar[$right] = $ar[$max];
            $ar[$max] = $t;
        }


        echo "after 1 times: <br/>";
        print_r(json_encode($ar));
        echo "<br/>";
    }

}

