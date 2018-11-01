<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-7-23
 * Time: 13:31
 */
namespace tlApp\dao;
use Medoo\Medoo;
date_default_timezone_set('Asia/Shanghai');

class BaseDao
{

    protected $database;

    static $T_ACTION = DB_PREFIX.'_action';
//    static $T_COMMENT = DB_PREFIX . "_comment_test";
    static $T_COMMENT = DB_PREFIX . "_comment_adddiagramspecial";
//    static $T_HINT = DB_PREFIX . "_hint_test";
    static $T_HINT = DB_PREFIX . "_hint_adddiagramspecial";
    static $T_OPTION = DB_PREFIX . "_option_adddiagramspecial";
    static $T_PROBLEM = DB_PREFIX . "_problem_adddiagramspecial";

    /**
     * BaseDao constructor.
     */
    public function __construct()
    {
        $this->database = new Medoo([
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