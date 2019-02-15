<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-15
 * Time: 14:41
 */

class Answer extends Db
{
    protected $table = 'ma_answer';

    /** 根据 qid 拿到单选题答案
     * @param int $qid
     * @return mixed
     * @throws Exception
     */
    public function getAnswerContent(int $qid)
    {
        $datas = $this->getDatabase()->select($this->table, [
            'id',
            'content',
        ], [
            'qid' => $qid,
            'visible[!]' => ANSWER_INVALID
        ]);

        //没有多选题 只有一个答案
        if (!is_array($datas) || sizeof($datas) != 1) {
            throw new Exception(__FUNCTION__ . ':ERROR');
        }

        return $datas[0];
    }

}