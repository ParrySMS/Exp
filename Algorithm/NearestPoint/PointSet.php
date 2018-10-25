<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-10-23
 * Time: 21:59
 */
require "./Medoo/Medoo.php";
require "./Medoo/database_info.php";

use Medoo\Medoo;

date_default_timezone_set('Asia/Shanghai');

class PointSet
{
    private $num;
    public $set = [];
    const MAX_DIS = 99999999;
    protected $database;
    protected $table = 'exp_sort';


    /** 默认生成一个大小为100的点集
     * Point constructor.
     * @param $num
     * @param array $set
     */
    public function __construct($num = 100)
    {
        $this->num = $num;
        $this->createSet();
    }


    /** 创建一个大小为num的点集 默认重置模式
     * 可以选择为集合添加模式
     * x y 的默认参数范围是[0-10000]
     * @param bool $reset 是否重置当前集合
     * @param null $num 集合大小
     * @param int $x_min
     * @param int $x_max
     * @param int $y_min
     * @param int $y_max
     */
    public function createSet($reset = true, $num = null, $x_min = 0, $x_max = 10000, $y_min = 0, $y_max = 10000)
    {
        if ($num === null) {
            $num = $this->num;
        }

        if ($reset) {
            $this->set = [];
        }


        for ($i = 0; $i < $num; $i++) {

            $x = rand($x_min, $x_max);//ar[0]
            $y = rand($y_min, $y_max);//ar[1]

            //put in set
            $this->set [] = [$x, $y];
        }
    }


    /** 求集合内某序号两点之间距离
     * @param $index1
     * @param $index2
     * @return float
     */
    public function disInSet($index1, $index2, $set = null)
    {
        if ($set === null) {
            $set = $this->set;
        }

        $lx = $set[$index1][0] - $set[$index2][0];
        $ly = $set[$index1][1] - $set[$index2][1];
        return sqrt($lx * $lx + $ly * $ly);
    }

    /** 求两点距离
     * @param array $p1
     * @param array $p2
     * @return float
     */
    public function distance(array $p1, array $p2)
    {
        return sqrt(pow($p1[0] - $p2[0], 2) + pow($p1[1] - $p2[1], 2));

    }

    /**随机获取一个点
     * @return mixed
     */
    public function getPoint()
    {
        $index = rand(0, sizeof($this->set));
        return $this->set[$index];
    }

    /** 基于某个唯独获取点集的排序序列数字 （由小到大）
     * @param $var
     * @return array|null
     */
    public function getSortIndex($var, array $set = null)
    {
        switch ($var) {
            case 'X':
            case 'x':
                $dim_var = 0;
                break;
            case 'Y':
            case 'y':
                $dim_var = 1;
                break;
            default :
                return null;
        }

        if ($set === null) {
            $set = $this->set;
        }

        $size = sizeof($set);

        //fill index
        unset($indexs);
        $indexs = [];
        for ($i = 0; $i < $size; $i++) {
            $indexs[] = $i;
        }


        //sort
        for ($i = 0; $i < $size - 1; $i++) {
            $min_index = $i; //consider i as min_index

            for ($j = $i + 1; $j < $size; $j++) {//find min_index

                $p_index = $indexs[$j];
                $p_min_index = $indexs[$min_index];

                if ($set[$p_index][$dim_var]
                    <= $set[$p_min_index][$dim_var]) {

                    $min_index = $j;

                }
            }
            //check min_index and swap
            if ($min_index != $i) {//change

                $t = $indexs[$i];
                $indexs[$i] = $indexs[$min_index];
                $indexs[$min_index] = $t;
            }

        }

        return $indexs;
    }

