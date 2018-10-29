<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-10-29
 * Time: 19:13
 */
require "./config/Medoo.php";
require "./config/database_info.php";

use Medoo\Medoo;

class SingleDB
{

    private $database;//声明一个私有的实例变量

    private function __construct()
    {//声明私有构造方法为了防止外部代码使用new来创建对象。

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

    static public $instance;//声明一个静态变量（保存在类中唯一的一个实例）

    static public function getinstance()
    {//声明一个getinstance()静态方法，用于检测是否有实例对象
        if (!self::$instance) self::$instance = new self();
        return self::$instance;
    }


    public function getDB()
    {
        return $this->database;
    }
}



