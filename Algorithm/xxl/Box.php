<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-11-15
 * Time: 2:37
 */

class Box
{
    public $x;
    public $y;
    public $value;

    /**
     * Box constructor.
     * @param $x
     * @param $y
     * @param $value
     */
    public function __construct($x, $y, $value)
    {
        $this->x = $x;
        $this->y = $y;
        $this->value = $value;
    }


}