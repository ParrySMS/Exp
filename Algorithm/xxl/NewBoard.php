<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-11-14
 * Time: 19:44
 * //todo fix huge bug
 * 不用看了 没救了 重构把
 */

require "Box.php";
// 0↑  1↓  2← 3→  4↕
define('DIREC_NULL', -1);
define('DIREC_UP', 0);
define('DIREC_DOWM', 1);
define('DIREC_LEFT', 2);
define('DIREC_RIGHT', 3);
define('STEP_LIMIT', 105);

$score = 0;
$b = new Board();
echo "new game!! <br/>";
foreach ($b->getBoard() as $gb) {
    echo json_encode($gb);
    echo "<br/>";
}
echo "<br/>";

//init
$t = 100;
while ($t--) {
    $c = $b->getConnectedBoxes();
    $score = $b->getScore($c, $score);
    if (!$b->updateBoard($c)) {
        break;
    }

    foreach ($b->getBoard() as $gb) {
        echo json_encode($gb);
        echo "<br/>";
    }
    echo PHP_EOL;
    echo "<br/>";
    echo "<br/>";
}
echo "<br/>";

echo "[score: $score ] <br/>start to selectTwoBoxes:<br/>";

$history = [];
$t = 100;
$step = 0;
while ($t--) {

    if ($step >= STEP_LIMIT) {
        break;
    }

    $two = $b->selectTwoBoxes();

    echo "two:<br/>";
    echo json_encode($two);
    echo "<br/>";

    if (sizeof($two) == 0) {
        echo "game over, get [ $score ] by $step step<br/>";
        break;
    }

    $history[$step] = $b->getBoard();
    $step++;
    //move
    $box0 = $two[0];
    $box1 = $two[1];
    echo "step $step, after moving ($box0->x,$box0->y) to ($box1->x,$box1->y)";
    $b->setBoardBox($box0->x, $box0->y, $box1->value);
    $b->setBoardBox($box1->x, $box1->y, $box0->value);
    echo "<br/>";
    echo "<br/>";
    foreach ($b->getBoard() as $gb) {
        echo json_encode($gb);
        echo "<br/>";
    }
    echo "<br/>";
//    $score = $b->getScore($c, $score);
//    echo "<br/>";
//    echo "[score: $score ]<br/>";
//    echo "<br/>";
//    echo "<br/>";


    while ($t--) {
        $c = $b->getConnectedBoxes();
        if (!$b->updateBoard($c)) {// return back
//            $b->setBoard($history[$step - 1]);
            break;
        }

        $score = $b->getScore($c, $score);

        foreach ($b->getBoard() as $gb) {
            echo json_encode($gb);
            echo "<br/>";
        }
        echo "<br/>";
        echo "[score: $score ]<br/>";
        echo "<br/>";
    }
}//while


class Board
{
    const SCORE_3_BOXES = 1;
    const SCORE_4_BOXES = 4;

    const SCORE_5_BOXES = 10;

    const ICON_NULL_ID = 0;

    private $board = [];
    private $line = 5;
    private $col = 5;
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
                $col[] = (int)rand(1, $this->icon_max);
            }
            $this->board[] = $col;
        }
    }


//选择排序 大在前
    private function boxesSort(array & $boxes)
    {
        $len = sizeof($boxes);

        for ($i = 0; $i < $len - 1; $i++) {
            $max = $i; //consider i as max_index

            for ($j = $i + 1; $j < $len; $j++) {//find min_index
                if ($boxes[$j]->value > $boxes[$max]->value) {
                    $max = $j;
                }
            }

            if ($max != $i) {//change
                $t = $boxes[$i];
                $boxes[$i] = $boxes[$max];
                $boxes[$max] = $t;
            }

        }

    }


    /** 穷举
     * @param array $board
     * @return array
     * @throws Exception
     */
    public function selectTwoBoxes(array $board = [])
    {
        if (sizeof($board) == 0) {
            $board = $this->board;
        }

        $line_num = sizeof($board[0]);
        $col_num = sizeof($board);

        unset($maxbox);
        //交换只考虑上和左 因为是对等的 边界加约束 穷举
        for ($x = 0, $max_score = 0; $x < $col_num; $x++) {
            for ($y = 0; $y < $line_num; $y++) {
                if ($board[$x][$y] == $this::ICON_NULL_ID) {//空格
                    continue;
                }
                $score_up = 0;
                $score_right = 0;

                //  DIREC_UP
                unset($bd);
                $bd = $board;
                if ($y < $line_num - 1
                    && $bd[$x][$y] != $bd[$x][$y + 1]
                    && $bd[$x][$y + 1] != $this::ICON_NULL_ID) {//not edge not same not null

                    $t = $bd[$x][$y];
                    $bd[$x][$y] = $bd[$x][$y + 1];
                    $bd[$x][$y + 1] = $t;
                    $score_up = $this->getScore($this->getConnectedBoxes($bd));
                }

                //  DIREC_RIGHT:
                unset($bd);
                $bd = $board;
                if ($x < $col_num - 1
                    && $bd[$x][$y] = $bd[$x + 1][$y]
                    && $bd[$x + 1][$y] != $this::ICON_NULL_ID) {//not edge not same

                    $t = $bd[$x][$y];
                    $bd[$x][$y] = $bd[$x + 1][$y];
                    $bd[$x + 1][$y] = $t;
                    $score_right = $this->getScore($this->getConnectedBoxes($bd));
                }



                $score = ($score_right > $score_up) ? $score_right : $score_up;
                $direction = ($score == $score_right) ? DIREC_RIGHT : DIREC_UP;
                echo "[$x,$y,$score,$direction]<br/>";

                if ($score>0 && $max_score < $score ) {
                    $max_score = $score;
                    $maxbox = new Box($x, $y, $board[$x][$y], $direction);
                }
            }//FOR Y
        }//FOR X

        unset($two_boxes);
        $two_boxes = [];
        if (!isset($maxbox) || $max_score == 0) {
            echo "no maxbox<br/>";
            return $two_boxes;
        }

        //get two
        switch ($maxbox->direction) {
            case DIREC_UP:
                $two_boxes = [$maxbox,
                    new Box($maxbox->x, $maxbox->y + 1, $board[$maxbox->x][$maxbox->y + 1], DIREC_DOWM)];
                break;

//            case DIREC_DOWM:
//                $two_boxes = [$b, new Box($b->x, $b->y - 1, $board[$b->x][$b->y - 1])];
//                break;

//            case DIREC_LEFT:
//                $two_boxes = [$b, new Box($b->x - 1, $b->y, $board[$b->x - 1][$b->y])];
//                break;

            case DIREC_RIGHT:
                $two_boxes = [$maxbox,
                    new Box($maxbox->x + 1, $maxbox->y, $board[$maxbox->x + 1][$maxbox->y], DIREC_LEFT)];
                break;

            default:
                throw new Exception(__CLASS__ . __FUNCTION__ . "  ERROR,no such direction $b->direction");
        }

        return $two_boxes;

    }


    /** 修改某个板块内方格的值
     * @param $x
     * @param $y
     * @param $value
     * @throws Exception
     */
    public
    function setBoardBox($x, $y, $value)

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
    public
    function updateBoard(array $connected_boxes)
    {

        //见函数 getConnectedBoxes
        $connected = array_merge($connected_boxes[0], $connected_boxes[1]);
//
//        echo "connect:<br/>";
//        echo json_encode($connected);
//        echo "<br/>";

        if (sizeof($connected) == 0) {
//            echo "no connected<br/>";
            return false;
        }

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

                } elseif ($i >= 1 && $col[$i - 1] == $this::ICON_NULL_ID) { //drop and swap
                    $col[$i - $drop_step] = $col[$i];
                    $col[$i] = $this::ICON_NULL_ID;
                }
            }

