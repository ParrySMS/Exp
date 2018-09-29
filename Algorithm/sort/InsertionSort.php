<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-9-27
 * Time: 18:16
 */

require "Node.php";
require "SingleLInkList.php";

$ar = [34, 5, 5, 555, 5, 4, 14, 5, 88, 89, 54];
echo "input: <br/>";
print_r(json_encode($ar));
echo "<br/>";
echo "<br/>";

insert($ar);


/** 基于链表实现的插入排序
 * @param array $ar
 * @param null $len
 * @param bool $need_show
 */
function insert(array $ar, $len = null)
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

        $order->show();
        echo "<br/>";
    }


}

