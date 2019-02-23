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

    /** 查看最新的两道题的提交结果（已经判断好正误）
     * @param int $uid
     * @param int $quiz_id
     * @param int $limit
     * @return array
     * @throws Exception
     */
    public function getLatestResult(int $uid, int $quiz_id, int $limit = QUIZ_EACH_TIMES_QUESTION): array
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
            'LIMIT' => $limit
        ]);

        if (!is_array($datas) || sizeof($datas) != $limit) {
            throw new Exception(__FUNCTION__ . ':ERROR');
        }

        return $datas;
    }

    /** 判断一个quiz的提交数量 如果已经足够 就应该结束
     * @param $quiz_id
     * @return bool
     * @throws Exception
     */
    public function isEnoughSubmit($quiz_id): bool
    {
        $num = $this->getDatabase()->count($this->table, [
            'quiz_id' => $quiz_id,
            'visible[!]' => SUBMIT_INVALID
        ]);

        if ($num < 0 || $num > QUIZ_TIMES_LIMIT * QUIZ_EACH_TIMES_QUESTION) {
            throw new Exception(__FUNCTION__ . ':submit num error');
        }


//        if($num == QUIZ_TIMES_LIMIT * QUIZ_EACH_TIMES_QUESTION){
//            return true;
//        }else{
//            return false;
//        }
        return ($num == QUIZ_TIMES_LIMIT * QUIZ_EACH_TIMES_QUESTION);
    }


    /** 取出 某个人 答题的全部结果（题只有qids）
     * @param $uid
     * @param $quiz_id
     * @return array
     * @throws Exception
     */
    public function getAllQidsInQuiz($uid, $quiz_id):array
    {
        $datas = $this->getDatabase()->select($this->table, [
            'qid',
            'time',
            'submit_content',
            'result'
        ], [
            'uid' => $uid,
            'quiz_id' => $quiz_id,
            'visible[!]' => SUBMIT_INVALID
        ]);

        if(!is_array($datas) || sizeof($datas) > QUIZ_TIMES_LIMIT* QUIZ_EACH_TIMES_QUESTION){
            throw new Exception(__FUNCTION__ . ':QIDS num error');
        }

        return $datas;

    }
}