//            echo json_encode($col);
//            echo "<br/>";
//            echo "<br/>";
        }

        return true;
    }

    /** 计算对应消除的分数
     * @param array $connected_boxes
     * @param int $score
     * @return int
     */
    public
    function getScore(array $connected_boxes, $score = 0)
    {
        if (sizeof($connected_boxes) == 0) {
            return $score + 0;
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
    public
    function getConnectedBoxes(array $board = [], $update = false)
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

//         $same_lines = []; //each board ,get the sames line connected-boxes
        unset($all_same_lines);
        $all_same_lines = []; //array of $same_lines
        for ($i = 0; $i < $line_num; $i++) {
            $all_same_lines[$i] = [];
        }

        unset($same_cols);
        unset($all_same_cols);
        $same_cols = []; //each x ,get the sames cols connected-boxes
        $same_cols[0] = [];
        $all_same_cols = []; //array of $same_cols

        for ($x = 0, $key_y = 0, $key_x = 0; $x < $col_num; $x++) {//one line ,need to mark y
            for ($y = 0, $same_cols = [], $same_cols[0] = []; $y < $line_num; $y++) {//one col diff line_key

                /**
                 * about  $all_same_cols[] --> $same_cols [different key] --> boxes[] --> box
                 */

                //it is [for] of y ,so just fill $same_cols, and add to $all_same_cols outside the loop
                //fill  box in  $same_cols[$key]
                if ($y != 0 && $board[$x][$y] != $board[$x][$y - 1]) {//get different icon,changes keys

                    $key_y++; //if save over 3 boxes -> is valid data, key++ ,init
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
//                     3 level of ar, all need to check
                    if (sizeof($all_same_lines) >= $y + 1
                        && sizeof($all_same_lines[$y]) >= $key_x + 1
                        && sizeof($all_same_lines[$y][$key_x]) >= 3) {//in order to count 2 size

                        $key_x++; //if save over 23 boxes -> is valid data, key++ ,init
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
//            echo "all same cols :<br/>";
            $all_same_cols[] = $same_cols;
//            echo "<br/>";

        }//end x for all board
//        echo "all same lines :<br/>";
//        echo json_encode( $all_same_lines );
//            echo "<br/>";
//            echo "<br/>";

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
                if (sizeof($boxes) < 3) {
                    continue;
                }

                if ($boxes[0]->value == $this::ICON_NULL_ID) {
                    continue;
                }

                $line_connected[] = $boxes;
            }

        }

        foreach ($all_same_cols as $units) {
//            echo "col boxes:<br/>";
//            echo json_encode($units);
//            echo sizeof($units) . "<br/>";
            if (sizeof($units) == 0) {
                continue;
            }

            foreach ($units as $boxes) {

                if (sizeof($boxes) < 3) {
                    continue;
                }

                if ($boxes[0]->value == $this::ICON_NULL_ID) {
                    continue;
                }

                $col_connected[] = $boxes;

            }
        }

        $connected_boxes = [$line_connected, $col_connected];

//        echo json_encode($board);
//        echo "<br/>";
//        echo "<br/>";
//        echo json_encode($all_same_lines);
//        echo "<br/>";
//        echo "<br/>";
//        echo json_encode($all_same_cols);
//        echo "<br/>";
//        echo "<br/>";

            echo json_encode($connected_boxes[0]);
            echo "<br/>";
            echo "<br/>";
            echo json_encode($connected_boxes[1]);
            echo "<br/>";
            echo "<br/>";

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

