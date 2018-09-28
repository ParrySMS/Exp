<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-9-28
 * Time: 22:02
 */

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