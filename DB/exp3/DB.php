<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-11-23
 * Time: 9:23
 */

class DB
{

    public $database;

    /**
     * Pdo constructor.
     */
    public function __construct()
    {
        $this->database = new Medoo\Medoo([
            'database_type' => DATABASE_TYPE,
            'database_name' => DATABASE_NAME,
            'server' => SERVER,
            'username' => USERNAME,
            'password' => PASSWORD,
            'port' => PORT,
            'charset' => CHARSET
        ]);

    }

}