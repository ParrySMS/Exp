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
     *  拿 option--qid 重新select 查2次
     * @param $type 指定类型
     * @param $diff 指定难度
     * @param $question_num 可选 每次的题目数量
     * @return array  value还是数组 有三个属性 'qid','content', 'diff'
     * @throws Exception
     */
    public function getQt(int $type, int $diff, int $question_num = QUIZ_EACH_TIMES_QUESTION): array
    {
        //todo  拿option
        $datas = $this->getDatabase()->select($this->table, [
            'qid',
            'content',
            'diff'
        ], [
            'AND' => [
                'type' => $type,
                'diff' => $diff,
                'visible' => QUESTION_VALID,
            ],
            'LIMIT' => QUESTION_SELECT_LIMIT
        ]);

        if (!is_array($datas) || sizeof($datas) < $question_num) {
            throw new Exception(__FUNCTION__ . '():error');
        }

        shuffle($datas);


        //取出部分结果 -- 并且找对应选项
        $qArray = [];
        $op = new Option();//操控Option表

        for ($i = 0; $i < $question_num; $i++) {
            $que = $datas[$i];

            $qid = $que['qid'];

            $options = $op->getOptionsByQid($qid);

            $que['optionArray'] = $options;

            $qArray[] = $que;

        }

        return $qArray;

    }


    public function getQtJoin(int $type, int $diff, int $question_num = QUIZ_EACH_TIMES_QUESTION): array
    {
        //连表拿option
        $datas = $this->getDatabase()->select($this->table . '(q)', [
//            "[>]account" => ["author_id" => "user_id"],
//           '[>]math_option' => ['qid'=>'qid'],
            '[>]math_option(o)' => ['q.pid' => 'qid'],

        ], [
            'q.qid',
            'q.content',
            'q.diff',
            'o.id(oid)',
            'o.key',
            'o.content'
        ], [
            'AND' => [
                'q.type' => $type,
                'q.diff' => $diff,
                'q.visible' => QUESTION_VALID,
                'o.visible' => OPTION_VALID,
            ],
            'LIMIT' => QUESTION_SELECT_LIMIT * OPTION_NUM_OF_EACH_QT
        ]);

        $qids = [];//保存全部独立的 datas开始key ==> qid
        foreach ($datas as $key => $que) {
            if (empty($qids) || !in_array($que['qid'], $qids)) {
                $qids[(string)$key] = $que['qid'];
            }
        }

        shuffle($qids);
        $qArray = [];//保存部分结果

        $counter = 0;//计数器 取部分结果
        foreach ($qids as $key => $qid) {
            if ($counter >= QUESTION_SELECT_LIMIT) {
                break;
            }
//            $options = getOptionsInDatas($qid)
        }


    }

    //todo  拿option       2--qid  JOIN 连表


}