<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-8-22
 * Time: 1:08
 */

namespace tlApp\dao;

use \Exception;

class Comment extends BaseDao
{
    protected $table = DB_PREFIX . "_comment_test";


    /** 插入数据
     * @param $pid
     * @param $comment
     * @return int
     * @throws Exception
     */
    public function insert($pid, $comment)
    {
        $pdo = $this->database->insert($this->table, [
            'pid' => $pid,
            'comment' => $comment,
            'time' => date(DB_TIME_FORMAT),
            'visible' => VISIBLE_NORMAL

        ]);

        //插入成功后通过id检查是否异常
        $id = $this->database->id();
        if (!is_numeric($id) || $id < 1) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():  id error', 500);
        }
        return $id;
    }


    /** 选取pid对应的多条评论
     * @param $pid
     * @return array|bool
     * @throws Exception
     */
    public function select($pid){
        $data = $this->database->select($this->table, [
            'id(cid)',
            'uid',
            'comment',
            'time'
        ],
            [
                'AND' => [
                    'pid' => $pid,
                    'visible[!]' => VISIBLE_DELETE
                ]
            ]);
        //多条
        if (!is_array($data)) {
            throw new Exception(__CLASS__ . '->' .__FUNCTION__ . '(): error', 500);
        }

        return $data;
    }


    /** 是否该题目有comment
     * @param $pid
     * @return bool
     */
    public function has($pid)
    {
        $has = $this->database->has($this->table,[
            'AND'=>[
                'pid'=>$pid,
                'visible'=>VISIBLE_DELETE
            ]
        ]);

        return $has;

    }

}