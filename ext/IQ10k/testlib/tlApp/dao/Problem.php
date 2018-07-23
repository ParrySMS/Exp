<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-7-23
 * Time: 13:34
 */

namespace tlApp\dao;

use \Exception;

class Problem extends BaseDao
{
    protected $table = DB_PREFIX . "_problem";




    public function insert(Array $problem_info, $ret_id = false)
    {

        //problem_info = compact($problem, $option_num, $language, $classification, $proType, $proSource, $hint);

        $pdo = $this->database->insert($this->table, [
                'problem' => $problem_info['problem'],
                'option_num' => $problem_info['option_num'],
                'options' => $problem_info['options'],
                'language' => $problem_info['language'],
                'classification' => $problem_info['classification'],
                'proType' => $problem_info['proType'],
                'proSource' => $problem_info['proSource'],
                'time' => date('Y-m-d H:i:s'),
                'lastest' => date('Y-m-d H:i:s'),
                'total' => 0,
                'visible' => 1
            ]
        );

        $id = $this->database->id();
        if (!is_numeric($id) || $id < 1) {
            throw new Exception(__FUNCTION__ . ' error', 500);
        }

        return $ret_id === false ? null : $id;
    }

}