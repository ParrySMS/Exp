<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-9-27
 * Time: 15:33
 */


$ar = [5, 8, 6, 4, 12, 5, 3, 1, 89, 54];
echo "input: <br/>";
print_r(json_encode($ar));
echo "<br/>";
echo "<br/>";
$ar = merge($ar);
echo "result: <br/>";
print_r(json_encode($ar));
echo "<br/>";
echo "<br/>";

/** 归并排序 先拆左右 在两两合并
 * @param array $ar
 * @param null $len
 * @return array
 */
function merge(array $ar, $len = null)
{
    if ($len === null) {
        $len = sizeof($ar);
    }

    if ($len <= 1) {//len = 1 finish cuting
        return $ar;
    }
    //len>1 --> need sort and merge left and right
    //cut into 2 part -- left and right
    $mid = $mid = intval($len / 2);

    // 0 - mid xxxxx
    $left = array_slice($ar, 0, $mid);
    //  xxxx mid - end
    $right = array_slice($ar, $mid);

    echo "left:";
    print_r(json_encode($left));
    echo " -- right:";
    print_r(json_encode($right));
    echo "<br/>";

    $left = merge($left);//continue cut into 2 part until len = 1
    $right = merge($right);

    //get the smallest sorted unit to merge (len is decided by last function result)
    $merge = [];

    $len_left = sizeof($left);
    $len_right = sizeof($right);

    //init index, i for left ,j for right
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

    echo "  merge:";
    print_r(json_encode($merge));
    echo "<br/>";

    return $merge;

}