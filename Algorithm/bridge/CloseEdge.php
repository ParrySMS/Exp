<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-12-27
 * Time: 15:40
 */

class CloseEdge
{
    public $from;
    public $to;
    public $value;

    /**
     * CloseEdge constructor.
     * @param int $from
     * @param int $to
     * @param int $value
     */
    public function __construct(int $from, int $to, int $value)
    {
        $this->from = $from;
        $this->to = $to;
        $this->value = $value;
    }

    /** 是否被标记过
     * @return bool
     */
    public function isMarked():bool
    {
        return ($this->value>1) ;
    }

    /**
     * @param int $from
     * @param int $to
     * @param int $value
     */
    public function init(int $from, int $to, int $value)
    {
        $this->from = $from;
        $this->to = $to;
        $this->value = $value;
    }

}