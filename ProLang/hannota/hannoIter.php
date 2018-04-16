<?php

/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-4-17
 * Time: 2:38
 */
class Params{
    public $id;
    public $num;
    public $first;
    public $middle;
    public $end;
    public $counter;

    /**
     * Params constructor.
     * @param $num
     * @param $first
     * @param $middle
     * @param $end
     * @param $counter
     */
    public function __construct($id,$num, $first, $middle, $end, $counter)
    {
        $this->id = $id;
        $this->num = $num;
        $this->first = $first;
        $this->middle = $middle;
        $this->end = $end;
        $this->counter = $counter;
    }

}

function hanIter($id,$num, $first, $middle, $end, $counter)
{
    $stack =init($id,$num, $first, $middle, $end, $counter);
    while($stack){
        $action = array_pop($stack);
       // var_dump($action);
        if($action->num ==1){
            move($action->id,$action->first,$action->end,$action->counter);
        }else{
            $next_stack = init($action->id,$action->num,$action->first, $action->middle, $action->end, $action->counter);
            $stack=array_merge($stack,$next_stack);
        }
    }

}

/** 入栈操作
 * @param $id //需要移动的盘子
 * @param $num //移动该盘子需要挪动的总盘子数量
 * @param $first
 * @param $middle
 * @param $end
 * @param $counter
 * @return array
 */
function init($id,$num,$first, $middle, $end, $counter)
{
    unset($stack);
    //注意入站出站顺序
    $stack = array();
    //第一次回调
    $stack[] =new Params($id-1,$num-1,$middle,$first,$end,$counter);
    //第二次回调
    $stack[] =new Params($id,1,$first, $middle, $end, $counter);
    //第三次回调
    $stack[] =new Params($id-1,$num-1,$first,$end,$middle,$counter);
    return $stack;

}


