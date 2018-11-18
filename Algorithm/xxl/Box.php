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
    public $direction;

    /**
     * Box constructor.
     * @param $x
     * @param $y
     * @param $value
     * @param $direction
     */
    public function __construct($x, $y, $value, $direction = -1)
    {
        $this->x = $x;
        $this->y = $y;
        $this->value = $value;
        $this->direction = $direction;
    }


}