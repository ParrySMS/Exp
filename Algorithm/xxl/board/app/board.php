<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-1-3
 * Time: 0:59
 */
namespace xxl;
class board
{
    public $size;
    public $b = [];
    /**
     * board constructor.
     * @param int $size
     */
    public function __construct(int $size)
    {
        $this->size = $size;
        $this->randFillBoard();
    }

    /** 给棋盘赋值
     * @param int $min
     * @param int $max
     */
    public function randFillBoard(int $min=1,int $max=5)
    {
        for ($x = 0; $x < $this->size; $x++) {
            unset($col);
            $col = [];
            for ($y = 0; $y < $this->size; $y++) {
                $col[] = (int)rand($min, $max);
            }
            $this->b[] = $col;
        }
    }


    public function setBoard(array $board)
    {
        $this->b = $board;
    }


}