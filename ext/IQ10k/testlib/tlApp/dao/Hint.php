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

    /** 更新一条提示
     * @param $pid
     * @param $hint
     * @throws Exception
     */
    public function update($pid, $hint)
    {
        $pdo = $this->database->update($this->table, [
            'hint' => $hint,
        ],[
            'AND'=>[
                'pid'=>$pid,
                'visible[!]'=>VISIBLE_DELETE
            ]
        ]);

        $affected = $pdo->rowCount();

        if (!is_numeric($affected) || $affected != 1) {
//            var_dump($affected);
//            $this->database->error();
            throw new Exception(__CLASS__ .'->'. __FUNCTION__ . '(): error', 500);
        }
    }


}