<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-1-3
 * Time: 23:08
 */
namespace maxflow;
define('MAX_FLOW',9999999);

$cmd=fopen("php://stdin", "r");//打开命令行的输入文件流 用于读入输入的参数

$t = fgets($cmd);//获取输入的参数

for( $i=1; $i<=$t; $i++) {
    $n = fgets($cmd);//获取输入的参数
    $m = fgets($cmd);//获取输入的参数

    $start = 1;  //源点
    $end = $n; //汇点

    //初始化矩阵
    $mx = [];
    $isVisit = [];
    for( $j=0; $j<=$n; $j++) {
        $mx[$j] = [];
        $isVisit[$j] = false;
        for( $k=0; $k<=$n; $k++) {
            $mx[$j][$k] = 0;
        }
    }

    for( $j=0; $j<=$m; $j++) {
        $v0 = fgets($cmd);
        $vt = fgets($cmd);
        $c = fgets($cmd);
        $mx[$v0][$vt] += $c;
    }

    $flow = getMaxFlow($start,$end);
    echo "Case $k: $flow".PHP_EOL;
}

fclose($cmd);//关闭命令行的输入流



function getMaxFlow(int $start,int $end):int
{
    global $n;
    $flow = 0;
	while(BFS($start,$n)) {

	    global  $mx;
	    global  $pre;

        $min_allow_flow = MAX_FLOW;
		for( $i=$end; $i!=$start; $i=$p) { //BFS遍历结束
            $p = $pre[$i];
            $min_allow_flow = $mx[$p][$i] < $min_allow_flow ? $mx[$p][$i] : $min_allow_flow;
        }


        for( $i=$end; $i!=$start; $i=$p) {
            $p = $pre[$i];
            $mx[$p][$i]-=$min_allow_flow; //反边
            $mx[$i][$p]+=$min_allow_flow; //正边
        }
		$flow += $min_allow_flow;
	}

	return $flow;
}


//todo
function BFS(int $start_node,int $node_num):bool
{

    global $isVisit;
    global $end;
    $isVisit[$start_node] = true;
    $queue = new Queue();
    //find connect
    for ($i = 0; $i < $node_num; $i++) {
        if ($this->mx[$start_node][$i] > 0 //connected
            && !$isVisit[$i]) { //not visit
            $queue->push($i);
        }
    }

    //recursion
    while (!$queue->empty()) {
        $head = $queue->front();
        $queue->pop();
        if($head == $end){
            return true;
        }

    }
    return false;
}


function echoMx():void
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


function initMx(int $n,int $e, bool $setRand = true)
{
//初始化矩阵
    for ($i = 0; $i < $n; $i++) {
        $this->isVisit[$i] = false;
        $this->mx[$i] = [];
        for ($j = 0; $j < $n; $j++) {
            $this->mx[$i][$j] = 0;
        }
    }
    if ($setRand) {
        //把每一条边加上去 随机
        for ($i = 0; $i < $e; $i++) {
            $n1 = rand(0, $n - 1);
            $n2 = rand(0, $n - 1);
            $this->mx[$n1][$n2] = $this->mx[$n2][$n1] = 1;
        }
    }
}