<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-11
 * Time: 14:51
 */

use Medoo\Medoo;

class Db
{

    protected $database;

    /**
     * @return Medoo
     */
    public function getDatabase(): Medoo
    {
        return $this->database;
    }

    public function __construct()
    {
        $this->database = new Medoo([
            // required
            'database_type' => DB_TYPE,
            'database_name' => DB_NAME,
            'server' => SERVER,
            'username' => USER,
            'password' => PASSWORD,

            // [optional]
            'charset' => CHARSET,
            'collation' => COLLATION,
            'port' => PORT

            // [optional] Table prefix
        ]);
    }
}

