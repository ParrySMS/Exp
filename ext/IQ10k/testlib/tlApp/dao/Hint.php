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

    protected $table = DB_PREFIX . "_hint";

    public function update($pid, $hint)
    {
        $pdo = $this->database->update($this->table, [
            'hint' => $hint,
        ],[
            'AND'=>[
                'pid'=>$pid,
                'visible[!]'=>0
            ]
        ]);

        $affected = $pdo->rowCount();
        if (!is_numeric($affected) || $affected != 1) {
            throw new Exception(__CLASS__ . __FUNCTION__ . '(): error', 500);
        }
    }


}