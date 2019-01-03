<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-11-15
 * Time: 2:37
 */
namespace xxl;
class Box
{
    public $line;
    public $col;
    public $value;
    public $direction;

    /**
     * Box constructor.
     * @param $line
     * @param $col
     * @param $value
     * @param $direction
     */
    public function __construct(int $line, int $col, int $value, int $direction = -1)
    {
        $this->line = $line;
        $this->col = $col;
        $this->value = $value;
        $this->direction = $direction;
    }

}