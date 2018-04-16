<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-4-14
 * Time: 13:27
 */


/** 迭代法
 * @param array $ar
 * @return array
 */
function quickSortI(array $ar)
{
    $stack = array($ar);
    $sort = array();
    //判断数组长度
    $size = sizeof($ar);
    if ($size <= 1) {
        return $ar;
    }
    //栈空即跳出循环
    while ($stack) {
        $arr = array_pop($stack);
        if (count($arr) <= 1) {
            if (count($arr) == 1) {
                $sort[] = &$arr[0];
            }
            continue;
        }
        $key = $arr[0];
        $high = array();
        $low = array();
        //用两个数组分别接受比游标key小和比key大的数据
        $_size = count($arr);
        for ($i = 1; $i < $_size; $i++) {
            if ($arr[$i] <= $key) {
                $high[] = &$arr[$i];
            } else {
                $low[] = &$arr[$i];
            }
        }
        if (!empty($low)) {//数据入站
            array_push($stack, $low);
        }
        array_push($stack, array($arr[0]));
        if (!empty($high)) {
            array_push($stack, $high);
        }
    }
    return $sort;
}