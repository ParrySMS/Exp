<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-13
 * Time: 16:46
 */

class Option extends Db
{
    protected $table = 'ma_option';

    public function getOptionsByQid(int $qid,int $option_num = OPTION_NUM_OF_EACH_QT)
    {
        $datas = $this->getDatabase()->select($this->table, [
            'id(oid)',
            'key',
            'content'
        ], [
            'qid' => $qid,
            'visible[!]' => OPTION_INVALID
        ]);

        if (!is_array($datas) || sizeof($datas) < $option_num) {
            throw new Exception(__FUNCTION__ . '():error');
        }

        return $datas;


    }

}