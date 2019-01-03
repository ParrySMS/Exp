<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-12-26
 * Time: 0:35
 */
namespace maxflow;

class Queue
{
    public $data = [];


    public function size()
    {
        return sizeof($this->data);
    }

    /**
     * @param int $num
     */
    public function push(int $num)
    {
        $this->data[] = $num;
    }

    /**
     * @return mixed|null
     */
    public function front()
    {
        return $this->data[0] ?? null;
    }

    /**
     * @return bool
     */
    public function empty():bool
    {
        return ($this->size()==0);
    }

    /**
     * @return mixed
     */
    public function pop()
    {
        return array_shift($this->data);
    }

}