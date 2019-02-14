<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-13
 * Time: 14:58
 */

class Question extends Db
{
    protected $table = 'ma_question';

    /** 拿N道题
     * @param $type 指定类型
     * @param $diff 指定难度
     * @param $question_num 可选 每次的题目数量
     * @return array  value还是数组 有三个属性 'qid','content', 'diff'
     * @throws Exception
     */
    public function getQt(int $type,int $diff,int $question_num = QUIZ_EACH_TIMES_QUESTION):array
    {
        //todo  拿option
        $datas = $this->getDatabase()->select($this->table,[
            'qid',
            'content',
            'diff'
        ],[
            'type'=>$type,
            'diff'=>$diff,
            'visible'=>QUESTION_VALID,
            'LIMIT' => QUESTION_SELECT_LIMIT
        ]);

        if(!is_array($datas) || sizeof($datas)< $question_num){
            throw new Exception(__FUNCTION__.'():error');
        }

        shuffle($datas);

        //取出部分结果
        $qArray=[];
        for($i = 0;$i<$question_num;$i++){
            $qArray[] = $datas[$i];
        }

        return $qArray;

    }

    //todo  拿option    1--qid 重新select 查2次    2--qid  JOIN 连表


}