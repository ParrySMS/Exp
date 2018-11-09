<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-11-4
 * Time: 16:48
 */

namespace tlApp\dao;
use \Exception;

class Trans extends BaseDao
{


    public function __construct()
    {
        parent::__construct();
    }

    /**获取翻译的题目 没有则null
     * @param $pid
     * @return array|bool
     */
    public function selectTitle($pid)
    {
        $data = $this->database->get($this::$T_TRANS_PROBLEM,
            'trans_title'
            , [
                'pid' => $pid
            ]);

        return($data === false)? null: $data;


    }


    /** 获取翻译数据里的content 改名
     * @param $pid
     * @return array|bool
     * @throws Exception
     */
    public function selectOptionsGroup($pid)
    {
        $data = $this->database->select($this::$T_TRANS_OPTION, [
            'id',
            'key',
            'trans_content(content)',
            'is_pic'
        ], [
            'AND' => [
                'pid' => $pid,
                'visible[!]' => VISIBLE_DELETE
            ]
        ]);

        //0-多条
        if (!is_array($data) ) {
            throw new Exception(__CLASS__ . '->' .__FUNCTION__ . '(): error', 500);
        }

        return $data;

    }


    /** 获取翻译的提示 没有则null
     * @param $pid
     * @return array|bool|mixed|null
     */

    public function selectHint($pid)
    {

        $data = $this->database->get($this::$T_TRANS_HINT,
            'trans_hint'
            , [
                'pid' => $pid
            ]);


        return ($data === false)? null: $data;
    }

    /** 返回回答的数组
     * @param $pid
     * @return array
     */
    public function selectAnswer($pid){
        $data = $this->database->get($this::$T_TRANS_ANSWER,
            'trans_answers'
            , [
                'pid' => $pid
            ]);

        return($data === false)? []:[$data];

    }

}