<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-7-23
 * Time: 13:34
 */

namespace tlApp\dao;

use \Exception;
//use Medoo\Medoo;
//
//require '../../config/database_info.php';
//require '../../Medoo/Medoo.php';
//$p = new Problem();
//$d = $p->selectOne(17);
//var_dump($d);

class Problem extends BaseDao
{
//    protected $database;
//
//    /**
//     * BaseDao constructor.
//     */
//    public function __construct()
//    {
//        $this->database = new Medoo([
//            'database_type' => DATABASE_TYPE,
//            'database_name' => DATABASE_NAME,
//            'server' => SERVER,
//            'username' => USERNAME,
//            'password' => PASSWORD,
//            'charset' => CHARSET,
//            'port' => PORT,
//            'check_interval' => CHECK_INTERVAL
//        ]);
//    }


    protected $table = DB_PREFIX . "_problem_test";


    /**
     * @param array $problem_info
     * @param bool $ret_id
     * @return int|null|string
     * @throws Exception
     */
    public function insert(Array $problem_info, $ret_id = false)
    {

//        problem_info = compact($problem, $option_num, $options,$answers,$language, $classification, $pro_type, $pro_source, $hint);
//        problem_info 加多了两个 $problem_info['options_json'], $problem_info['answers_json'],
        //插入 问题主体
        $pdo = $this->database->insert($this->table, [
            'problem' => $problem_info['problem'],
            'option_num' => $problem_info['option_num'],
            'options' => $problem_info['options_json'],
            'answers' => $problem_info['answers_json'],
            'language' => $problem_info['language'],
            'classification' => $problem_info['classification'],
            'pro_type' => $problem_info['pro_type'],
            'pro_source' => $problem_info['pro_source'],
            'time' => date('Y-m-d H:i:s'),
            'latest' => date('Y-m-d H:i:s'),
            'total_edit' => 0,
            'visible' => 1

        ]);


        $pid = $this->database->id();
        if (!is_numeric($pid) || $pid < 1) {
//            var_dump($problem_info);
//            var_dump($pid);
//            var_dump( $this->database->error() );
            throw new Exception(__CLASS__ . __FUNCTION__ . ' pid error', 500);

        }

        //插入 问题提示
        if (!empty($problem_info['hint'])) {

            $table_hint = DB_PREFIX . '_hint';
            $pdo = $this->database->insert($table_hint, [
                'pid' => $pid,
                'hint' => $problem_info['hint'],
                'visible' => 1

            ]);

            $hid = $this->database->id();
            if (!is_numeric($hid) || $hid < 1) {
                throw new Exception(__FUNCTION__ . ' hid error', 500);
            }
        }

        return $ret_id === false ? null : $pid;
    }


    /** 更新题目主体信息 （需要先更新提示）
     * @param array $problem_info
     * @throws Exception
     */
    public function update(Array $problem_info)
    {
        $pdo = $this->database->update($this->table, [
            'problem' => $problem_info['problem'],
            'option_num' => $problem_info['option_num'],
            'options' => $problem_info['options_json'],
            'answers' => $problem_info['answers_json'],
            'language' => $problem_info['language'],
            'classification' => $problem_info['classification'],
            'pro_type' => $problem_info['pro_type'],
            'pro_source' => $problem_info['pro_source'],
            'latest' => date('Y-m-d H:i:s'),
            'total_edit[+]' => 1
        ], [
            'AND' => [
                'id' => $problem_info['pid'],
                'visible[!]' => 0
            ]
        ]);

        $affected = $pdo->rowCount();
        if (!is_numeric($affected) || $affected != 1) {
            throw new Exception(__CLASS__ . __FUNCTION__ . ' error', 500);
        }
    }


    /** 临时方法 根据pid 返回一个题目信息
     * todo 拆分proble表字段之后要弃用
     * @param $pid
     * @return array|bool
     * @throws Exception
     */
    public function selectOne_tmp($pid)
    {
        $table_h = DB_PREFIX . "_hint";

        $data = $this->database->select($this->table . '(p)', [
            "[>]" . "$table_h" . "(h)" => ['id' => 'pid'],
        ], [
            'p.id',
            'p.problem',
            //todo 之后去掉option_num
            'p.option_num',
            'p.options',
            'p.answers',
            'p.language',
            'p.classification',
            'p.pro_type',
            'p.pro_source',
            'h.hint'
        ], [
            'AND' => [
                'p.id' => $pid,
                'p.visible[!]' => 0
            ]
        ]);

        //一条或多条
        if (!is_array($data) || sizeof($data) != 1) {
            throw new Exception(__CLASS__ . __FUNCTION__ . ' error', 500);
        }

        return $data[0];
    }


    /** 获取题目主要信息（除option外）todo 需要修改problem表后使用
     * @param $pid
     * @return array|bool
     * @throws Exception
     */
    public function selectOne($pid)
    {
        $table_h = DB_PREFIX . "_hint";

        $data = $this->database->select($this->table.'(p)',
            [
                "[>]$table_h(h)" => [
                    "p.id" => "pid"
                ]
            ],
            [
                'p.id',
                'p.title_text',
                'p.title_pic',
                'p.answers',
                'p.language',
                'p.classification',
                'p.pro_type',
                'p.pro_source',
                'h.hint'

            ], [
                'AND' => [
                    'p.id' => $pid,
                    'p.visible[!]' => 0
                ]
            ]);

        //一条或多条
        if (!is_array($data) || sizeof($data) != 1) {
//            var_dump($this->database->error());
            throw new Exception(__CLASS__ . __FUNCTION__ . ' error', 500);
        }

        return $data[0];
    }


    /** 获取题目标题类型 todo 拆分proble表字段之后才能用
     * @param $pid
     * @throws Exception
     */
    public function getTitleType($pid)
    {
//        'TITLE_TYPE_PIC',1
//        'TITLE_TYPE_TEXT',2
        $data = $this->database->select($this->table, [
            'title_type'
        ], [
            'AND' => [
                'p.id' => $pid,
                'p.visible[!]' => 0
            ]
        ]);

        if (!is_array($data) || sizeof($data) != 1) {
            throw new Exception(__CLASS__ . __FUNCTION__ . ' error', 500);
        }


    }
}