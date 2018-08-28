<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/8/2
 * Time: 15:23
 */

namespace tlApp\dao;
use \Exception;

class Hint extends BaseDao
{

    protected $table = DB_PREFIX . "_hint_test";

    /** 更新一条提示 可能会相同
     * @param $pid
     * @param $hint
     * @throws Exception
     */
    public function update($pid, $hint)
    {
        $pdo = $this->database->update($this->table, [
            'hint' => $hint,
            'time'=>date(DB_TIME_FORMAT)
        ],[
            'AND'=>[
                'pid'=>$pid,
                'visible[!]'=>VISIBLE_DELETE
            ]
        ]);

        $affected = $pdo->rowCount();

        //可能相同 0条或1条
        if (!is_numeric($affected) || $affected > 1) {
//            var_dump($affected);
//            $this->database->error();
            throw new Exception(__CLASS__ .'->'. __FUNCTION__ . '(): error', 500);
        }
    }


    /** 是否有该题目的提示
     * @param $pid
     * @return bool
     */
    public function has($pid)
    {
        $has = $this->database->has($this->table,[
            'AND'=>[
                'pid'=>$pid,
                'visible[!]'=>VISIBLE_DELETE
            ]
        ]);

        return $has;
    }


    /** 插入提示
     * @param $pid
     * @param $hint
     * @throws Exception
     */
    public function insert($pid,$hint)
    {
        $pdo = $this->database->insert($this->table, [
            'pid' => $pid,
            'hint' => $hint,
            'time' => date(DB_TIME_FORMAT),
            'visible' => VISIBLE_NORMAL

        ]);

        $hid = $this->database->id();
        if (!is_numeric($hid) || $hid < 1) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():  hid error', 500);
        }
    }

    /** 软删除
     * @param $pid
     * @param int $visible
     * @throws Exception
     */
    public function setVisible($pid,$visible = VISIBLE_DELETE)
    {
        $pdo = $this->database->update($this->table, [
            'visible' => $visible,
            'time'=>date(DB_TIME_FORMAT)
        ],[
            'AND'=>[
                'pid'=>$pid,
                'visible[!]'=>VISIBLE_DELETE
            ]
        ]);

        $affected = $pdo->rowCount();

        if (!is_numeric($affected) || $affected != 1) {
            throw new Exception(__CLASS__ .'->'. __FUNCTION__ . '(): error', 500);
        }

    }
}