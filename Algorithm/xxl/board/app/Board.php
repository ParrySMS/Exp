<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-1-3
 * Time: 0:59
 */

namespace xxl;
class Board
{
    public $size;
    public $b = [];
    // 0↑  1↓  2← 3→
    const DIREC_NULL = -1;
    const DIREC_UP = 0;
    const DIREC_DOWN = 1;
    const DIREC_LEFT = 2;
    const DIREC_RIGHT = 3;

    /**
     * board constructor.
     * @param int $size
     */
    public function __construct(int $size)
    {
        $this->size = $size;
        $this->randFillBoard();
    }


    public function echoBoard()
    {
        for ($line = $this->size - 1; $line >= 0; $line--) {
            echo json_encode($this->b[$line]) . PHP_EOL;
        }
        echo PHP_EOL;
    }

    /** 给棋盘随机赋值
     * @param int $min
     * @param int $max
     */
    public function randFillBoard(int $min = 1, int $max = 5)
    {
        for ($line = 0; $line < $this->size; $line++) {
            unset($one_line);
            $one_line = [];
            for ($col = 0; $col < $this->size; $col++) {
                $one_line[] = (int)rand($min, $max);
            }
            $this->b[] = $one_line;
        }
    }

    /** 直接赋值棋盘
     * @param array $board
     */
    public function setBoard(array $board)
    {
        $this->b = $board;
    }

    //todo 穷举遍历，找到得分最大的那个操作，返回操作数组信息

    public function findBestAction()
    {

        //todo 算分        
    }


    /**相连块数转为分数
     * @param int $num
     * @return int
     */
    private function num2Score(int $num): int
    {
        switch ($num) {
            case 3:
                return 1;
            case 4:
                return 4;
            case 5:
                return 10;
            default :
                return 0;
        }
    }

    /** 将相链接部分 置位0 用于drop
     * @param array $connect
     */
    private function setZero(array $connect)
    {
        foreach ($connect as $box) {
            $this->b[$box->line][$box->col] = 0;
        }
    }


    /**
     * 下落
     */
    private function drop()
    {
        //drop
        for ($col = 0; $col < $this->size; $col++) {
            $drop_step = 0;
            for ($line = 0; $line < $this->size; $line++) {

                if ($this->b[$line][$col] == 0) { //mark upper box drops step
                    $drop_step++;

                } else if ($line >= 1 && $this->b[$line - 1][$col] == 0) { //drop and swap
                    $this->b[$line - $drop_step][$col] = $this->b[$line][$col];
                    $this->b[$line][$col] = 0;
                }
            }
        }
    }


    /**
     * @param array $connect
     * @param int $score
     * @return int
     */
    private function threeBoxesCheck(array $connect, int $score, string $type): int
    {
        if (sizeof($connect) < 3) {
            return -1;
        } else {
//                    echo json_encode($connect);
            $l = $connect[2]->line;
            $c = $connect[2]->col;
            $v = $connect[2]->value;
            //找4 5
            if ($type == 'line') {
                if ($c + 1 < $this->size && $this->b[$l][$c + 1] == $v) {
                    $connect[] = new Box($l, $c + 1, $v);//4

                    if ($c + 2 < $this->size && $this->b[$l][$c + 2] == $v) {
                        $connect[] = new Box($l, $c + 2, $v);//5
                    }
                }

            } else {//line
                if ($l + 1 < $this->size && $this->b[$l + 1][$c] == $v) {
                    $connect[] = new Box($l + 1, $c, $v);//4

                    if ($l + 2 < $this->size && $this->b[$l + 2][$c] == $v) {
                        $connect[] = new Box($l + 2, $c, $v);//5
                    }
                }
            }

            $score += $this->num2Score(sizeof($connect));
            $this->setZero($connect);
            return $score;
        }
    }

    /**
     * @return int
     */
    public function clearAndGetScore(): int
    {

        $connect = [];
        $score = 0;

        //line
        for ($line = 0; $line < $this->size; $line++) {

            $res = $this->threeBoxesCheck($connect, $score, 'line');
            if ($res >= 0) {
                $score = $res;
                unset($connect);
                $connect = [];
            }
            unset($connect);
            $connect = [];
            for ($col = 0; $col < $this->size; $col++) {

                $res = $this->threeBoxesCheck($connect, $score, 'line');
                if ($res >= 0) {
                    $score = $res;
                    unset($connect);
                    $connect = [];
                }

                if ($col == 0) {
                    $connect[] = new Box($line, $col, $this->b[$line][$col]);
                } else if ($this->b[$line][$col] == $this->b[$line][$col - 1]) {
                    $connect[] = new Box($line, $col, $this->b[$line][$col]);
                } else {
                    unset($connect);
                    $connect = [];
                }
            }
        }//end for line


        //col
        for ($col = 0; $col < $this->size; $col++) {

            $res = $this->threeBoxesCheck($connect, $score, 'col');
            if ($res >= 0) {
                $score = $res;
                unset($connect);
                $connect = [];
            }
            unset($connect);
            $connect = [];
            for ($line = 0; $line < $this->size; $line++) {
//                var_dump($connect);
                $res = $this->threeBoxesCheck($connect, $score, 'col');
                if ($res >= 0) {
                    $score = $res;
                    unset($connect);
                    $connect = [];
                }

                if ($line == 0) {
                    $connect[] = new Box($line, $col, $this->b[$line][$col]);
                } else if ($this->b[$line][$col] == $this->b[$line - 1][$col]) {
                    $connect[] = new Box($line, $col, $this->b[$line][$col]);
                } else {
                    unset($connect);
                    $connect = [];
                }
            }
        }//end for col


        $this->drop();
        return $score;
    }

    /**
     *  todo 穷举遍历
     */
    public function loop4BestOnce()
    {
        for ($line = 0; $line < $this->size; $line++) {
            for ($col = 0; $col < $this->size; $col++) {
                if ($this->b[$line][$col] == 0) {
                    continue;
                }
                //todo 四个方向

            }
        }
    }
}