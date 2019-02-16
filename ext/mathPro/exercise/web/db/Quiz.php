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
        $pdo = $this->getDatabase()->update($this->table, [
            'final_diff[+]' => QUIZ_UPGRADE_NUM
        ], [
            'id' => $quiz_id,
            'visible[!]' => QUIZ_VALID
        ]);

        $row = $pdo->rowCount();
        if ($row != 1) {
            throw new  Exception(__FUNCTION__ . ':ERROR');
        }
    }

    /** 获取具体一个quiz 的 diff
     * @param $quiz_id
     * @return int
     * @throws Exception
     */
    public function getFinalDiff($quiz_id):int
    {
        $diff = $this->getDatabase()->get($this->table,
            'final_diff',
            [
                'id' => $quiz_id,
                'visible[!]' => QUIZ_INVALID
            ]);

        if(!is_numeric($diff)){
            throw new  Exception(__FUNCTION__ . ':ERROR');
        }

        return $diff;
    }

    /** 先去找最新的未完成quiz 如果没有 那就造一个
     * @param $uid
     * @return array|bool|int|mixed
     * @throws Exception
     */
    public function findLatestQuiz($uid)
    {
        //先去找 找到就有
        $quiz_id = $this->getDatabase()->get($this->table,
            'id',
            [
                'AND' => [
                    'uid' => $uid,
                    'is_finish' => QUIZ_UNFINISHED,
                    'visible[!]' => QUIZ_INVALID
                ],
                'ORDER' => [
                    'id' => 'DESC',
                ]
            ]);

        //如果找不到 那就造一个
        if (!is_numeric($quiz_id) || $quiz_id <= 0) {
            $quiz_id = $this->createQuiz($uid);
        }

        return $quiz_id;

    }


    /** 创建一个quiz 并且返回id
     * @param $uid
     * @return int
     * @throws Exception
     */
    public function createQuiz($uid): int
    {
        $this->getDatabase()->insert($this->table, [
            'uid' => $uid,
            'is_finish' => QUIZ_UNFINISHED,
            'final_diff' => QUIZ_ORIGINAL_DIFF,
            'start_time' => date(TIME_FORMAT),
            'visible' => QUIZ_VALID
        ]);

        $quiz_id = $this->getDatabase()->id();

        if (!is_numeric($quiz_id) || $quiz_id <= 0) {
            throw new  Exception(__FUNCTION__ . ':ERROR');
        }

        return $quiz_id;
    }

    /** 更新结束状态 默认是把它变成结束
     * @param $quiz_id
     * @param int $status
     * @throws Exception
     */
    public function updateFinish($quiz_id ,$status = QUIZ_UNFINISHED)
    {
        $pdo = $this->getDatabase()->update($this->table,[
            'is_finish' => $status,
            'end_time' => date(TIME_FORMAT),
        ],[
            'id'=>$quiz_id,
            'visible[!]'=>QUIZ_INVALID
        ]);

        $row = $pdo->rowCount();
        if($row!=1){
            throw new  Exception(__FUNCTION__ . ':ERROR');
        }
    }
}







//
//$arr = [];// 空数组
//
//$first = $arr[0]; //第0个
//
//$index = 5;
//$fifth = $arr[$index]; // 第x个
//
//
//$arr[] = $num; //数组尾部插入一个 num值
//
//$len = sizeof($arr); //数组有多少条
//
//$arr['id'] = 54;
//
//$arr2 = [];
//$arr2[] = $arr['id'];
//
//echo $arr2[0]['id'];//echo 54