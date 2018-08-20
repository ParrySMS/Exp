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


    /** 默认无图 逐条插入选项
     * @param $pid
     * @param $key
     * @param $content
     * @param int $is_pic
     * @return int $id
     */
    public function insert($pid, $key, $content, $is_pic = 0)
    {
        $pdo = $this->database->insert($this->table, [
            'pid' => $pid,
            'key' => $key,
            'content' => $content,
            'is_pic' => $is_pic,
            'time'=>date(DB_TIME_FORMAT),
            'visible' => VISIBLE_NORMAL
        ]);

        $id = $this->database->id();
        if (!is_numeric($id) || $id < 1) {
            throw new Exception(__CLASS__ . __FUNCTION__ . '():  pid error', 500);

        }
        return $id;

    }


    /** 更新选项内容
     * @param $pid
     * @param $key
     * @param $content
     * @param int $is_pic
     * @throws Exception
     */
    public function update($oid,$pid, $key, $content, $is_pic = 0)
    {
        $pdo = $this->database->update($this->table, [
            'key' => $key,
            'content' => $content,
            'is_pic' => $is_pic,
            'edit_time'=>date(DB_TIME_FORMAT),

        ], [
            'AND' => [
                'id'=>$oid,
                'pid' => $pid,
                'visible[!]' => VISIBLE_DELETE
            ]
        ]);


        $affected = $pdo->rowCount();
        if (!is_numeric($affected) || $affected != 1) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '(): error', 500);
        }

    }

    /** 返回一组选项
     * @param $pid
     * @return array|bool
     * @throws Exception
     */
    public function selectGroup($pid, array $option_ids)
    {
        $data = $this->database->select($this->table, [
            'id',
            'key',
            'content',
            'is_pic'
        ], [
            'AND' => [
                'id' => $option_ids,
                'pid' => $pid,
                'visible[!]' => VISIBLE_DELETE
            ]
        ]);

        //多条
        if (!is_array($data) || sizeof($data) == 0) {
            throw new Exception(__CLASS__ . '->' .__FUNCTION__ . '(): error', 500);
        }

        return $data;

    }


    /** 软删除
     * @param $oid
     * @throws Exception
     */
    public function delete($oid)
    {
        $pdo = $this->database->update($this->table, [
            'visible' => VISIBLE_DELETE,
            'edit_time'=>date(DB_TIME_FORMAT),

        ], [
            'AND' => [
                'id'=>$oid,
                'visible[!]' => VISIBLE_DELETE
            ]
        ]);


        $affected = $pdo->rowCount();
        if (!is_numeric($affected) || $affected != 1) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '(): error', 500);
        }

    }
}