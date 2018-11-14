<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-11-14
 * Time: 19:44
 */

require "Box.php";

$b = new Board();
$b->updateBoard($b->getConnectedBoxes());


class Board
{
    const SCORE_3_BOXES = 1;
    const SCORE_4_BOXES = 4;
    const SCORE_5_BOXES = 10;

    const ICON_NULL_ID = -1;

    private $board = [];
    private $line = 6;
    private $col = 6;
    private $icon_max = 4; //最大icon_id

    /**
     * @return array
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     *
     */
    public function setBoard(array $board)
    {
        $this->board = $board;
    }



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
                $col[] = (int)rand(0, $this->icon_max);
            }
            $this->board[] = $col;
        }
    }


    // todo 遍历相连的二方格组 每个方格祖找邻近边缘的六个位 遍历判断  ←↕[XX]↕→
    public function selectTwoBoxes(array $connected_boxes)
    {
        //见函数 getConnectedBoxes
        $linebox2 = $connected_boxes[2];
        $colbox2 = $connected_boxes[3];

        //遍历一次 计算优先权值

        //按照优先权 遍历
    }

    /** 修改某个板块内方格的值
     * @param $x
     * @param $y
     * @param $value
     * @throws Exception
     */
    public function setBoardBox($x, $y, $value)
    {
        if (sizeof($this->board) <= $x
            || sizeof($this->board[0]) <= $y) {
            throw new Exception(__CLASS__ . __FUNCTION__ . ": x or y over board");
        }

        $this->board[$x][$y] = $value;

    }
    

    /**  实现数字下落 设置对应box为-1 对应列下坠 每次下落应该展示一次动画 然后循环进行计算消分
     * @param array $connected_boxes
     * @throws Exception
     */
    public function updateBoard(array $connected_boxes)
    {

        //见函数 getConnectedBoxes
        $connected = array_merge($connected_boxes[0], $connected_boxes[1]);
//
//        echo json_encode($connected);
//        echo "<br/>";
//        echo "<br/>";

        //set -1
        foreach ($connected as $boxs) {
            foreach ($boxs as $b)
                $this->setBoardBox($b->x, $b->y, $this::ICON_NULL_ID);
        }

        //drop
        foreach ($this->board as & $col) {
            $drop_step = 0;
            $height = sizeof($col);
            for ($i = 0; $i < $height; $i++) {

                if ($col[$i] == $this::ICON_NULL_ID) { //mark upper box drops step
                    $drop_step++;

                } elseif ($i > 1 && $col[$i - 1] == $this::ICON_NULL_ID) { //drop and swap
                    $col[$i - $drop_step] = $col[$i];
                    $col[$i] = $this::ICON_NULL_ID;
                }
            }

//            echo json_encode($col);
//            echo "<br/>";
//            echo "<br/>";
        }

    }

    /** 计算对应消除的分数
     * @param array $connected_boxes
     * @param int $score
     * @return int
     */
    public function getScore(array $connected_boxes, $score = 0)
    {
        if (sizeof($connected_boxes) == 0) {
            return 0;
        }

       //见函数 getConnectedBoxes
        $connected = array_merge($connected_boxes[0], $connected_boxes[1]);

//        echo json_encode($connected);
//        echo "<br/>";

        foreach ($connected as $boxs) {

            switch (sizeof($boxs)) {
                case 3:
                    $score += $this::SCORE_3_BOXES;
                    break;
                case 4:
                    $score += $this::SCORE_4_BOXES;
                    break;
                case 5:
                    $score += $this::SCORE_5_BOXES;
                    break;
            }
        }


        return $score;
    }


    /** 找到相连的部分
     * @param array $board
     * @param bool $update 是否更新当前板块
     * @return array
     */
    public function getConnectedBoxes(array $board = [], $update = false)
    {
        if (sizeof($board) == 0) {
            $board = $this->board;
        }

        $line_num = sizeof($board[0]);
        $col_num = sizeof($board);

//        echo $line_num;
//        echo "<br/>";
//        echo $col_num;
//        echo "<br/>";

        // $same_lines = []; ////each board ,get the sames line connected-boxes
        $all_same_lines = []; //array of $same_lines
        for ($i = 0; $i < $line_num; $i++) {
            $all_same_lines[$i] = [];
        }

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

                //it is [for] of y ,so need to do sth with $all_same_lines's index, to filled it intermittently
                //fill box in  $same_line[$key]
                if ($x != 0 && $board[$x][$y] != $board[$x - 1][$y]) {// new get different icon,changes keys

//                    echo "y:$y,key_x:$key_x. <br/>";
                    // 3 level of ar, all need to check
                    if (sizeof($all_same_lines) >= $y + 1
                        && sizeof($all_same_lines[$y]) >= $key_x + 1
                        && sizeof($all_same_lines[$y][$key_x]) >= 3) {

                        $key_x++; //if save over 3 boxes -> is valid data, key++ ,init
                    }

                    $all_same_lines[$y][$key_x] = [];//init
                }

                // x still can connect over 3  or already has parts-boxs add last 3 box
                if ($x <= $col_num - 3) {
//                $all_same_lines = array of $same_lines
                    //     $same_lines [$key_x]
                    $all_same_lines[$y][$key_x][] = new Box($x, $y, $board[$x][$y]);

                } else if (sizeof($all_same_lines[$y]) >= $key_x + 1
                    && sizeof($all_same_lines[$y][$key_x]) > 0) {

                    $all_same_lines[$y][$key_x][] = new Box($x, $y, $board[$x][$y]);
                }


            }//end y for a col
            $all_same_cols[] = $same_cols;

        }//end x for all board

        //clean invaild
        $line_connected = [];
        $line_two_connected = [];
        $col_connected = [];
        $col_two_connected = [];

        foreach ($all_same_lines as $units) {
            if (sizeof($units) == 0) {
                continue;
            }
            foreach ($units as $boxes) {
                if (sizeof($boxes) < 2) {
                    continue;
                } elseif (sizeof($boxes) == 2) { //save for count next step
                    $line_two_connected[] = $boxes;
                } else {
                    $line_connected[] = $boxes;
                }
            }

        }

        foreach ($all_same_cols as $units) {
            if (sizeof($units) == 0) {
                continue;
            }
            foreach ($units as $boxes) {
                if (sizeof($boxes) < 2) {
                    continue;
                } elseif (sizeof($boxes) == 2) { //save for count next step
                    $col_two_connected[] = $boxes;
                } else {
                    $col_connected[] = $boxes;
                }

            }


            $connected_boxes = [$line_connected, $col_connected, $line_two_connected, $col_two_connected];

//        echo json_encode($board);
//        echo "<br/>";
//        echo "<br/>";
//        echo json_encode($all_same_lines);
//        echo "<br/>";
//        echo "<br/>";
//        echo json_encode($all_same_cols);
//        echo "<br/>";
//        echo "<br/>";
//            echo json_encode($connected_boxes[0]);
//            echo "<br/>";
//            echo "<br/>";
//            echo json_encode($connected_boxes[1]);
//            echo "<br/>";
//            echo "<br/>";

            unset($all_same_lines);
            unset($same_cols);
            unset($all_same_cols);
            unset($line_connected);
            unset($col_connected);
            unset($line_two_connected);
            unset($col_two_connected);

            return $connected_boxes;
        }

    }

}