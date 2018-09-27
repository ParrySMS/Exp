<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-9-27
 * Time: 18:16
 */


$ar = [34, 5, 5, 555, 5, 4, 14, 5, 88, 89, 54];
echo 'ar:';
print_r(json_encode($ar));
echo '<br/>';
insert($ar);


function insert(array $ar, $len = null)
{
    if ($len === null) {
        $len = sizeof($ar);
    }

    $order = new SingelLinkList();
    for ($i = 0; $i < $len; $i++) {//i for ar index

        if ($order->len == 0) {//empty order
            $order->add(new Node($ar[$i]));

        } else {//compare one by one
            $node = $order->get(1);

            for ($j = 1; $j <= $order->len + 1; $j++, $node = $node->next) {
                //j for node index,next one -> node++ j++,
                // link :: head-->1-->2-....->len->null , so j from 1 to len+1

//                echo '<br/>';
//                echo "j:$j  ";
//                var_dump($node);
//                echo '<br/>';
//                echo "ar[i]:$ar[$i]  ";
//                echo '<br/>';

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
    }

    $order->show();


}

class Node
{
    public $data;
    public $next;

    /**
     * Node constructor.
     * @param $data
     */
    public function __construct($data = null, $next = null)
    {
        $this->data = $data;
        $this->next = $next;
    }
}

class SingelLinkList
{

    private $head;//默认取head为0位

    public $len;

    /**
     * singelLinkList constructor.
     * @param $head
     */
    public function __construct()
    {
        $this->head = new Node();
        $this->len = 0;
    }

    /** 获取第i位置的节点
     * @param $i
     * @return Node|null
     */
    public function get($i)
    {
        $p = $this->head;
//        var_dump($p);

        for ($index = 0; $index < $i; $index++) {
            $p = $p->next;
            if (is_null($p)) {
                break;
            }
        }

        return $p;

    }

    /** 添加一个节点 默认从最尾部添加
     * @param Node $node
     * @param null $index
     */
    public function add(Node $node, $index = null)
    {
        if ($this->len == 0) {
            $this->head->next = $node;
            $this->len++;
            return;
        }

        //cut and connect
        if ($index == null) {
            $index = $this->len + 1;
        }

        $last = $this->get($index - 1);

        $node->next = $last->next;
        $last->next = $node;
        $this->len++;
    }


    /** 转成数组并且输出
     * @return array
     */
    public function show()
    {
        $order = [];
        $node = $this->head->next;

        while (!is_null($node)) {
            $order[] = $node->data;
            $node = $node->next;
        }
        print_r(json_encode($order));
        return $order;

    }

}