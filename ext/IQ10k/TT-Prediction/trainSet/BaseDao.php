<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-4-23
 * Time: 18:14
 */

class BaseDao
{
    protected $database;

    static $T_ACTION = DB_PREFIX . '_action';
//    static $T_COMMENT = DB_PREFIX . "_comment_test";
    static $T_COMMENT = DB_PREFIX . "_comment_".DB_SUFFIX;
//    static $T_HINT = DB_PREFIX . "_hint_test";
    static $T_HINT = DB_PREFIX . "_hint_".DB_SUFFIX;
    static $T_OPTION = DB_PREFIX . "_option_".DB_SUFFIX;
    static $T_PROBLEM = DB_PREFIX . "_problem_".DB_SUFFIX;

    //trans
    static $T_TRANS_PROBLEM = DB_PREFIX . "_problem_cetrans_not_en";
    static $T_TRANS_OPTION = DB_PREFIX . "_option_cetrans";
    static $T_TRANS_HINT = DB_PREFIX . "_hint_cetrans";

    /**
     * @return \Medoo\Medoo
     */
    public function getDatabase()
    {
        return $this->database;
    }


    /**
     * BaseDao constructor.
     */
    public function __construct()
    {
        $this->database = new  Medoo\Medoo([
            'database_type' => DATABASE_TYPE,
            'database_name' => DATABASE_NAME,
            'server' => SERVER,
            'username' => USERNAME,
            'password' => PASSWORD,
            'charset' => CHARSET,
            'port' => PORT,
            'check_interval' => CHECK_INTERVAL
        ]);
    }


}