<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/8/8
 * Time: 9:54
 */

namespace tlApp\dao;
use \Exception;

class Option extends BaseDao
{
    protected $table = DB_PREFIX . "_option_test";

    /** 返回一组选项
     * @param $pid
     * @return array|bool
     * @throws Exception
     */
    public function selectGroup($pid)
    {
        $data = $this->database->select($this->table, [
            'name',
            'content',
            'has_pic',

        ], [
            'AND' => [
                'pid' => $pid,
                'visible[!]' => 0
            ]
        ]);

        //多条
        if (!is_array($data) || sizeof($data) == 0) {
            throw new Exception(__CLASS__ . __FUNCTION__ . ' error', 500);
        }

        return $data;

    }
}