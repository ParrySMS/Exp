<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-11-14
 * Time: 19:44
 */

require "Box.php";

$b = new Board();
$b->getConnectedBoxes();

class Board
{
    private $board = [];
    private $line = 6;
    private $col = 6;
    private $icon_max = 4;

    /**
     * @return array
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * @param array $board
     */
    public function setBoard($board)
    {
        $this->board = $board;
    } //最大icon_id

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
        for ($x = 0; $x < $this->col; $x++) {
            $col = [];
            for ($y = 0; $y < $this->line; $y++) {
                $col[] = rand(0, $this->icon_max);
            }
            $this->board[] = $col;
        }
    }

    public function getConnectedBoxes(array $board = [], $update = false)
    {
        if (sizeof($board) == 0) {
            $board = $this->board;
        }

        $line_num = sizeof($board[0]);
        $col_num = sizeof($board);

        echo $line_num;
        echo "<br/>";
        echo $col_num;
        echo "<br/>";

        // $same_lines = []; ////each board ,get the sames line connected-boxes
        $all_same_lines = []; //array of $same_lines

        $same_cols = []; //each x ,get the sames cols connected-boxes
        $all_same_cols = []; //array of $same_cols


        for ($x = 0, $key_x = 0; $x < $col_num; $x++) {//one line ,need to mark y
            for ($y = 0, $key_y = 0, $same_cols[$key_y] = []; $y < $line_num; $y++) {//one col diff line_key

                /**
                 * about  $all_same_cols[] --> $same_cols [different key] --> boxes[] --> box
                 */

                //it is [for] of y ,so just fill $same_cols, and add to $all_same_cols outside the loop
                //fill  box in  $same_cols[$key]
                if ($y != 0 && $board[$x][$y] != $board[$x][$y - 1]) {//get different icon,changes keys
                    $key_y = sizeof($same_cols[$key_y]) >= 3 ? $key_y + 1 : $key_y; //if save over 3 boxes -> is valid data, key++ ,init
                    $same_cols[$key_y] = [];
                }
                // y still can connect over 3  or already has parts-boxs add last 3 box
                if ($y <= $line_num - 3 || sizeof($same_cols[$key_y]) > 0) {
                    $same_cols[$key_y][] = new Box($x, $y, $board[$x][$y]);
                }


                /**
                 * about  $all_same_lines[] --> $same_lines [different key] --> boxes[] --> box
                 */

                // $all_same_lines[$y] is $same_lines
                if (is_array($all_same_lines) && sizeof($all_same_lines) != $line_num) {
                    $all_same_lines[$y] = [];
                }
                //it is [for] of y ,so need to do sth with $all_same_lines's index, to filled it intermittently
                //fill box in  $same_line[$key]
                if ($x != 0 && $board[$x][$y] != $board[$x - 1][$y]) {// new get different icon,changes keys

                    // 3 level of ar, all need to check
                    if (sizeof($all_same_lines)>0
                        && sizeof($all_same_lines[$y]) > 0
                        && sizeof($all_same_lines[$y][$key_x]) >= 3) {

                        $key_x++; //if save over 3 boxes -> is valid data, key++ ,init
                    }

                    $all_same_lines[$y][$key_x] = [];//init
                }

                // x still can connect over 3  or already has parts-boxs add last 3 box
                if ($x <= $col_num - 3 || sizeof($all_same_lines[$y][$key_x]) > 0) {
//                $all_same_lines = array of $same_lines
                    //     $same_lines [$key_x]
                    $all_same_lines[$y][$key_x][] = new Box($x, $y, $board[$x][$y]);
                }


            }//end y for a col
            $all_same_cols[] = $same_cols;

        }//end x for all board


        echo json_encode($board);
        echo "<br/>";
        echo "<br/>";
        echo json_encode($all_same_lines);
        echo "<br/>";
        echo "<br/>";
        echo json_encode($all_same_cols);
        echo "<br/>";
        echo "<br/>";

    }

}