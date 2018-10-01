<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-9-28
 * Time: 21:54
 */

require "./Medoo/Medoo.php";
require "./Medoo/database_info.php";
require "Node.php";
require "SingleLInkList.php";


use Medoo\Medoo;

date_default_timezone_set('Asia/Shanghai');

class Sort
{
    protected $database;
    protected $table;

    /**
     * BaseDao constructor.
     */
    public function __construct()
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

        $this->table = "exp_sort";
    }

    /** 记录一次执行时间
     * @param $funcname
     * @param $len
     * @param $num
     * @param $exc_time
     * @throws Exception
     */
    public function exc_log($funcname,$len,$num,$exc_time){

        $pdo = $this->database->insert($this->table,[
            'funcname'=>$funcname,
            'len'=>$len,
            'sample_num'=>$num,
            'exc_time'=>$exc_time,
            'log_time'=>date('Y-m-d H:i:s'),
            'visible'=>1
        ]);

        $id = $this->database->id();

        if (!is_numeric($id) || $id < 1) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():   error');
        }

    }


    /** 冒泡排序
     * @param array $ar
     * @param null $len
     */
    public function bubble(array & $ar, $len = null)
    {
        if ($len === null) {
            $len = sizeof($ar);
        }

        for ($i = 0; $i < $len; $i++) {
            for ($j = $i + 1; $j < $len; $j++) {

                if ($ar[$i] > $ar[$j]) {//swap
                    $t = $ar[$i];
                    $ar[$i] = $ar[$j];
                    $ar[$j] = $t;
                }
            }
        }

    }


    /** 基于链表实现的插入排序
     * @param array $ar
     * @param null $len
     * @param bool $need_show
     */
    public function insertLink(array $ar, $len = null, $need_show = false)
    {
        if ($len === null) {
            $len = sizeof($ar);
        }

        $order = new SingleLinkList();
        for ($i = 0; $i < $len; $i++) {//i for ar index

            if ($order->len == 0) {//empty order
                $order->add(new Node($ar[$i]));

            } else {//compare one by one
                $node = $order->get(1);

                for ($j = 1; $j <= $order->len + 1; $j++, $node = $node->next) {
                    //j for node index,next one -> node++ j++,
                    // link :: head-->1-->2-....->len->null , so j from 1 to len+1

                    if (is_null($node)) {//j to the end
                        $order->add(new Node($ar[$i]));
                        break;
                    }

                    if ($node->data >= $ar[$i]) {//add into
                        $order->add(new Node($ar[$i]), $j);
                        break;
                    }
                }


            }
        }

        if($need_show) {
            $order->show();
        }
    }


    /** 归并排序 先拆左右 在两两合并
     * @param array $ar
     * @param null $len
     * @return array
     */
    public function merge(array $ar, $len = null)
    {
        if ($len === null) {
            $len = sizeof($ar);
        }

        if ($len <= 1) {//len = 1 finish cuting
            return $ar;
        }

        //len>1 --> need sort and merge left and right

        //cut into 2 part -- left and right
        $mid = $mid = intval($len / 2);

        // 0 - mid xxxxx
        $left = array_slice($ar, 0, $mid);
        //  xxxx mid - end
        $right = array_slice($ar, $mid);

        $left = $this->merge($left);//continue cut into 2 part until len = 1
        $right = $this->merge($right);

        //get the smallest sorted unit to merge (len is decided by last function result)
        $merge = [];

        $len_left = sizeof($left);
        $len_right = sizeof($right);

        //init index, i for left ,j for right
        $i = $j = 0;
        //put left and right into merge by sorting
        while (sizeof($merge) < $len_left + $len_right) {

            if ($i < $len_left //still has left
                && ($j == $len_right || $left[$i] <= $right[$j])) { //right is over or left is smaller --> add left into merge
                $merge[] = $left[$i];
                $i++;

            } else if ($j < $len_right //still has right
                && ($i == $len_left || $left[$i] > $right[$j])) {//left is over or right is smaller --> add left into merge
                $merge[] = $right[$j];
                $j++;
            }
        }
        return $merge;

    }


    /** 快速排序 找基准数 左右分组交换至左小右大
     * @param array $ar
     * @param int $left
     * @param null $right
     */
    public function quick(array & $ar, $left = 0, $right = null)
    {

        //default left = 0 ,right = len-1
        if ($right === null) {
            $right = sizeof($ar) - 1;
        }

        if ($left >= $right) {//not need to sort
            return;
        }

        //mark the default value
        $first_index = $left;
        $last_index = $right;

        $key = $ar[$left];//default key as first element

        while ($left != $right) {//find 2 swap element to sort into 2 parts

            while ($ar[$right] >= $key && $left < $right) { // [l--r] is [small--big]
                $right--;
            }//until a[r] < key

            while ($ar[$left] <= $key && $left < $right) {
                $left++;
            }//until a[l] > key

            if ($left < $right) { //swap
                $t = $ar[$left];
                $ar[$left] = $ar[$right];
                $ar[$right] = $t;
            }

        }//finish 2 sorted parts

        //left == right == mid

        if ($first_index != $left) {//first_index == mid_index not need to swap, just len = 1

            //put mid to first(location of key)
            $ar[$first_index] = $ar[$left];
            //put key into mid
            $ar [$left] = $key;
        }
        //continue cut and sort
        //left == right == mid
        $this->quick($ar, $first_index, $left - 1);
        $this->quick($ar, $left + 1, $last_index);

    }

    /** 选择排序
     * @param array $ar
     * @param null $len
     */
    public function selection(array & $ar, $len = null)
    {
        if ($len === null) {
            $len = sizeof($ar);
        }

        for ($i = 0; $i < $len - 1; $i++) {
            $min = $i; //consider i as min_index

            for ($j = $i + 1; $j < $len; $j++) {//find min_index
                if($ar[$j]<$ar[$min]){
                    $min = $j;
                }
            }
            //check min_index and swap
            if($min!=$i){//change
                $t = $ar[$i];
                $ar[$i]=$ar[$min];
                $ar[$min] = $t;
            }
        }
    }

    public function insertAr(array $ar, $len = null, $insert_way = 0)
    {

        if ($len === null) {
            $len = sizeof($ar);
        }

        $order = [];
        for ($i = 0; $i < $len; $i++) {//i for ar index

            if (sizeof($order) == 0) {//empty order
                $order[] = $ar[$i];

            } else {//compare one by one

                $size = sizeof($order);

                for ($j = 0; $j < $size; $j++) {

                    $data = $order[$j];

                    if ($j == ($size - 1)) {//j to the end
                        $order[] = $ar[$i];
                        break;
                    }

                    if ($data >= $ar[$i]) {//add into

                        if ($insert_way == 1) {
                            $this->cutAdd($order, $j, $ar[$i]);
                        } else {
                            $this->moveAdd($order, $j, $ar[$i]);
                        }

                        break;
                    }
                }


            }

        }

    }


    private function cutAdd(& $ar, $index, $data)
    {
        $left = array_slice($ar, 0, $index);
        $right = array_slice($ar, $index);

        $left[] = $data;

        $ar = array_merge($left, $right);

    }


    private function moveAdd(& $ar, $index, $data)
    {
        $len = sizeof($ar);
        $ar[$len] = null;
        for ($i = $len - 1; $i >= $index; $i--) {
            $ar[$i + 1] = $ar[$i];
        }

        $ar[$index] = $data;
    }


}