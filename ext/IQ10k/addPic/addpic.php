<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-8-24
 * Time: 10:17
 */

require './config/db.php';
require './config/Medoo.php';
require './Http.php';

set_time_limit(0);

define('LIMIT',1000);
$t = new TitlePic();

//$t->add(0);

class TitlePic
{
    public $name;
    public $table;
    public $database;
    public $http;

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
        $this->http = new \www\AI\Http();
    }

    public function add($last_id)
    {

        $vaild_ids = $this->database->select($this->table, [
            'id'
        ], [
            'AND'=>[
                'id[>]'=>$last_id,
                'title_pic'=>null,
                'visible[!]' => 0
            ],
            "ORDER" => [
                'id' => 'ASC'
            ],
            "LIMIT" => LIMIT
        ]);

        var_dump($vaild_ids);

//      遍历id
        foreach ($vaild_ids as $d) {
            $id = $d['id'];
            $url = "http://cosdemo-1253322052.cosgz.myqcloud.com/IQ10K/diagram/zhitu-des/$id-t.png";

            if ($this->http->is200($url)) {
                echo "200 .. $id<br/>";
                $this->addTitlePic($id, $url);
            }
        }

        echo 'done!';

    }

    public function addTitlePic($id, $url)
    {
        $pdo = $this->database->update($this->table,[
            'title_pic'=>$url
        ],[
            'AND'=>[
                'id'=>$id,
                'visible[!]'=>0
            ]
        ]);
    }


}
