<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-3-23
 * Time: 10:14
 */

namespace stuApp\dao;
use \Exception;
use Medoo\Medoo;
use zzxApp\model\Page;

class StuInfo
{
    private $database;
    private $table;

    /**
     * StuInfo constructor.
     * @param $database
     */
    public function __construct(Medoo $database = null, $table = null)
    {
        //初始化默认值
        if ($table === null) {
            $table = DB_PREFIX . '_stuinfo';
        }

        if ($database === null) {
            $database = new Medoo([
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


        $this->database = $database;
        $this->table = $table;

    }


    /** 插入某条信息
     * @param $stuno
     * @param $name
     * @param $age
     * @param $sex
     * @param $score
     * @param $grade
     * @param null $table
     * @param null $database
     * @throws Exception
     */
    public function insert($stuno, $name, $age, $sex, $score, $grade, $table = null, Medoo $database = null)
    {
        if ($table === null) {
            $table = $this->table;
        }

        if ($database === null) {
            $database = $this->database;
        }

        $pdo = $database->insert($table, [
            "stuno" => $stuno,
            "name" => $name,
            "age" => $age,
            "sex" => $sex,
            "score" => $score,
            "grade" => $grade,
            "time" => date('Y-m-d H:i:s'),
            "visible" => 1,
        ]);

        $insert = $pdo->rowCount();
        if (!is_numeric($insert) || $insert != 1) {
//            var_dump($insert);
            throw new Exception("DB_ERROR:".__CLASS__.'->'. __METHOD__, 500);

        }
    }

    /** 展示信息数据
     * @param $last_id
     * @param $offset
     * @param null $table
     * @param Medoo|null $database
     * @return array|bool
     * @throws Exception
     */
    public function selectInfo($last_id, $offset,  $table = null, Medoo $database = null)
    {
        if ($table === null) {
            $table = $this->table;
        }

        if ($database === null) {
            $database = $this->database;
        }


        $data = $database->select($table, [
            "id",
            "stuno",
            "name",
            "age",
            "sex",
            "score",
            "grade"
        ], [
            "AND" => [
                "visible" => 1
            ],

            "LIMIT"=>[$last_id,$offset]
        ]);

        if(!is_array($data)){
            throw new Exception("DB_ERROR:".__CLASS__.'->'. __METHOD__, 500);
        }
        return $data;


    }

    /** 实现软删除
     * @param $id
     * @param null $table
     * @param Medoo|null $database
     * @throws Exception
     */
    public function setInvisible($id, $table = null, Medoo $database = null)
    {

        if ($table === null) {
            $table = $this->table;
        }

        if ($database === null) {
            $database = $this->database;
        }

        $pdo = $database->update($table,[
            "visible"=>0
        ],[
            "AND"=>[
                "id"=>$id,
                "visible"=>1
            ]
        ]);
        $update = $pdo->rowCount();
        if (!is_numeric($update) || $update != 1) {
//            var_dump($insert);
            throw new Exception("DB_ERROR:".__CLASS__.'->'. __METHOD__, 500);
        }

    }

    public function sortInfo($field,$sortWay,$last_id,$offset,$table = null, Medoo $database = null)
    {
        if ($table === null) {
            $table = $this->table;
        }

        if ($database === null) {
            $database = $this->database;
        }

        $data = $database->select($table, [
            "id",
            "stuno",
            "name",
            "age",
            "sex",
            "score",
            "grade"
        ], [
            "AND" => [
                "visible" => 1
            ],
            "ORDER"=>[
                "$field"=>$sortWay
            ],
            "LIMIT"=>[$last_id,$offset]
        ]);

        if(!is_array($data)){
            throw new Exception("DB_ERROR:".__CLASS__.'->'. __METHOD__, 500);
        }
        return $data;

    }

}