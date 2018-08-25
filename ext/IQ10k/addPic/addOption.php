<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-8-24
 * Time: 12:00
 */

require './config/db.php';
require './config/Medoo.php';
require './Http.php';

set_time_limit(0);

$t = new OptionPic();
//$t->add();

class OptionPic
{

    public $name;
    public $table;
    public $database;
    public $http;


    public function __construct()
    {
        $this->name = 'option_addpic';
        $this->table = DB_PREFIX . '_' . $this->name;
        $this->database = new Medoo\Medoo([
            'database_type' => DATABASE_TYPE,
            'database_name' => DATABASE_NAME,
            'server' => SERVER,
            'username' => USERNAME,
            'password' => PASSWORD,
            'port' => PORT,
            'charset' => CHARSET
        ]);

        $this->http = new \www\AI\Http();
    }

    public function add()
    {
        $table_p = DB_PREFIX . '_problem_addpic';
        $vaild_pids = $this->database->select($table_p, [
            'id',
            'option_num'
        ], [
            'AND' => [
                'option_num[>]' => 0,
//                'option_ids' => 'null',
                'visible[!]' => 0
            ],
            "ORDER" => [
                'id' => 'ASC'
            ],
        ]);

//        var_dump($vaild_pids);


//      遍历id
        foreach ($vaild_pids as $d) {

            unset($oids);
            $oids = [];

            $id = $d['id'];
            $key = 'a';
            //插入若干选项
            for ($i = 0; $i < $d['option_num']; $i++, $key++) {
                $url = "http://cosdemo-1253322052.cosgz.myqcloud.com/IQ10K/diagram/zhitu-des/$id-$key.png";

                if ($this->http->is200($url)) {
                    $oids[] = $this->addOption($id, $key, $url);
                }
            }

            $this->updateOids($id,$oids);

            echo "pid:$id done <br/>";
        }

        echo 'done!';

    }


    public function addOption($pid, $key, $content, $is_pic = 1)
    {
        $pdo = $this->database->insert($this->table, [
            'pid' => $pid,
            'key' => $key,
            'content' => $content,
            'is_pic' => $is_pic,
            'time' => date('Y-m-d H:i:s'),
            'visible' => 1
        ]);
        $id = $this->database->id();
        if (!is_numeric($id) || $id < 1) {
            echo __CLASS__ . __FUNCTION__ . "():  pid $pid-$key error <br/>";
        }

        return $id;
    }


    public function updateOids($id,$oids){
        $table_p = DB_PREFIX . '_problem_addpic';
        $pdo = $this->database->update($table_p, [
            'option_ids'=>json_encode($oids)
            ],[
                'AND'=>[
                    'id'=>$id,
                    'visible[!]'=>0
                ]
        ]);

        $affected = $pdo->rowCount();
        if (!is_numeric($affected) || $affected != 1) {
            echo __CLASS__ . __FUNCTION__ . "():  pid $id set oid error <br/>";
        }
    }
}