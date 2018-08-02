<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/8/2
 * Time: 15:23
 */

namespace tlApp\dao;


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

        $affected = $this->database->rowCount();
        if (!is_numeric($affected) || $affected != 1) {
            throw new Exception(__FUNCTION__ . ' error', 500);
        }
    }


}