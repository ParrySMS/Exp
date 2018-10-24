<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-10-23
 * Time: 21:59
 */

class Point
{
    private $num;
    public $set = [];

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


    /** 求两点之间距离
     * @param $index1
     * @param $index2
     * @return float
     */
    public function distance($index1, $index2)
    {

        $lx = $this->set[$index1][0] - $this->set[$index2][0];
        $ly = $this->set[$index1][1] - $this->set[$index2][1];
        return sqrt($lx * $lx + $ly * $ly);
    }


    /**随机获取一个点
     * @return mixed
     */
    public function getPoint()
    {
        $index = rand(0, sizeof($this->set));
        return $this->set[$index];
    }


    public function divide(array $set)
    {
        $size = sizeof($set);

        if ($size <= 3) {//small
            $min_dis = 9999999;
            for ($i = 0; $i < $size; $i++) {//get point
                for ($j = 0; $j < $size; $j++) {//count others point
                    if ($j == $i) {//no need to count itself
                        continue;
                    }

                    $dis = $this->distance($i, $j);
                    if ($dis < $min_dis) {
                        $min_dis = $dis;
                        $line = new Line($i, $this->set[$i], $j, $this->set[$j], $dis);
                    }
                }
            }
        }else{//todo big >3 ,divide into

        }

    }


}