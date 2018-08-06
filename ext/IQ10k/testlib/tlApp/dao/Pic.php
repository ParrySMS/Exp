<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-8-6
 * Time: 23:00
 */

namespace tlApp\dao;

use \Exception;

class Pic extends BaseDao
{
    public $table;

    /**
     * @param string $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }


    /** 需要指定类型表
     * Pic constructor.
     * @param $table_suffix
     */
    public function __construct($table_suffix)
    {
        $this->table = DB_PREFIX . '_pic_' . $table_suffix;
    }


    /** todo 图片表还没有建起来
     * @param $pid
     * @return array|bool
     * @throws Exception
     */
    public function selectOne($pid)
    {
        $data = $this->database->select($this->table, [
                'name',
                'url',
            ] . [
                'AND' => [
                    'pid' => $pid,
                    'visible[!]' => 0
                ]
            ]);

        if (!is_array($data) || sizeof($data) == 0) {
            throw new Exception(__CLASS__ . __FUNCTION__ . ' error', 500);
        }

         return $data;

    }


}