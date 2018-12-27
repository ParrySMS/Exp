<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-12-25
 * Time: 23:00
 *
 * Version: PHP 7
 */

class Map
{
    public $mx = [];
    public $isVisit = [];
    public $n;//点数
    public $e;//边数据


    /** 生产地图矩阵 并且设置访问数组
     * Map constructor.
     * @param $n int 节点数
     * @param $e int 边数
     * @param bool $setRand 是否产生随机边
     */
    public function __construct(int $n, int $e, bool $setRand = true)
    {
        $this->n = $n;
        $this->e = $e;

        //初始化矩阵
        for ($i = 0; $i < $n; $i++) {
            $this->isVisit[$i] = false;
            $this->mx[$i] = [];
            for ($j = 0; $j < $n; $j++) {
                $this->mx[$i][$j] = 0;
            }
        }
        if ($setRand) {
            //把每一条边加上去
            for ($i = 0; $i < $e; $i++) {
                $n1 = rand(0, $n - 1);
                $n2 = rand(0, $n - 1);
                $this->mx[$n1][$n2] = $this->mx[$n2][$n1] = 1;
            }
        }
    }

    /** 计算连通树
     * @return int
     */
    public function getConNum(): int
    {
        //init visit[]
        foreach ($this->isVisit as & $vi) {
            $vi = false;
        }


        for ($num = 0, $i = 0; $i < $this->n; $i++) {
            if (!$this->isVisit[$i]) {
//                echo "outer BFS($i)" . PHP_EOL;
                $this->BFS($i);
                $num++;
            }
        }

        return $num;
    }


    /** 穷举基准算法 切边返回找到的桥数目
     * @return int
     */
    public function removeEdge(): int
    {
        $bridge_num = 0;
        $num1 = $this->getConNum();
        //for all edge
        for ($i = 0; $i < $this->n-1; $i++) {
            for ($j = $i + 1; $j < $this->n; $j++) {
                //remove one edge
                if ($this->mx[$i][$j] == 1) {
                    //set -1 mean cut
                    $this->mx[$i][$j] = -1;
                    $this->mx[$j][$j] = -1;
                    $num2 = $this->getConNum();

                    if ($num2 != $num1) {
                        $bridge_num++;

                        echo "bridge[$bridge_num]: $i--$j" . PHP_EOL;

                    }

                }//end if ($this->mx[$i][$j] == 1)
                //get params back to origin value
                $this->mx[$i][$j] = $this->mx[$j][$j] = 1;
            }//end for j
        }//end for i

        echo "num:$bridge_num" . PHP_EOL;
        return $bridge_num;
    }



    /**
     * 标记环边的算法
     * @return int
     */
    public function markCircleEdge():int
    {
        $num1 = $this->getConNum();
        for($i=0; $i<$this->e; i++) {
            if($this->kruForCirEdge() == false) {//找不到边了 跳出
                break;
            }
        }

    $bridge_num = 0
        //left most edge may bridge
    for ($i = 0; $i < $this->n-1; $i++) {
            for ($j = $i + 1; $j < $this->n; $j++) {
                //remove one edge
                if ($this->mx[$i][$j] == 1) {
                    //set -1 mean cut
                    $this->mx[$i][$j] = -1;
                    $this->mx[$j][$j] = -1;
                    $num2 = $this->getConNum();

                    if ($num2 != $num1) {
                        $bridge_num++;

                        echo "bridge[$bridge_num]: $i--$j" . PHP_EOL;

                    }

                }//end if ($this->mx[$i][$j] == 1)
                //get params back to origin value
                $this->mx[$i][$j] = $this->mx[$j][$j] = 1;
            }//end for j
        }//end for i

        echo "num:$bridge_num" . PHP_EOL;
        return $bridge_num;

    }


    private function kruForCirEdge():bool
    {//it will change the value of some edges, value may larger

        

    }

    /** 广度优先遍历
     * @param int $start_node
     */
    private function BFS(int $start_node)
    {
//        echo $start_node . PHP_EOL;

        $this->isVisit[$start_node] = true;
        $queue = new Queue();
        //find connect
        for ($i = 0; $i < $this->n; $i++) {
            if ($this->mx[$start_node][$i] > 0 //connected
                && !$this->isVisit[$i]) { //not visit
//                echo "inner push ($i)" . PHP_EOL;
                $queue->push($i);
            }
        }
//        echo json_encode($queue->data) . PHP_EOL;

        //recursion
        while (!$queue->empty()) {
//            echo "a recursion" . PHP_EOL;
            $this->BFS($queue->front());
//            echo "end a recursion and ready pop" . PHP_EOL;
            $queue->pop();
//            echo json_encode($queue->data) . PHP_EOL;
        }
    }

}