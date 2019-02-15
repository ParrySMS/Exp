<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-15
 * Time: 15:46
 */

class Submit extends Db
{

    protected $table = 'ma_submit';

    public function insert(array $submit)
    {
        $pdo = $this->getDatabase()->insert($this->table, $submit);

        //法1 检验id
//        $id = $this->getDatabase()->id();
//        if(!is_numeric($id)||$id<=0){
//            throw new Exception(__FUNCTION__.':ERROR');
//        }

        //法2
        $row = $pdo->rowCount();
        if ($row != 1) {
            throw new Exception(__FUNCTION__ . ':ERROR');
        }
    }

    public function getLatestResult(int $uid, int $quiz_id, int $limit = QUIZ_EACH_TIMES_QUESTION):array
    {
        $datas = $this->getDatabase()->select($this->table, [
            'id',
            'result'
        ], [
            'AND' => [
                'uid' => $uid,
                'quiz_id' => $quiz_id,
                'visible[!]' => SUBMIT_INVALID
            ],
            'ORDER' => [
                'id' => 'DESC'
            ],
            'LIMIT' =>$limit
        ]);

        if(!is_array($datas)||sizeof($datas)!=$limit){
            throw new Exception(__FUNCTION__ . ':ERROR');
        }

        return $datas;
    }
}