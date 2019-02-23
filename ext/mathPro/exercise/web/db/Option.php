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

    /** 找出这题的全部选项
     * @param int $qid
     * @param int $option_num
     * @return array|bool
     * @throws Exception
     */
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

    /** 插入一个选项
     * @param $key
     * @param $content
     * @param $qid
     * @return int
     * @throws Exception
     */
    public function insert($key,$content,$qid):int
    {
        $this->getDatabase()->insert($this->table,[
            'key'=>$key,
            'content'=>$content,
            'qid'=>$qid,
            'visible'=>OPTION_VALID
        ]);

        $id = $this->getDatabase()->id();
        if(!is_numeric($id) || $id <= 0){
            throw new Exception(__FUNCTION__ . '():error');
        }

        return $id;
        
    }

}