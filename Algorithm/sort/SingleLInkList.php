<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-9-28
 * Time: 22:03
 */


class SingleLinkList
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