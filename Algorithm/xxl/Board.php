<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-11-14
 * Time: 19:44
 */

class Board
{
    public $board = [];
    private $line = 8;
    private $col = 3;
    private $icon_max = 4; //最大icon_id

    /**
     * Board constructor.
     * @param array $board
     */
    public function __construct(array $board = [])
    {
        if (sizeof($board) == 0) {
            $this->init();
        } else {
            $this->board = $board;
        }
    }

    /** 调整棋盘大小 同时生成新棋盘
     * @param $line
     * @param $col
     */
    public function setSize($line, $col)
    {
        $this->line = $line;
        $this->col = $col;
        $this->init();
    }


    /**
     * 生成初始化的棋盘
     */
    private function init()
    {

        for ($i = 0; $i < $this->line; $i++) {
            $line = [];
            for ($j = 0; $j < $this->col; $j++) {
                $line[] = rand(0, $this->icon_max);
            }

            $this->board[] = $line;
        }
    }


}