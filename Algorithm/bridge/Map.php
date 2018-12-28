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
    public $level = [];
    public $layer = 0;
    public $node_num;//点数
    public $edge_num;//边数
    public $try = false;

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
//                        echo "bridge[$bridge_num]: $i--$j" . PHP_EOL;
                    }

                }//end if ($this->mx[$i][$j] == 1)
            }//end for j
        }//end for i

//        $this->echoMx();
//        echo "num:$bridge_num" . PHP_EOL;
        return $bridge_num;
    }


    /**
     * 标记环边的算法
     * @throws Exception
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
//                        echo "bridge[$bridge_num]: $i--$j" . PHP_EOL;
                    }else if($this->try) {
                        $this->mx[$i][$j] ++;
                        $this->mx[$j][$i] ++;
                    }

                }//end if ($this->mx[$i][$j] == 1)
            }//end for j
        }//end for i

//        echo "num:$bridge_num" . PHP_EOL;
        return $bridge_num;

    }


    /**
     * @param int $mark_v0
     * @param int $mark_v1
     * @throws Exception
     */
    private function BFSMarkAllCirEdge(int $mark_v0,int $mark_v1):void
    {//it will change the value of some edges, value may larger
        //init visit[]
        foreach ($this->isVisit as & $vi) {
            $vi = false;
        }

        unset($this->level);
        $this->level = [];
        $this->level[0] = [];
        $this->level[0][0] = $mark_v0;
        $this->layer = 1;

        //递归
        $final = $this->BFSMark($mark_v0,$mark_v0,$mark_v1);
//        if($final<0){
//            throw new Exception(__FUNCTION__.'() error,$final == -1,no path.',500);
//        }
        if($final>0) {
            //得到一个BFS层矩阵
            //倒着标记路径
            $this->mx[$final][$mark_v1]++;
            for ($i = $this->layer, $node = $final; $i > 0; $i--) {
                $head = $this->level[$i][0];
                if (in_array($node, $this->level[$i]) && $head != $node) {
                    $this->mx[$head][$node]++;
                    //to pre
                    $node = $head;
                }
            }
        }

    }
    /** 最小生成树遍历标记一个环边
     * @throws Exception
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
                    //todo try
//                    echo 'mark ++'.PHP_EOL;
//                    $this->echoMx();
                    if($this->try) {
                        $this->BFSMarkAllCirEdge($e->from, $e->to);
                    }
//                    $this->echoMx();
                }// no connect , no operation

            }else{//diff set
                $set->union($e->from,$e->to);
            }
        }//end foreach

        unset($edges);
        return $found;
    }


    /** BFS用层标记环边的遍历过程
     * @param int $mark_v0
     * @param int $start_node
     * @param $mark_v1
     * @return int
     */
    private function BFSMark(int $mark_v0,int $start_node,int $mark_v1):int
    {

        $this->level[$this->layer] = [];
        $this->level[$this->layer][0] = $start_node;//0-->head-->father

//        echo "start_node:$start_node".PHP_EOL;
//        echo "layer:$this->layer.".PHP_EOL;
//        echo 'level:'.json_encode($this->level).PHP_EOL;

        $this->isVisit[$start_node] = true;
        if($this->mx[$start_node][$mark_v1] && $start_node != $mark_v0){
            return $start_node;
        }

        $queue = new Queue();

        //find connect
        for ($i = 0; $i < $this->node_num; $i++) {
            if ($this->mx[$start_node][$i] > 0 //connected
                && $i!=$start_node
                && $i!=$mark_v1
                && !$this->isVisit[$i]) { //not visit
//                echo "inner push ($i)" . PHP_EOL;
                $queue->push($i);
                $this->level[$this->layer][] =$i;
            }
        }
        $this->layer++;
//        echo 'after find connected:'.PHP_EOL;

//        echo 'level:'.json_encode($this->level).PHP_EOL;

        //recursion
        $final = -1;
        while (!$queue->empty()) {
//            echo "a recursion" . PHP_EOL;
            $final = $this->BFSMark($mark_v0,$queue->front(),$mark_v1);
//            echo "end a recursion and ready pop" . PHP_EOL;
            $queue->pop();
//            echo "final:$final".PHP_EOL;
            return $final;
//            echo json_encode($queue->data) . PHP_EOL;
        }

        return $final;
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