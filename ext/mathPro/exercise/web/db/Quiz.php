<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-15
 * Time: 17:48
 */

class Quiz extends Db
{
    protected $table = 'ma_quiz';

    public function addFinalDiff($quiz_id)
    {
        $pdo = $this->getDatabase()->update($this->table,[
            'final_diff[+]'=>QUIZ_UPGRADE_NUM
        ],[
            'id'=>$quiz_id,
            'visible[!]'=>QUIZ_VALID
        ]);

        $row = $pdo->rowCount();
        if($row !=1 ){
             throw new  Exception(__FUNCTION__.':ERROR');
        }
    }

    public function getFinalDiff()
    {
        //todo select
        
    }
}