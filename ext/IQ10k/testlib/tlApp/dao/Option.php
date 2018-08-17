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
    protected $table = DB_PREFIX . '_option_test';


    /** 默认无图
     * @param $pid
     * @param $key
     * @param $content
     * @param int $is_pic
     * @return int $id
     */
    public function insert($pid, $key, $content, $is_pic = 0)
    {
        $pdo = $this->database->insert($this->table, [
            'pid'=>$pid,
            'key'=>$key,
            'content'=>$content,
            'is_pic'=>$is_pic,
            'visible'=>VISIBLE_NORMAL
        ];
        $id = $this->database->id();
        if (!is_numeric($id) || $id < 1) {
            throw new Exception(__CLASS__ . __FUNCTION__ . '():  pid error', 500);

        }
        return $id;

    }
    /** 返回一组选项
     * @param $pid
     * @return array|bool
     * @throws Exception
     */
    public function selectGroup($pid)
    {
        $data = $this->database->select($this->table, [
            'key',
            'content',
            'is_pic',

        ], [
            'AND' => [
                'pid' => $pid,
                'visible[!]' => 0
            ]
        ]);

        //多条
        if (!is_array($data) || sizeof($data) == 0) {
            throw new Exception(__CLASS__ . __FUNCTION__ . '(): error', 500);
        }

        return $data;

    }
}