<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-11-4
 * Time: 19:30
 */

require './Http.php';
require './config/database_info.php';
require './config/params.php';
require './config/Medoo.php';


//todo 把选项小写洗一洗 然后还有选择题答案是字符的问题 或者答案丢失的问题

set_time_limit(0);

try {
//    $datas = getDatas();
    addsign();
//    var_dump($datas);
//    print_r(json_encode($datas));

} catch (Exception $e) {
    echo $e->getMessage();
}


/** 获取db里的seq数据
 * @return array|bool
 * @throws Exception
 */
function getDatas()
{
    $dao = new BaseDao();
    $database = $dao->getDatabase();

    $datas = $database->select($dao::$T_PROBLEM . '(p)', [
        "[>]" . $dao::$T_HINT . "(h)" => ['p.id' => 'pid']
    ], [
        'p.id',
        'p.title',
        'p.title_pic',
        'p.option_ids',
        'p.answers',//这个是json
//        'p.language',
        'p.classification(subtype)',
        'p.pro_type',
        'p.pro_source(type)',
//        'p.time',
//        'p.edit_time',
//        'p.total_edit',
//            'p.comment_num',
        'h.hint',
    ], [
        'AND' => [
//            'p.id'=>[4572,4665,4734,4006,3197,3198,3199], //for test
            'p.pro_source' => 'seq',
            'p.visible[!]' => VISIBLE_DELETE
        ],
//        "LIMIT" => 10
    ]);

    foreach ($datas as & $pro_data) {
        //先获取在主体题目信息（可能有hint）

        $pro_data['answers'] = json_decode($pro_data['answers']);
        //然后获取选项信息
        $oids = json_decode($pro_data['option_ids']);
        //对象数组
        $pro_data['options'] = [];

//        var_dump($pro_data);

        if (is_array($oids) && sizeof($oids) != 0) {
            $pro_data['options'] = getOptions($oids, $database, $dao::$T_OPTION);
        }

        //clear
        unset($pro_data['option_ids']);

        $pro_data['title_content'] = getTitleContent($pro_data['title']);

    }

    return $datas;
}


/**
 * @param $title
 * @return string
 * @throws Exception
 */
function getTitleContent($title)
{

    if (!is_string($title) || empty($title)) {
        throw new Exception("title not string");
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
 * @return array
 * @throws Exception
 */
function getOptions($oids, & $database, $table)
{

    $datas = selectGroup($oids, $database, $table);

    unset($options);
    $options = [];

    foreach ($datas as $d) {
        $options[] = (object)$d;
    }

    return $options;
}


/** 获取选项
 * @param array $option_ids
 * @return mixed
 * @throws Exception
 */
function selectGroup(array $option_ids, \Medoo\Medoo & $database, $table)
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


function addsign()
{
    $dao = new BaseDao();
    $database = $dao->getDatabase();
    $datas = $database->select($dao::$T_PROBLEM . '(p)', [
        "[>]" . $dao::$T_HINT . "(h)" => ['p.id' => 'pid']
    ], [
        'p.id',
        'p.title',
//        'p.title_pic',
        'p.option_ids',
        'p.answers',//这个是json
//        'p.language',
        'p.classification(subtype)',
        'p.pro_type',
        'p.pro_source(type)',
//        'p.time',
//        'p.edit_time',
//        'p.total_edit',
//            'p.comment_num',
        'h.hint',
    ], [
        'AND' => [
//            'p.id'=>[4572,4665,4734,4006,3197,3198,3199], //for test
            'p.pro_source' => 'seq',
            'p.visible[!]' => VISIBLE_DELETE,
            'p.pro_type[~]' => 'choice',
            'p.language' => 'en',
            'OR' => [
                'p.title[!~]' => '，',
                'p.title[!~]' => ',',
            ]

        ],
//        "LIMIT" => 10
    ]);

    foreach ($datas as &$p){
        //todo p.title clean dirty thing
    }
}

class BaseDao
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


}