<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-8-6
 * Time: 23:32
 */

namespace tlApp\dao;
use \Exception;

class Text extends BaseDao
{
    public $table;

    public function setTable($table)
    {
        $this->table = $table;
    }


    /** 需要指定类型表
     * Text constructor.
     * @param $table_suffix
     */
    public function __construct($table_suffix)
    {
        $this->table = DB_PREFIX . '_text_' . $table_suffix;
    }


    /** todo 文字信息表还没有建起来
     * @param $pid
     * @return array|bool
     * @throws Exception
     */
    public function selectOne($pid)
    {
        $data = $this->database->select($this->table, [
                'text',
            ] . [
                'AND' => [
                    'pid' => $pid,
                    'visible[!]' => 0
                ]
            ]);

        if(!is_array($data)||sizeof($data)==0){
            throw new Exception(__CLASS__.__FUNCTION__ . ' error', 500);
        }



        return $data;

    }

}