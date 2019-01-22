<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-1-23
 * Time: 0:15
 *
 * 对于任意大于1的自然数n，若n为奇数，则将n变为3n+1，否则变为n的一半。
 * 经过若干次这样的变化，一定会使n变为1
 * 输入n，输出变化的次数。已知n<10^9
 * 样例输入：3
 * 样例输出：7
 *
 */

//对于未知循环次数的情况 常用while循环



function funcWhile(int $num):int
{
    $count = 0;
    while ($num>1) {
        $count++;

        if ($num % 2 == 1) {
            $num = 3 * $num + 1;
        } else {
            $num = $num / 2;
        }
    }

    return $count;
}



function funcFor(int $num):int
{

    for($count = 0;$num>1;$count++) {

        if ($num % 2 == 1) {
            $num = 3 * $num + 1;
        } else {
            $num = $num / 2;
        }
    }
    return $count;
}

fscanf(STDIN, "%d", $num);
echo funcFor($num);


/**
 *   init
 *   while(cond){
 *      processing
 *      adjust cond-var
 *   }
 *
 *   for(init;cond;adjust){
 *      processing
 *   }
 *
 *
 *   1
 *   while(2 judge 4){
 *       3
 *   }
 *
 *   for(1; 2 judge 4;3.2){
 *      3.1
 *   }
 *
 *
 */