    public function getMinLine(array $set = null)
    {

        if ($set === null) {
            $set = $this->set;
        }

        $size = sizeof($set);


        if ($size <= 3) {//small

            $min_dis = null;

            if ($size == 0) {
                $line = new Line(null, [], null, [], $this::MAX_DIS);

            } elseif ($size == 1) {
                $line = new Line(null, $set[0], null, $set[0], $this::MAX_DIS);

            } else {
                foreach ($set as $p1) {
                    foreach ($set as $p2) {
                        if ($p2 === $p1) {
                            continue;
                        }

                        $dis = $this->distance($p1, $p2);
                        if ($min_dis == null || $dis < $min_dis) {
                            $min_dis = $dis;
                            $line = new Line(null, $p1, null, $p2, $dis);
                        }
                    }
                }
            }

            return $line;


        } else {// big >3 ,divide into

            $x_indexs = $this->getSortIndex('x', $set);
            $x_min_point = $set[$x_indexs[0]];
            $x_mid_point = $set[$x_indexs[intval(sizeof($x_indexs) / 2)]];
            $x_max_point = $set[$x_indexs[sizeof($x_indexs) - 1]];


            $new_set = $this->divideSet('x', $x_min_point[0], $x_mid_point[0], $x_max_point[0], $set);
            $x_leftSet = $new_set['left'];
            $x_rightSet = $new_set['right'];

//            var_dump($new_set);

            $line_l = $this->getMinLine($x_leftSet);
            $line_r = $this->getMinLine($x_rightSet);

            $small_line = $line_l->dis < $line_r->dis ? $line_l : $line_r;
            $small_d = $small_line->dis;

            // fix edge

            $min = $x_mid_point[0] - $small_d;
            $mid = $x_mid_point[0];
            $max = $x_mid_point[0] + $small_d;

            $fix_set = $this->divideSet('x', $min, $mid, $max, $set);
            $left_set = $fix_set['left'];
            $right_set = $fix_set['right'];

            $left_y_indexs = $this->getSortIndex('y', $fix_set['left']);
            $right_y_indexs = $this->getSortIndex('y', $fix_set['right']);

            $fix_dis = $this::MAX_DIS;
            foreach ($left_y_indexs as $l_index) {
                foreach ($right_y_indexs as $r_index) {

                    if (!$this->inRightArea($left_set[$l_index], $right_set[$r_index], $small_d)) {
                        break;//next left point
                    }

                    //in right
                    $fix_dis = $this->distance($left_set[$l_index], $right_set[$r_index]);

                    if ($fix_dis < $small_d) {
                        $small_d = $fix_dis;
                        $line = new Line($l_index, $left_set[$l_index], $r_index, $right_set[$r_index], $fix_dis);
                    }

                }
            }

            $line = ($small_d == $fix_dis) ? $line : $small_line;

            return $line;

        }

    }

    /** 检查p2是否在p1的右方合理范围
     * @param array $p1
     * @param array $p2
     * @param $d
     * @return bool
     */
    private function inRightArea(array $p1, array $p2, $d)
    {
        return (($p2[0] < $p1[0] + $d) && ($p2[1] > $p1[1] - $d) && ($p2[1] < $p1[1] + $d));

    }


    /** 根据指定参数与范围划分点集 返回一个数组 left right分别是两个子点集
     * @param $var
     * @param $min
     * @param $mid
     * @param $max
     * @param $set
     * @return array|null
     */
    public function divideSet($var, $min, $mid, $max, array $set = null)
    {
        switch ($var) {
            case 'X':
            case 'x':
                $dim_var = 0;
                break;
            case 'Y':
            case 'y':
                $dim_var = 1;
                break;
            default :
                return null;
        }

        if ($set === null) {
            $set = $this->set;
        }

        $left = [];
        $right = [];
        foreach ($set as $point) {
            if ($point[$dim_var] >= $min && $point[$dim_var] < $mid) {
                $left[] = $point;
            } elseif ($point[$dim_var] >= $mid && $point[$dim_var] < $max) {
                $right[] = $point;

            }
        }


        return ['left' => $left, 'right' => $right];
    }

    public function exc_log($funcname, $len, $num, $exc_time)
    {

        $this->database = new Medoo([
            'database_type' => DATABASE_TYPE,
            'database_name' => DATABASE_NAME,
            'server' => SERVER,
            'username' => USERNAME,
            'password' => PASSWORD,
            'charset' => CHARSET,
            'port' => PORT,
            'check_interval' => CHECK_INTERVAL
        ]);


        $pdo = $this->database->insert($this->table, [
            'funcname' => $funcname,
            'len' => $len,
            'sample_num' => $num,
            'exc_time' => $exc_time,
            'log_time' => date('Y-m-d H:i:s'),
            'visible' => 1
        ]);

        $id = $this->database->id();

        if (!is_numeric($id) || $id < 1) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():   error');
        }

    }


}