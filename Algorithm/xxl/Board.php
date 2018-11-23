<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-11-14
 * Time: 19:44
 */

require "Box.php";
// 0↑  1↓  2← 3→  4↕
define('DIREC_NULL', -1);
define('DIREC_UP', 0);
define('DIREC_DOWM', 1);
define('DIREC_LEFT', 2);
define('DIREC_RIGHT', 3);
define('STEP_LIMIT', 5);
define('BOX_MOST', 5);

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

    if($step>=STEP_LIMIT){
        break;
    }

    $c = $b->getConnectedBoxes();
    $two = $b->OLDselectTwoBoxes($c);

    if (sizeof($two) == 0) {//换穷举
        $two = $b->selectTwoBoxes();
//        break;
    }
//    echo "two:<br/>";
//    echo json_encode($two);
//    echo "<br/>";

    if (sizeof($two) == 0) {
        echo "game over, get [ $score ] by $step step<br/>";
        break;
    }

    $step++;
    $history[] = $b->getBoard();
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
        if (!$b->updateBoard($c)) {
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
    private $line = 12;
    private $col = 12 ;
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


    /** 获取对应相反方向
     * @param $direction
     * @return int
     * @throws Exception
     */
    private function reversedDict($direction)
    {

        switch ($direction) {
            case DIREC_UPDOWM:
            case DIREC_NULL:
                return $direction;
            case DIREC_UP:
                return DIREC_DOWM;
            case DIREC_DOWM:
                return DIREC_UP;
            case DIREC_LEFT:
                return DIREC_RIGHT;
            case DIREC_RIGHT:
                return DIREC_LEFT;
            default:
                throw new Exception(__CLASS__ . __FUNCTION__ . "no such direction: $direction");
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
        for ($x = 0,$max_score = 0; $x < $col_num; $x++) {
            for ($y = 0; $y < $line_num; $y++) {
                if ($board[$x][$y] == $this::ICON_NULL_ID) {
                    continue;
                }
                $score_up =0 ;
                $score_right = 0;

                //  DIREC_UP
                unset($bd);
                $bd = $board;
                if ($y != $line_num - 1) {
                    $t = $bd[$x][$y];
                    $bd[$x][$y] = $bd[$x][$y + 1];
                    $bd[$x][$y + 1] = $t;
                    $score_up = $this->getScore($this->getConnectedBoxes($bd));
                }

                //  DIREC_RIGHT:
                unset($bd);
                $bd = $board;
                if ($x < $col_num - 1) {
                    $t = $bd[$x][$y];
                    $bd[$x][$y] = $bd[$x + 1][$y];
                    $bd[$x + 1][$y] = $t;
                    $score_right = $this->getScore($this->getConnectedBoxes($bd));
                }

                $score = $score_right>$score_up?$score_right:$score_up;
                $direction = $score == $score_right?DIREC_RIGHT:DIREC_UP;

                if($max_score<$score){
                    $maxbox = new Box($x,$y,$board[$x][$y],$direction);
                }
            }//FOR Y
        }//FOR X

        unset($two_boxes);
        $two_boxes = [];
        if(!isset($maxbox)){
            return $two_boxes;
        }

        //get two
        switch ($maxbox->direction) {
            case DIREC_UP:
                $two_boxes = [$maxbox,
                    new Box($maxbox->x, $maxbox->y + 1, $board[$maxbox->x][$maxbox->y + 1],DIREC_DOWM)];
                break;

//            case DIREC_DOWM:
//                $two_boxes = [$b, new Box($b->x, $b->y - 1, $board[$b->x][$b->y - 1])];
//                break;

//            case DIREC_LEFT:
//                $two_boxes = [$b, new Box($b->x - 1, $b->y, $board[$b->x - 1][$b->y])];
//                break;

            case DIREC_RIGHT:
                $two_boxes = [$maxbox,
                    new Box($maxbox->x + 1, $maxbox->y, $board[$maxbox->x+1][$maxbox->y],DIREC_LEFT)];
                break;

            default:
                throw new Exception(__CLASS__ . __FUNCTION__ . "  ERROR,no such direction $b->direction");
        }

        return $two_boxes;

    }


    // todo 遍历相连的二方格组 每个方格祖找邻近边缘的六个位 遍历判断  ←↕[XX]↕→
    // todo 还有  X0X 情况   XX0XOO情况
    /** todo 废弃方法 考虑的情况不完全
     * @param array $connected_boxes
     * @param array $board
     * @throws Exception
     */
    public function OLDselectTwoBoxes(array $connected_boxes, array $board = [])
    {
        if (sizeof($board) == 0) {
            $board = $this->board;
        }

        $line_num = sizeof($board[0]);
        $col_num = sizeof($board);

        //见函数 getConnectedBoxes
        $line_boxes2 = $connected_boxes[2];
        $col_boxes2 = $connected_boxes[3];


        $mx_v = []; //value
        $mx_d = []; // direction 0↑  1↓  2← 3→
        for ($x = 0; $x < $col_num; $x++) {
            for ($y = 0; $y < $line_num; $y++) {
                $mx_v[$x][$y] = -1;
                $mx_d[$x][$y] = DIREC_NULL;
            }
        }

        //遍历一次 计算优先权值 todo 而这个判断方向的程序有bug 方向不一定准的
        if (sizeof($line_boxes2) > 0) {
            $this->lineBoxesJudge($line_boxes2, $mx_v, $mx_d, $board);
        }

        if (sizeof($col_boxes2) > 0) {
            $this->colBoxesJudge($col_boxes2, $mx_v, $mx_d, $board);
        }


        //获取有优先权的方格
        unset($boxes);
        $boxes = [];
        for ($x = 0; $x < $col_num; $x++) {
            for ($y = 0; $y < $line_num; $y++) {

                if ($mx_v[$x][$y] <= 0) {
                    continue;
                }

                $boxes[] = new Box($x, $y, $mx_v[$x][$y], $mx_d[$x][$y]);

            }
        }


        //  按照优先权由小到大排序 遍历 取前5个
        $this->boxesSort($boxes);

//        echo "after sorted boxes<br/>";
//        echo json_encode($boxes);
//        echo "<br/>";
//        echo "<br/>";

        $limit = sizeof($boxes) < BOX_MOST ? sizeof($boxes) : BOX_MOST;
        for ($i = 0, $score = 0, $index = -1; $i < $limit; $i++) {

            $b = $boxes[$i];
//            echo "for--sorted:";
//            echo "($b->x,$b->y,$b->direction)<br/>";
            unset($bd);
            $bd = $board;
            //try to move
            switch ($b->direction) {
                case DIREC_UP:
                    if($y+1<$line_num) {
                        $t = $bd[$b->x][$b->y];
                        $bd[$b->x][$b->y] = $bd[$b->x][$b->y + 1];
                        $bd[$b->x][$b->y + 1] = $t;
                    }
                    break;

                case DIREC_DOWM:
                    if($y-1>=0) {
                        $t = $bd[$b->x][$b->y];
                        $bd[$b->x][$b->y] = $bd[$b->x][$b->y - 1];
                        $bd[$b->x][$b->y - 1] = $t;
                    }
                    break;

                case DIREC_LEFT:
                    if($x-1>=0) {
                        $t = $bd[$b->x][$b->y];
                        $bd[$b->x][$b->y] = $bd[$b->x - 1][$b->y];
                        $bd[$b->x - 1][$b->y] = $t;
                    }
                    break;

                case DIREC_RIGHT:
                    if($x+1<$col_num) {
                        $t = $bd[$b->x][$b->y];
                        $bd[$b->x][$b->y] = $bd[$b->x + 1][$b->y];
                        $bd[$b->x + 1][$b->y] = $t;
                    }
                    break;

                default:
                    throw new Exception(__CLASS__ . __FUNCTION__ . "  ERROR,no such direction $b->direction");
            }

            // todo score 取一个的剪枝
            $add = $this->getScore($this->getConnectedBoxes($bd));
//            echo "add score:$add <br/>";
            if ($score < $add) {
                $score = $add;
                $index = $i;
            }

        }//end try move

        //todo score==0 but has sorted boxes ??? fixing this bug
        if ($score == 0) {//score 0 no move
            return $two_boxes = [];
        }

//        echo "choose index:$index,score is $score,";
//        echo json_encode($boxes[$index]);
//        echo "<br/>";
//        echo "<br/>";

        //has score
        $b = $boxes[$index];
        $b->value = $board[$b->x][$b->y];

        switch ($b->direction) {
            case DIREC_UP:
                $two_boxes = [$b, new Box($b->x, $b->y + 1, $board[$b->x][$b->y + 1])];
                break;

            case DIREC_DOWM:
                $two_boxes = [$b, new Box($b->x, $b->y - 1, $board[$b->x][$b->y - 1])];
                break;

            case DIREC_LEFT:
                $two_boxes = [$b, new Box($b->x - 1, $b->y, $board[$b->x - 1][$b->y])];
                break;

            case DIREC_RIGHT:
                $two_boxes = [$b, new Box($b->x + 1, $b->y, $board[$b->x + 1][$b->y])];
                break;

            default:
                throw new Exception(__CLASS__ . __FUNCTION__ . "  ERROR,no such direction $b->direction");
        }

        return $two_boxes;


    }


    /**
     * @param array $line_boxes2
     * @param array $mx_v
     * @param array $mx_d
     * @param array $board
     * @throws Exception
     */
    private function lineBoxesJudge(array $line_boxes2, array &$mx_v, array & $mx_d, array $board = [])
    {
        if (sizeof($board) == 0) {
            $board = $this->board;
        }

        $col_num = sizeof($board);

        foreach ($line_boxes2 as $boxes) {
            $left = $boxes[0];
            $right = $boxes[1];

            if ($left->x > 0
                && $board[$left->x-1][$left->y] == $this::ICON_NULL_ID) {//not edge
                // 横块左角
                //    ?
                //  ? O [X X]
                //    ?


                $this->judgeLeft($left, $mx_v, $mx_d, $board);

            }//end left


            if ($right->x < $col_num - 1
                && $board[$right->x+1][$right->y] == $this::ICON_NULL_ID) {//not edge
                // 横块右角
                //       ?
                // [X X] O ?
                //       ?
                $this->judgeRight($right, $mx_v, $mx_d, $board);


            }//end right
        }
    }


    private function colBoxesJudge(array $col_boxes2, array &$mx_v, array & $mx_d, array $board = [])
    {
        if (sizeof($board) == 0) {
            $board = $this->board;
        }

        $line_num = sizeof($board[0]);

        foreach ($col_boxes2 as $boxes) {
            $up = $boxes[0];
            $down = $boxes[1];

            if ($up->y < $line_num - 1
                && $board[$up->x][$up->y+1] == $this::ICON_NULL_ID) {//
                // 横块上角
                //   ?
                // ? O ?
                //   X
                //   X
                $this->judgeUp($up, $mx_v, $mx_d, $board);
            }


            if ($down->y > 0
                && $board[$down->x][$down->y-1] == $this::ICON_NULL_ID) {//                // 横块下角
                //   X
                //   X
                // ? O ?
                //   X
                $this->judgeDown($down, $mx_v, $mx_d, $board);
            }
        }
    }

    /**
     * // 横块左上角
     * //  X
     * //  O [X X]
     * @param $left
     * @param array $mx_v
     * @param array $mx_d
     * @param array $board
     */
    private function judgeLeftTop($left, array & $mx_v, array &$mx_d, array &$board = [])
    {

        if (sizeof($board) == 0) {
            $board = $this->board;
        }

        $line_num = sizeof($board[0]);

        // 横块左上角
        //  X
        //  O [X X]
        if (!($left->y + 1 < $line_num && $board[$left->x - 1][$left->y + 1] == $left->value)) {
            return;
        }


        if ($mx_d[$left->x - 1][$left->y] != DIREC_UP
            && $mx_v[$left->x - 1][$left->y] < $this::SCORE_3_BOXES) {//overload the mx_d

            $mx_d[$left->x - 1][$left->y] = DIREC_UP;
            $mx_v[$left->x - 1][$left->y] = $this::SCORE_3_BOXES;
        }

        // end
        //  X
        //  O [X X]
    }


    /** 横块上左角
     * //  ? O
     * //    X
     * //    X
     * @param $up
     * @param array $mx_v
     * @param array $mx_d
     * @param array $board
     */
    private function judgeTopLeft($up, array & $mx_v, array &$mx_d, array &$board)
    {

        if (sizeof($board) == 0) {
            $board = $this->board;
        }

        $line_num = sizeof($board[0]);
        $col_num = sizeof($board);

        // 横块上左角
        //  ? O
        //    X
        //    X

        if (!($up->x - 1 >= 0 && $board[$up->x - 1][$up->y + 1] == $up->value)) {
            return;
        }


        if ($mx_d[$up->x][$up->y + 1] != DIREC_LEFT
            && $mx_v[$up->x][$up->y + 1] < $this::SCORE_3_BOXES) {//overload the mx_d

            $mx_d[$up->x][$up->y + 1] = DIREC_LEFT;
            $mx_v[$up->x][$up->y + 1] = $this::SCORE_3_BOXES;
        }

    }

    private function judgeDownLeft($down, array & $mx_v, array &$mx_d, array &$board)
    {

        if (sizeof($board) == 0) {
            $board = $this->board;
        }

        $line_num = sizeof($board[0]);
        $col_num = sizeof($board);

        // 横块下左角
        //    X
        //    X
        //  ? O

        if (!($down->x - 1 >= 0 && $board[$down->x - 1][$down->y - 1] == $down->value)) {
            return;
        }


        if ($mx_d[$down->x][$down->y + 1] != DIREC_LEFT
            && $mx_v[$down->x][$down->y + 1] < $this::SCORE_3_BOXES) {//overload the mx_d

            $mx_d[$down->x][$down->y + 1] = DIREC_LEFT;
            $mx_v[$down->x][$down->y + 1] = $this::SCORE_3_BOXES;
        }

    }

    /** 横块上右角
     * //    O ?
     * //    X
     * //    X
     * @param $up
     * @param array $mx_v
     * @param array $mx_d
     * @param array $board
     */
    private function judgeTopRight($up, array & $mx_v, array &$mx_d, array &$board)
    {

        if (sizeof($board) == 0) {
            $board = $this->board;
        }

        $col_num = sizeof($board);

        // 横块上右角
        //    O X
        //    X
        //    X

        if (!($up->x + 1 < $col_num && $board[$up->x + 1][$up->y + 1] == $up->value)) {
            return;
        }


        if ($mx_d[$up->x][$up->y + 1] != DIREC_RIGHT
            && $mx_v[$up->x][$up->y + 1] < $this::SCORE_3_BOXES) {//overload the mx_d

            $mx_d[$up->x][$up->y + 1] = DIREC_RIGHT;
            $mx_v[$up->x][$up->y + 1] = $this::SCORE_3_BOXES;
        }

    }

    /**
     * @param $down
     * @param array $mx_v
     * @param array $mx_d
     * @param array $board
     */
    private function judgeDownRight($down, array & $mx_v, array &$mx_d, array &$board)
    {

        if (sizeof($board) == 0) {
            $board = $this->board;
        }

        $col_num = sizeof($board);

        // 横块下右角
        //    X
        //    X
        //    O X

        if (!($down->x + 1 < $col_num && $board[$down->x + 1][$down->y - 1] == $down->value)) {
            return;
        }


        if ($mx_d[$down->x][$down->y - 1] != DIREC_RIGHT
            && $mx_v[$down->x][$down->y - 1] < $this::SCORE_3_BOXES) {//overload the mx_d

            $mx_d[$down->x][$down->y - 1] = DIREC_RIGHT;
            $mx_v[$down->x][$down->y - 1] = $this::SCORE_3_BOXES;
        }

    }


    //todo 弃用方法
    private function OLDjudgeLeftTop($left, array & $mx_v, array &$mx_d, array $board)
    {

        if (sizeof($board) == 0) {
            $board = $this->board;
        }

        $line_num = sizeof($board[0]);

        // 横块左上角
        //  X
        //  O [X X]
        if (!($left->y + 1 < $line_num && $board[$left->x - 1][$left->y + 1] == $left->value)) {
            return;
        }

        if ($mx_d[$left->x - 1][$left->y + 1] == DIREC_NULL //undefine dirct
            && $mx_d[$left->x - 1][$left->y] == DIREC_NULL) { //  ↕ 0 0

            $mx_d[$left->x - 1][$left->y + 1] = DIREC_DOWM;
            $mx_d[$left->x - 1][$left->y] = DIREC_UP;

            $mx_v[$left->x - 1][$left->y + 1] = 0;
            $mx_v[$left->x - 1][$left->y] = $this::SCORE_3_BOXES;
            return;

        }

        if ($mx_d[$left->x - 1][$left->y + 1] != DIREC_NULL //upper already has dirct
            && $mx_d[$left->x - 1][$left->y] == DIREC_NULL) {   //↕ 1 0

            if ($mx_d[$left->x - 1][$left->y + 1] == DIREC_DOWM) {  //  AND same swap

                $mx_d[$left->x - 1][$left->y] = DIREC_UP;
                $mx_v[$left->x - 1][$left->y] = $this::SCORE_3_BOXES; //add value

            } else if ($mx_v[$left->x - 1][$left->y + 1] < $this::SCORE_3_BOXES) { //diff dirct
                //diff swap  change original
                $mx_d[$left->x - 1][$left->y + 1] = DIREC_DOWM;
                $mx_d[$left->x - 1][$left->y] = DIREC_UP;

                $mx_v[$left->x - 1][$left->y + 1] = 0;
                $mx_v[$left->x - 1][$left->y] = $this::SCORE_3_BOXES;
            }

            return;
        }


        if ($mx_d[$left->x - 1][$left->y + 1] == DIREC_NULL   //lower already has dirct  AND same swap
            && $mx_d[$left->x - 1][$left->y] != DIREC_NULL) { //↕ 0 1

            if ($mx_d[$left->x - 1][$left->y] == DIREC_UP) {  //  AND same swap
                $mx_d[$left->x - 1][$left->y + 1] = DIREC_DOWM;

                $mx_v[$left->x - 1][$left->y] += $this::SCORE_3_BOXES; // for itself
                $mx_v[$left->x - 1][$left->y + 1] = 0;

            } else if ($mx_v[$left->x - 1][$left->y] < $this::SCORE_3_BOXES) { //diff dirct
                //diff swap  change original
                $mx_d[$left->x - 1][$left->y + 1] = DIREC_DOWM;
                $mx_d[$left->x - 1][$left->y] = DIREC_UP;

                $mx_v[$left->x - 1][$left->y + 1] = 0;
                $mx_v[$left->x - 1][$left->y] = $this::SCORE_3_BOXES;
            }
            return;

        }


        if ($mx_d[$left->x - 1][$left->y + 1] != DIREC_NULL   //both already has dirct
            && $mx_d[$left->x - 1][$left->y] != DIREC_NULL) { //↕ 1 1

            if ($mx_v[$left->x - 1][$left->y] + $mx_v[$left->x - 1][$left->y + 1]
                < $this::SCORE_3_BOXES) { //diff dirct
                //diff swap  change original
                $mx_d[$left->x - 1][$left->y + 1] = DIREC_DOWM;
                $mx_d[$left->x - 1][$left->y] = DIREC_UP;

                $mx_v[$left->x - 1][$left->y + 1] = 0;
                $mx_v[$left->x - 1][$left->y] = $this::SCORE_3_BOXES;

            }
            return;

        }


        throw new Exception(__CLASS__ . __FUNCTION__ .
            "  mx_dirction error: upper is" . $mx_d[$left->x - 1][$left->y + 1] .
            ", and lower is " . $mx_d[$left->x - 1][$left->y]);

        // end
        //  X
        //  O [X X]
    }


    /** 横块右上角
     * //       X
     * // [X X] O
     * @param $right
     * @param array $mx_v
     * @param array $mx_d
     * @param array $board
     */
    private function judgeRightTop($right, array & $mx_v, array &$mx_d, array & $board)
    {

        if (sizeof($board) == 0) {
            $board = $this->board;
        }

        $line_num = sizeof($board[0]);

        // 横块右上角
        //       X
        // [X X] O
        if (!($right->y + 1 < $line_num && $board[$right->x + 1][$right->y + 1] == $right->value)) {
            return;
        }

        if ($mx_d[$right->x + 1][$right->y] != DIREC_UP
            && $mx_v[$right->x + 1][$right->y] < $this::SCORE_3_BOXES) {//overload the mx_d

            $mx_d[$right->x + 1][$right->y] = DIREC_UP;
            $mx_v[$right->x + 1][$right->y] = $this::SCORE_3_BOXES;
        }
        // end
        //       X
        // [X X] O
    }


    /**   // 横块左下角
     * //  O [X X]
     * //  X
     * @param $left
     * @param array $mx_v
     * @param array $mx_d
     * @param array $board
     */
    private function judgeLeftBtm($left, array & $mx_v, array &$mx_d, array &$board)
    {

        if (sizeof($board) == 0) {
            $board = $this->board;
        }


        // 横块左下角
        //  O [X X]
        //  X
        if (!($left->y - 1 >= 0 && $board[$left->x - 1][$left->y - 1] == $left->value)) {
            return;
        }


        if ($mx_d[$left->x - 1][$left->y] != DIREC_DOWM
            && $mx_v[$left->x - 1][$left->y] < $this::SCORE_3_BOXES) {//overload the mx_d

            $mx_d[$left->x - 1][$left->y] = DIREC_DOWM;
            $mx_v[$left->x - 1][$left->y] = $this::SCORE_3_BOXES;
        }
        // end
        //  O [X X]
        //  X
    }

    /**
     * // 横块右下角
     * //  [X X] O
     * //        X
     * @param $right
     * @param array $mx_v
     * @param array $mx_d
     * @param array $board
     */
    private function judgeRightBtm($right, array & $mx_v, array &$mx_d, array &$board)
    {

        if (sizeof($board) == 0) {
            $board = $this->board;
        }


        // 横块右下角
        //  [X X] O
        //        X
        if (!($right->y - 1 >= 0 && $board[$right->x + 1][$right->y - 1] == $right->value)) {
            return;
        }


        if ($mx_d[$right->x + 1][$right->y] != DIREC_DOWM
            && $mx_v[$right->x + 1][$right->y] <= $this::SCORE_3_BOXES) {//overload the mx_d

            $mx_d[$right->x + 1][$right->y] = DIREC_DOWM;
            $mx_v[$right->x + 1][$right->y] = $this::SCORE_3_BOXES;
        }
        // end
        // [X X] O
        //       X
    }


    /** 横块左角
     * //    ?
     * //  X O [X X]
     * //    ?
     * @param $left
     * @param array $mx_v
     * @param array $mx_d
     * @param array $board
     */
    private function judgeLeft($left, array & $mx_v, array &$mx_d, array &$board)
    {
        // 横块左角
        //    ?
        //  X O [X X]
        //    ?
        if (!($left->x - 2 >= 0 && $board[$left->x - 2][$left->y] == $left->value)) {
            $this->judgeLeftTop($left, $mx_v, $mx_d, $board);
            $this->judgeLeftBtm($left, $mx_v, $mx_d, $board);
            return;
        }

        //($left->x - 2 >= 0 && $board[$left->x - 2][$left->y] == $left->value)


        //优先考虑四重
        $this->judgeLeftTop($left, $mx_v, $mx_d, $board);
        if ($mx_d[$left->x - 1][$left->y] == DIREC_UP) { //X ↑ [X X]
            $mx_v[$left->x - 1][$left->y] = $this::SCORE_4_BOXES;

            $mx_d[$left->x - 1][$left->y + 1] = DIREC_DOWM;
            $mx_v[$left->x - 1][$left->y + 1] = $this::SCORE_4_BOXES;
            return;
        }

        $this->judgeLeftBtm($left, $mx_v, $mx_d, $board);
        if ($mx_d[$left->x - 1][$left->y] == DIREC_DOWM) { //X ↓ [X X]
            $mx_v[$left->x - 1][$left->y] = $this::SCORE_4_BOXES;

            $mx_d[$left->x - 1][$left->y - 1] = DIREC_DOWM;
            $mx_v[$left->x - 1][$left->y - 1] = $this::SCORE_4_BOXES;
            //
            return;
        }

        //无四重  ↕ 无收益 考虑左右

        if ($mx_d[$left->x - 1][$left->y] != DIREC_LEFT
            && $mx_v[$left->x - 1][$left->y] < $this::SCORE_3_BOXES) {

            $mx_d[$left->x - 1][$left->y] = DIREC_LEFT;
            $mx_v[$left->x - 1][$left->y] = $this::SCORE_3_BOXES; // change new dirct

        }


    }


    /**  横块右角
     * //       ?
     * // [X X] O X
     * //       ?
     * @param $right
     * @param array $mx_v
     * @param array $mx_d
     * @param array $board
     */
    private function judgeRight($right, array & $mx_v, array &$mx_d, array &$board)
    {
        $col_num = sizeof($board);

        // 横块右角
        //       ?
        // [X X] O X
        //       ?
        if (!($right->x + 2 < $col_num && $board[$right->x + 2][$right->y] == $right->value)) {
            $this->judgeRightTop($right, $mx_v, $mx_d, $board);
            $this->judgeRightBtm($right, $mx_v, $mx_d, $board);
            return;
        }


        //优先考虑四重
        $this->judgeRightTop($right, $mx_v, $mx_d, $board);
        if ($mx_d[$right->x + 1][$right->y] == DIREC_UP) { // [X X] ↑ X
            $mx_v[$right->x + 1][$right->y] = $this::SCORE_4_BOXES;
            return;
        }

        $this->judgeRightBtm($right, $mx_v, $mx_d, $board);
        if ($mx_d[$right->x + 1][$right->y] == DIREC_DOWM) { // [X X] ↓ X
            $mx_v[$right->x + 1][$right->y] = $this::SCORE_4_BOXES;
            return;
        }

        //无四重  ↕ 无收益 考虑左右

        if ($mx_d[$right->x + 1][$right->y] != DIREC_RIGHT
            && $mx_v[$right->x + 1][$right->y] < $this::SCORE_3_BOXES) {

            $mx_d[$right->x + 1][$right->y] = DIREC_RIGHT;
            $mx_v[$right->x + 1][$right->y] = $this::SCORE_3_BOXES; // change new dirct

        }


    }


    /**横块上角
     * //   ?
     * // ? O ?
     * //   X
     * //   X
     * @param $up
     * @param array $mx_v
     * @param array $mx_d
     * @param array $board
     */
    private function judgeUp($up, array & $mx_v, array &$mx_d, array &$board)
    {
        $line_num = sizeof($board[0]);
        // 横块上角
        //   X
        // ? O ?
        //   X
        //   X
        if (!($up->y + 2 < $line_num && $board[$up->x][$up->y + 2] == $up->value)) {
            $this->judgeTopLeft($up, $mx_v, $mx_d, $board);
            $this->judgeTopRight($up, $mx_v, $mx_d, $board);
            return;
        }


        $this->judgeTopLeft($up, $mx_v, $mx_d, $board);
        //优先考虑四重
        if ($mx_d[$up->x][$up->y + 1] == DIREC_LEFT) {
            //   X
            // ? ← ?
            //   X
            //   X
            $mx_v[$up->x][$up->y + 1] = $this::SCORE_4_BOXES;
            return;
        }

        $this->judgeTopRight($up, $mx_v, $mx_d, $board);
        if ($mx_d[$up->x][$up->y + 1] == DIREC_RIGHT) {
            //   X
            // ? → ?
            //   X
            //   X
            $mx_v[$up->x][$up->y + 1] = $this::SCORE_4_BOXES;
            return;
        }

        //无四重 ↔ 无收益 考虑上下

        if ($mx_d[$up->x][$up->y + 1] != DIREC_UP
            && $mx_v[$up->x][$up->y + 1] < $this::SCORE_3_BOXES) {

            $mx_d[$up->x][$up->y + 1] = DIREC_UP;
            $mx_v[$up->x][$up->y + 1] = $this::SCORE_3_BOXES; // change new dirct

        }


    }


    /**  横块下角
     * //   X
     * //   X
     * // ? O ?
     * //   X
     * @param $down
     * @param array $mx_v
     * @param array $mx_d
     * @param array $board
     */
    private function judgeDown($down, array & $mx_v, array &$mx_d, array &$board)
    {
        $line_num = sizeof($board[0]);
        // 横块下角
        //   X
        //   X
        // ? O ?
        //   X
        if (!($down->y + 2 < $line_num && $board[$down->x][$down->y + 2] == $down->value)) {
            $this->judgeDownLeft($down, $mx_v, $mx_d, $board);
            $this->judgeDownRight($down, $mx_v, $mx_d, $board);
            return;
        }


        $this->judgeDownLeft($down, $mx_v, $mx_d, $board);
        //优先考虑四重
        if ($mx_d[$down->x][$down->y - 1] == DIREC_LEFT) {
            //   X
            //   X
            // ? ← ?
            //   X
            $mx_v[$down->x][$down->y - 1] = $this::SCORE_4_BOXES;
            return;
        }

        $this->judgeDownRight($down, $mx_v, $mx_d, $board);
        if ($mx_d[$down->x][$down->y - 1] == DIREC_RIGHT) {
            //   X
            //   X
            // ? → ?
            //   X
            $mx_v[$down->x][$down->y - 1] = $this::SCORE_4_BOXES;
            return;
        }

        //无四重 ↔ 无收益 考虑上下

        if ($mx_d[$down->x][$down->y - 1] != DIREC_DOWM
            && $mx_v[$down->x][$down->y - 1] < $this::SCORE_3_BOXES) {

            $mx_d[$down->x][$down->y - 1] = DIREC_DOWM;
            $mx_v[$down->x][$down->y - 1] = $this::SCORE_3_BOXES; // change new dirct

        }


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
                if ($y <= $line_num - 2 || sizeof($same_cols[$key_y]) > 0) {
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
                        && sizeof($all_same_lines[$y][$key_x]) >= 2) {//in order to count 2 size

                        $key_x++; //if save over 23 boxes -> is valid data, key++ ,init
                    }
                    $all_same_lines[$y][$key_x] = [];//init

                }

                // x still can connect over 3  or already has parts-boxs add last 3 box
                if ($x <= $col_num - 2) {
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
                if (sizeof($boxes) < 2) {
                    continue;
                }

                if ($boxes[0]->value == $this::ICON_NULL_ID) {
                    continue;
                }

                if (sizeof($boxes) == 2) { //save for count next step
                    $line_two_connected[] = $boxes;
                } else {
                    $line_connected[] = $boxes;
                }
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

                if (sizeof($boxes) < 2) {
                    continue;
                }

                if ($boxes[0]->value == $this::ICON_NULL_ID) {
                    continue;
                }

                if (sizeof($boxes) == 2) { //save for count next step
                    $col_two_connected[] = $boxes;
                } else {
                    $col_connected[] = $boxes;
                }

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

//            echo json_encode($connected_boxes[2]);
//            echo "<br/>";
//            echo "<br/>";
//            echo json_encode($connected_boxes[3]);
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

