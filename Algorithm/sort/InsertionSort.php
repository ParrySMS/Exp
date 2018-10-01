<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-9-27
 * Time: 18:16
 */

require "Node.php";
require "SingleLInkList.php";

$ar = [34, 5, 5, 545, 5, 4, 14, 5, 88, 89, 54,10421,42,545,65,87,231,51,657,216,42];
$ar1 = array_merge($ar,$ar);
$ar2 = array_merge($ar,$ar);
$ar3 = array_merge($ar,$ar);

echo "input: <br/>";
print_r(json_encode($ar));
echo "<br/>";
echo "<br/>";

$start_time = microtime(true);
insertLink($ar1);
$end_time = microtime(true);
$exc_time = $end_time - $start_time;
echo "ar1:<br/>";
echo 1000 * $exc_time;
echo "<br/>";




/** 基于链表实现的插入排序
 * @param array $ar
 * @param null $len
 * @param bool $need_show
 */
function insertLink(array $ar, $len = null)
{
    if ($len === null) {
        $len = sizeof($ar);
    }

    $order = new SingleLinkList();
    for ($i = 0; $i < $len; $i++) {//i for ar index

        if ($order->len == 0) {//empty order
            $order->add(new Node($ar[$i]));

        } else {//compare one by one
            $node = $order->get(1);

            for ($j = 1; $j <= $order->len + 1; $j++, $node = $node->next) {
                //j for node index,next one -> node++ j++,
                // link :: head-->1-->2-....->len->null , so j from 1 to len+1

                if (is_null($node)) {//j to the end
                    $order->add(new Node($ar[$i]));
                    break;
                }

                if ($node->data >= $ar[$i]) {//add into
                    $order->add(new Node($ar[$i]), $j);
                    break;
                }
            }


        }

//        $order->show();
//        echo "<br/>";
    }

}


/** 基于数组实现的插入排序
 * @param array $ar
 * @param $len
 * @param $insert_way 0数组移动插入数据  1裁切插入数组数据
 */
function insertAr(array $ar, $len=null, $insert_way = 0)
{

    if ($len === null) {
        $len = sizeof($ar);
    }

    $order = [];
    for ($i = 0; $i < $len; $i++) {//i for ar index

        if (sizeof($order) == 0) {//empty order
            $order[] = $ar[$i];

        } else {//compare one by one

            $size = sizeof($order);

            for ($j = 0; $j < $size; $j++) {

                $data = $order[$j];

                if ($j == ($size - 1)) {//j to the end
                    $order[] = $ar[$i];
                    break;
                }

                if ($data >= $ar[$i]) {//add into

                    if ($insert_way == 1) {
                        cutAdd($order, $j, $ar[$i]);
                    } else {
                        moveAdd($order, $j, $ar[$i]);
                    }

                    break;
                }
            }


        }

    }

}


function cutAdd(& $ar, $index, $data)
{
    $left = array_slice($ar, 0, $index);
    $right = array_slice($ar, $index);

    $left[] = $data;

    $ar = array_merge($left, $right);

}


function moveAdd(& $ar, $index, $data)
{
    $len = sizeof($ar);
    $ar[$len] = null;
    for ($i = $len - 1; $i >= $index; $i--) {
        $ar[$i + 1] = $ar[$i];
    }

    $ar[$index] = $data;
}
