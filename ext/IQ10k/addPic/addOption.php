<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-8-24
 * Time: 12:00
 */

require './config/database_info.php';
require './config/Medoo.php';
require './Http.php';

set_time_limit(0);

$t = new OptionPic();
$t->add(9316);

class OptionPic
{

    public $name;
    public $table;
    public $database;
    public $http;


    static $T_ACTION = DB_PREFIX . '_action';
//    static $T_COMMENT = DB_PREFIX . "_comment_test";
    static $T_COMMENT = DB_PREFIX . "_comment_adddiagramspecial";
//    static $T_HINT = DB_PREFIX . "_hint_test";
    static $T_HINT = DB_PREFIX . "_hint_adddiagramspecial";
    static $T_OPTION = DB_PREFIX . "_option_adddiagramspecial";
    static $T_PROBLEM = DB_PREFIX . "_problem_adddiagramspecial";

    static $PRE_URL = "http://cosdemo-1253322052.cosgz.myqcloud.com/IQ10K/logic_diagram/zhitu-des/";

    public function __construct()
    {
        $this->table = $this::$T_OPTION;
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

    public function add($last_id)
    {
        $table_p = $this::$T_PROBLEM;
        $vaild_pids = $this->database->select($table_p, [
            'id',
            'option_ids'
        ], [
            'AND' => [
                'id[>]' => $last_id,
                'option_ids[!]' => null,
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
            $option_ids = json_decode($d['option_ids']);

            if (!is_array($option_ids) || sizeof($option_ids) == 0) {
                continue; //no option
            }

            $option_num = sizeof($option_ids);

            $key = 'a';
            //插入若干选项
            for ($i = 0; $i < $option_num; $i++, $key++) {
                $url = $this::$PRE_URL . "$id-$key.png";

                if ($this->http->is200($url)) {
                    $oid = $this->addOption($id, $key, $url);
                    echo "200 .. $id-$key.png";
                    echo PHP_EOL;
                    if (!empty($oid) && is_numeric($oid)) {
                        $oids[] = $oid;
                    }
                }
            }

            $this->updateOids($id, $oids);

            echo "pid:$id done";
            echo PHP_EOL;
        }

        echo 'done!';

    }


    /** 添加选项或更新选项
     * @param $pid
     * @param $key
     * @param $content
     * @param int $is_pic
     * @return int|mixed|null|string
     */
    public function addOption($pid, $key, $content, $is_pic = 1)
    {

        $has = $this->database->has($this->table, [
            'pid' => $pid,
            'key' => $key,
            'content' => '',
            'visible[!]' => 0
        ]);


        if ($has) { // has option ,need update
            $pdo = $this->database->update($this->table, [
                'content' => $content,
                'is_pic' => $is_pic,
                'edit_time' => date('Y-m-d H:i:s')
            ], [
                'AND' => [
                    'pid' => $pid,
                    'key' => $key,
                    'visible[!]' => 0
                ]
            ]);
            $affected = $pdo->rowCount();

            if (!is_numeric($affected) || $affected != 1) {
                echo __CLASS__ . __FUNCTION__ . "(): has option ,need update error";
                echo PHP_EOL;
            }
            return null;

        } else {// no option
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
                echo __CLASS__ . __FUNCTION__ . "():  pid $pid-$key error";
                echo PHP_EOL;
            }

            return $id;
        }
    }


    public function updateOids($id, $oids)
    {
        $table_p = $this::$T_PROBLEM;

        $oids_db = $this->database->select($table_p, [
            'option_ids'
        ], [
            'AND' => [
                'id' => $id,
                'visible[!]' => 0
            ]
        ]);

        $oids_db = $oids_db[0]["option_ids"];

        if (!empty($oids_db) && $oids_db != '[]') {
            $oids_db = json_decode($oids_db);
            $oids = array_merge($oids, $oids_db);
        }


        $pdo = $this->database->update($table_p, [
            'option_ids' => json_encode($oids),
            'edit_time' => date('Y-m-d H:i:s'),
            'total_edit[+]' => 1
        ], [
            'AND' => [
                'id' => $id,
                'visible[!]' => 0
            ]
        ]);

        $affected = $pdo->rowCount();
        if (!is_numeric($affected) || $affected != 1) {
            echo __CLASS__ . __FUNCTION__ . "():  pid $id set oid error";
            echo PHP_EOL;
        }

    }
}