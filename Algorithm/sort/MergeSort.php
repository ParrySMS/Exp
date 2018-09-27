<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-9-27
 * Time: 15:33
 */


$ar = [5, 8, 6, 4, 12, 5, 3, 1, 89, 54];
$ar = merge($ar);
print_r($ar);

function merge(array $ar, $len = null)
{
    if ($len === null) {
        $len = sizeof($ar);
    }

    if ($len <= 1) {//finish
        return $ar;
    }

    //len>1 --> need sort

    //cut into 2 part -- left and right
    $mid = $mid = intval($len / 2);

    // 0 - mid xxxxx
    $left = array_slice($ar, 0, $mid);
    //  xxxx mid - end
    $right = array_slice($ar, $mid);

    $left = merge($left);//continue
    $right = merge($right);

    //smallest sorted unit to merge
    $merge = [];

    $len_left = sizeof($left);
    $len_right = sizeof($right);
    $i = $j = 0;
    //put left and right into merge by sorting
    while (sizeof($merge) < $len_left + $len_right) {

        if ($i < $len_left //still has left
            && ($j == $len_right || $left[$i] <= $right[$j])) { //right is over or left is smaller --> add left into merge
            $merge[] = $left[$i];
            $i++;

        } else if ($j < $len_right //still has right
            && ($i == $len_left || $left[$i] > $right[$j])) {//left is over or right is smaller --> add left into merge
            $merge[] = $right[$j];
            $j++;
        }
    }

    return $merge;

}