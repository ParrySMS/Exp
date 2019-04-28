<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-11-30
 * Time: 21:42
 */

class Seq
{

    protected $database;

    static $T_ACTION = DB_PREFIX . '_action';
//    static $T_COMMENT = DB_PREFIX . "_comment_test";
    static $T_COMMENT = DB_PREFIX . "_comment_adddiagramspecial";
//    static $T_HINT = DB_PREFIX . "_hint_test";
    static $T_HINT = DB_PREFIX . "_hint_adddiagramspecial";
    static $T_OPTION = DB_PREFIX . "_option_adddiagramspecial";
    static $T_PROBLEM = DB_PREFIX . "_problem_adddiagramspecial";

    //trans
    static $T_TRANS_PROBLEM = DB_PREFIX . "_problem_cetrans_not_en";
    static $T_TRANS_OPTION = DB_PREFIX . "_option_cetrans";
    static $T_TRANS_HINT = DB_PREFIX . "_hint_cetrans";

    /**
     * @return \Medoo\Medoo
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * BaseDao constructor.
     */
    public function __construct()
    {
        $this->database = new  Medoo\Medoo([
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


    /** 记录用户的请求 开始正常执行会记录一次 报错会再记录一次
     * @param $uid
     * @param $ip
     * @param $agent
     * @param $error_code
     * @param null $time
     * @return int|mixed|string
     */
    public function insertAction($uid, $ip, $agent, $error_code, $time = null)
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        //秒级时间
        if ($time === null) {
            $time = date(DB_TIME_FORMAT);
        }
        $pdo = $this->database->insert($this::$T_ACTION, [
            'uid' => $uid,
            'agent' => $agent,
            'ip' => $ip,
            'uri' => $uri,
            'method' => $method,
            'error_code' => $error_code,
            'time' => $time,
            'visible' => VISIBLE_NORMAL
        ]);
        $id = $this->database->id();
        //因为可能是在catch块里的记录 所以不适用throw报错
        if (!is_numeric($id) || $id < 1) {
//          var_dump($this->database->error());
            echo '<br/>' . __CLASS__ . '->' . __FUNCTION__ . '(): error';
//            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '(): error', 500);
        }
        return $id;
    }

    /** 获取有效的id集合 用于抽取固定的题目数量
     * @return array|bool
     * @throws Exception
     */
    public function getVaildId()
    {
        $ids = $this->database->select($this::$T_PROBLEM, 'id', [
            'AND' => [
                'pro_source' => 'new-test-seq',
                'visible[!]' => VISIBLE_DELETE
            ]
        ]);

        if (!is_array($ids) && sizeof($ids) == 0) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '(): error', 500);
        }

        return $ids;

    }

    /** 获取db里的某些固定id的seq数据
     * @param array $ids
     * @param string $pro_source
     * @return array|bool
     * @throws Exception
     */
    public function getDatasInSet(array $ids, $pro_source = 'new-test-seq')
    {

        $datas = $this->database->select($this::$T_PROBLEM . '(p)', [
            "[>]" . $this::$T_HINT . "(h)" => ['p.id' => 'pid']
        ], [
            'p.id',
            'p.title',
            'p.title_pic',
            'p.option_ids',
//            'p.answers',//这个是json
//        'p.language',
            'p.classification(subtype)',
            'p.pro_type',
            'p.pro_source(type)',
//        'p.time',
//        'p.edit_time',
//        'p.total_edit',
//            'p.comment_num',
//            'h.hint',
        ], [
            'AND' => [
                'p.id' => $ids, //for test
                'p.pro_source' => $pro_source,
                'p.visible[!]' => VISIBLE_DELETE
            ],
//        "LIMIT" => 10
        ]);

        foreach ($datas as & $pro_data) {
            //先获取在主体题目信息（可能有hint）

//            $pro_data['answers'] = json_decode($pro_data['answers']);
            //然后获取选项信息
            $oids = json_decode($pro_data['option_ids']);
            //对象数组
            $pro_data['options'] = [];

//        var_dump($pro_data);

            if (is_array($oids) && sizeof($oids) != 0) {
                $pro_data['options'] = $this->getOptions($oids, $this->database, $this::$T_OPTION);
            }

            //clear
            unset($pro_data['option_ids']);

            $pro_data['title_content'] = $this->getTitleContent($pro_data['title']);

        }

        return $datas;
    }

    /** 清洗题目数据
     * @param $title
     * @return string
     * @throws Exception
     */
    private function getTitleContent($title)
    {

        if (!is_string($title) || empty($title)) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . " title not string", 500);
        }

        //get string after digit
//    for ($i = 0; $i < strlen($title); $i++) {
//        $char = substr($title, $i, 1);
//        if (ctype_digit($char)) {
//            $title_content = trim(substr($title,$i));
//        }
//    }

        $title_content = trim(str_replace("\n", "", preg_replace('/([A-Za-z\x80-\xff]*)/i', '', $title)));

        return $title_content;

    }


    /** 包装选项数组
     * @param $oids
     * @param \Medoo\Medoo $database
     * @param $table
     * @return array
     * @throws Exception
     */
    private function getOptions($oids, \Medoo\Medoo & $database, $table)
    {


        $datas = $this->selectGroup($oids, $database, $table);

        unset($options);
        $options = [];

        foreach ($datas as $d) {
            $options[] = (object)$d;
        }

        return $options;
    }


    /** 获取选项
     * @param array $option_ids
     * @param \Medoo\Medoo $database
     * @param $table
     * @return array|bool
     * @throws Exception
     */
    private function selectGroup(array $option_ids, \Medoo\Medoo & $database, $table)
    {
        $data = $database->select($table, [
//        'id',
            'key',
            'content',
            'is_pic'
        ], [
            'AND' => [
                'id' => $option_ids,
                'visible[!]' => VISIBLE_DELETE
            ]
        ]);

        //多条
        if (!is_array($data) || sizeof($data) == 0) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '(): error', 500);
        }

        return $data;

    }

    /** 判断是否超过限制进入的次数
     * @param $uid
     * @param $limit
     * @return bool
     */
    public function isLimited($uid, $limit = ACCESS_LIMITED_NUM_SZU)
    {
        if ($uid == SEQ200_TESTUID) {
            return false;
        }

        $num = $this->database->count($this::$T_ACTION, [
            'AND' => [
                'uid' => $uid,
                'uri' => '/parry/IQ10K/seq200.php?uid=' . $uid,
                'error_code' => null,
                'time[<>]' => [date('Y-m-d'), date('Y-m-d H:i:s'), time()],
                'visible[!]' => VISIBLE_DELETE,

            ]
        ]);

        return $num < $limit ? false : true;

    }


}