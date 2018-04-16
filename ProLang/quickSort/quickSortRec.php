<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-4-13
 * Time: 23:27
 */

/** 递归法快排序
 * @param array $ar
 * @return array
 */


function quickSortR(array $ar){
    //判断数组长度
    $size = sizeof($ar);

    if($size<=1){
        return $ar;
    }

    //用两个数组分别接受比游标key小和比key大的数据
    $left = array();
    $right = array();
    $key = $ar[0];

    for($i =1;$i<$size;$i++){
        if($ar[$i]<=$key){
            $left[] = $ar[$i];
        }else{
            $right[] = $ar[$i];
        }
    }

    //内部再进行排序
    $left = quickSortR($left);
    $right = quickSortR($right);
    //最后合并
    return array_merge($left,array($key),$right);

}