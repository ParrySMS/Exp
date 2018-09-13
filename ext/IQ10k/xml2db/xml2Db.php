<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-8-29
 * Time: 15:47
 */

require './Http.php';
require './config/database_info.php';
require './config/Medoo.php';

$filePath = './xml/';
$fileName = 'test.xml';

$xml_file = simplexml_load_file($filePath.$fileName);

$http = new Http();
$xml = new Xml();

//var_dump($xml_file->Data[11]);

try {
    foreach ($xml_file->Data as $d) {
        //todo 实现参数处理
        $d = $xml->pmcheck($d);

        $xml->insert($d);
    }
}catch (Exception $e){
    echo $e->getMessage();
    $http->status($e->getCode());
}


class Xml
{
    public $name;
    public $table;
    public $database;

    /**
     * TitlePic constructor.
     */
    public function __construct()
    {
        $this->name = 'problem_addpic';

        $this->table = DB_PREFIX .'_'. $this->name;

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

    public function insert($data)
    {

    }

    /** 参数检查
     * @param $data
     * @throws Exception
     */
    public function pmcheck($data){


        if(!isset($data->Problem)){
            throw new Exception('title null',500);
        }
        $title = trim($data->Problem);


        //todo 选项要分开插入获取ids

        if(!isset($data->Option)){//无选项
           //todo 判断题型
        }else{

        }




    }
}
