<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-9-27
 * Time: 11:29
 */


function selection(array & $ar, $len = null)
{
    if ($len === null) {
        $len = sizeof($ar);
    }

    for ($i = 0; $i < $len - 1; $i++) {
        $min = $i; //consider i as min_index

        for ($j = $i + 1; $j < $len; $j++) {//find min_index
            if($ar[$j]<$ar[$min]){
                $min = $j;
            }
        }
        //check min_index and swap
        if($min!=$i){//change
            $t = $ar[$i];
            $ar[$i]=$ar[$min];
            $ar[$min] = $t;
        }
    }
}

