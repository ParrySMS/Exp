<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-10-23
 * Time: 23:48
 */

class Line
{
    public $index1;
    public $point1;

    public $index2;
    public $point2;

    public $dis;

    /**
     * Line constructor.
     * @param array $point1
     * @param array $point2
     * @param int $dis
     */
    public function __construct($index1 = null, array $point1 = [0, 0], $index2 = null, array $point2 = [0, 0], $dis = 0)
    {
        $this->index1 = $index1;
        $this->index2 = $index2;
        $this->point1 = $point1;
        $this->point2 = $point2;
        $this->dis = $dis;
    }


}