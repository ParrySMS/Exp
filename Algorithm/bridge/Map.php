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
    public function getConNum():int
    {
        //init visit[]
        foreach ( $this->isVisit as & $vi) {
            $vi = false;
        }

        for($num=0,$i=0;$i<$this->n;$i++){
            if(!$this->isVisit[$i]){
                $this->BFS($i);
                $num++;
            }
        }

        return $num;

    }


    public function removeEdge()
    {
        $num1 = $this->getConNum();
        //for all edge
        for ($i = 0; $i < $this->n; $i++) {
            for ($j = $i + 1; $j < $this->n; $j++) {
                //remove one edge
                if($this->mx[$i][$j]==1){
                    //set -1 mean cut
                    $this->mx[$i][$j] = -1;
                    $this->mx[$j][$j] = -1;

                }

            }
        }
    }


    private function BFS(int $start_node)
    {
        $this->isVisit[$start_node] = true;
        $queue = new Queue();

        //find connect
        for($i=0;$i<$this->n;$i++){
            if($this->mx[$start_node][$i] >0 //connected
                && !$this->isVisit[$i]){ //not visit
                $queue->push($i);
            }
        }

        while(!$queue->empty()){
            $this->BFS($queue->front());
        }

    }

}