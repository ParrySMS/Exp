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
    public $node_num;//点数
    public $edge_num;//边数

    public function echoMx():void
    {
        //ECHO MX
        for ($i = 0; $i < $this->node_num; $i++) {
            for ($j = 0; $j < $this->node_num; $j++) {
                echo $this->mx[$i][$j].' ';
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;

    }

    /** 生产地图矩阵 并且设置访问数组
     * Map constructor.
     * @param $n int 节点数
     * @param $e int 边数
     * @param bool $setRand 是否产生随机边
     */
    public function __construct(int $n, int $e, bool $setRand = true)
    {
        $this->node_num = $n;
        $this->edge_num = $e;

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


        for ($num = 0, $i = 0; $i < $this->node_num; $i++) {
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
//        $this->echoMx();

        $bridge_num = 0;
        $num1 = $this->getConNum();
        //for all edge
        for ($i = 0; $i < $this->node_num - 1; $i++) {
            for ($j = $i + 1; $j < $this->node_num; $j++) {
                //remove one edge
                if ($this->mx[$i][$j] == 1) {
                    //set -1 mean cut
                    $this->mx[$i][$j] = -1;
                    $this->mx[$j][$i] = -1;
                    $num2 = $this->getConNum();
                    //get params back to origin value
                    $this->mx[$i][$j] = 1;
                    $this->mx[$j][$i] = 1;

                    if ($num2 != $num1) {
                        $bridge_num++;
                        echo "bridge[$bridge_num]: $i--$j" . PHP_EOL;
                    }

                }//end if ($this->mx[$i][$j] == 1)
            }//end for j
        }//end for i

//        $this->echoMx();
        echo "num:$bridge_num" . PHP_EOL;
        return $bridge_num;
    }


    /**
     * 标记环边的算法
     * @return int
     */
    public function markCircleEdge(): int
    {
//        $this->echoMx();

        $num1 = $this->getConNum();
        for ($i = 0; $i < $this->edge_num; $i++) {
            if (!$this->kruForCirEdge()) {//找不到边了 跳出
                break;
            }
        }

//        $this->echoMx();


        $bridge_num = 0;
        //left most edge may bridge
        for ($i = 0; $i < $this->node_num - 1; $i++) {
            for ($j = $i + 1; $j < $this->node_num; $j++) {
                //remove one edge
                if ($this->mx[$i][$j] == 1) {
                    //set -1 mean cut
                    $this->mx[$i][$j] = -1;
                    $this->mx[$j][$i] = -1;
                    $num2 = $this->getConNum();
                    //get params back to origin value
                    $this->mx[$i][$j] = 1;
                    $this->mx[$j][$i] = 1;

                    if ($num2 != $num1) {
                        $bridge_num++;
                        echo "bridge[$bridge_num]: $i--$j" . PHP_EOL;
                    }

                }//end if ($this->mx[$i][$j] == 1)
            }//end for j
        }//end for i

        echo "num:$bridge_num" . PHP_EOL;
        return $bridge_num;

    }


    /** 最小生成树遍历标记一个环边
     * @return bool
     */
    private function kruForCirEdge(): bool
    {//it will change the value of some edges, value may larger
        unset($edges);
        $edges = [];

        //save all edge
        for ($i = 0; $i < $this->node_num - 1; $i++) {
            for ($j = $i + 1; $j < $this->node_num; $j++) {
                if ($this->mx[$i][$j] == 1) {
                    $edges[] = new CloseEdge($i, $j, $this->mx[$i][$j]);
                }
            }
        }

        //sort the edges, larger in front, easy to find circle
        $len = sizeof($edges);
        for ($i = 0; $i < $len - 1; $i++) {
            $max_index = $i;
            for ($j = $max_index+1; $j < $len; $j++) {
                if ($edges[$j]->value > $edges[$max_index]->value) {
                    $max_index = $j;
                }
            }

            if ($max_index != $i) {
                $m_fr = $edges[$max_index]->from;
                $m_to = $edges[$max_index]->to;
                $m_vl = $edges[$max_index]->value;

                //swap
                $edges[$max_index] = $edges[$max_index]->init(
                    $edges[$i]->from,
                    $edges[$i]->to,
                    $edges[$i]->value
                );

                $edges[$i] = $edges[$i]->init($m_fr, $m_to, $m_vl);
            }
        }

        //mark the cir edge
        $set = new UFSet($this->node_num);//Union-Find set
        $found = false;
//        echo json_encode($edges).PHP_EOL;

        foreach ($edges as $e) {
            //find in set
            $set_id_from = $set->find($e->from);
            $set_id_to = $set->find($e->to);


            if($set_id_from == $set_id_to){//same set, may has cir
//                echo "from:$e->from ,to:$e->to".PHP_EOL;
//                echo "set_id_from:$set_id_from ,set_id_to:$set_id_to".PHP_EOL;

                if($this->mx[$e->from][$e->to] == 1) { //connected
                    $found = true;
//                    echo 'mark'.PHP_EOL;
                    $this->mx[$e->from][$e->to]++;
                    $this->mx[$e->to][$e->from]++;

                }// no connect , no operation

            }else{//diff set
                $set->union($e->from,$e->to);
            }
        }//end foreach

        unset($edges);
        return $found;
    }

    /** 广度优先遍历
     * @param int $start_node
     */
    private function BFS(int $start_node):void
    {
//        echo $start_node . PHP_EOL;

        $this->isVisit[$start_node] = true;
        $queue = new Queue();
        //find connect
        for ($i = 0; $i < $this->node_num; $i++) {
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