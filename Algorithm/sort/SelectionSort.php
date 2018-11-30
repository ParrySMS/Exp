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

/** 选择排序
 * @param array $ar
 * @param null $len
 */
function selection(array & $ar, $len = null)
{
    if ($len === null) {
        $len = sizeof($ar);
    }

    for ($i = 0; $i < $len - 1; $i++) {
        $min = $i; //consider i as min_index

        for ($j = $i + 1; $j < $len; $j++) {//find min_index
            if($ar[$j]<=$ar[$min]){
                $min = $j;
            }
        }
        //check min_index and swap
        if($min!=$i){//changeSelectionSort.php
            $t = $ar[$i];
            $ar[$i]=$ar[$min];
            $ar[$min] = $t;
        }

        echo "after 1 times: <br/>";
        print_r(json_encode($ar));
        echo "<br/>";
    }
}

