<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-9-27
 * Time: 16:45
 */


$ar = [34, 5, 5, 555, 5, 4, 14, 5, 88, 89, 54];
print_r(json_encode($ar));

quick($ar);
print_r(json_encode($ar));

/** 快速排序 找基准数 左右分组交换至左小右大
 * @param array $ar
 * @param int $left
 * @param null $right
 */
function quick(array & $ar, $left = 0, $right = null)
{

    //default left = 0 ,right = len-1
    if ($right === null) {
        $right = sizeof($ar) - 1;
    }

    if ($left >= $right) {//not need to sort
        return;
    }

    //mark the default value
    $first_index = $left;
    $last_index = $right;

    $key = $ar[$left];//default key as first element

    while ($left != $right) {//find 2 swap element to sort into 2 parts

        while ($ar[$right] >= $key && $left < $right) { // [l--r] is [small--big]
            $right--;
        }//until a[r] < key

        while ($ar[$left] <= $key && $left < $right) {
            $left++;
        }//until a[l] > key

        if ($left < $right) { //swap
            echo "<br/> swap ar[$left] = $ar[$left] <-->ar[$right] = $ar[$right] <br/>";
            $t = $ar[$left];
            $ar[$left] = $ar[$right];
            $ar[$right] = $t;
        }

    }//finish 2 sorted parts

    //left == right == mid

    if ($first_index != $left) {//first_index == mid_index not need to swap, just len = 1
        echo "put key  ar[$first_index] = $key  <--> ar[$left] =$ar[$left] <br/>";

        //put mid to first(location of key)
        $ar[$first_index] = $ar[$left];
        //put key into mid
        $ar [$left] = $key;
    }
    print_r(json_encode($ar));

    //continue cut and sort
    //left == right == mid
    echo " <br/> cut into:  $first_index ---- | $left |---- $last_index  <br/>";
    quick($ar, $first_index, $left - 1);
    quick($ar, $left + 1, $last_index);

}