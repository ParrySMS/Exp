<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-4-15
 * Time: 2:07
 */

/** 递归实现
 * @param $id //盘子编号
 * @param $first //起点柱子
 * @param $middle //中介柱子
 * @param $end //终点柱子
 */
function hanRec($id, $first, $middle, $end,$counter)
{
    if ($id == 1) {
        move(1,$first,$end,$counter);
    } else {
        hanRec($id-1,$first,$end,$middle,$counter);
        move($id,$first,$end,$counter);
        $counter++;
        hanRec($id-1,$middle,$first,$end,$counter);
    }
}

function move($id,$from,$to,$counter){
    global $counter;
    $counter++;
   // echo "step: $counter, level $id from $from move to $to, <br/>";
}