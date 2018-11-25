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



set_time_limit(0);

try {
//    $datas = getDatas();
    newSeq();
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



function addSeqProComma()
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
//            'p.language' => 'en',
            'OR' => [
                'p.title[!~]' => '，',
                'p.title[!~]' => ',',
            ]

        ],
//        "LIMIT" => 10
    ]);

    foreach ($datas as &$p) {
        $p['title'] = trim($p['title']);
        $t = str_replace("？", "?", $p['title']);//全角空格 半角空格
        $t = str_replace("，", ",", $t);

        if ($p['title'][0] == '?' //add sign
            || $p['title'][0] == '？'
            || ($p['title'][0] == '-' && is_numeric($p['title'][1]))
            || ($p['title'][0] == '√' && is_numeric($p['title'][1]))
            || is_numeric($p['title'][0])) {

            if (strpos($t, ',') == false) {
                echo '<br/>【】' . $p['id'] . ":  " . $t . '<br/>';
                $t = str_replace(" ", ",", $t);


            }

        }

//       todo 临时关闭
//        $database->update($dao::$T_PROBLEM, [
//            'title' => $t,
//            'edit_time'=>date('Y-m-d H:i:s')
//        ], [
//            'id' => $p['id']
//        ]);
    }
}


//todo 根据公式生成 seq题

//An = Rn+B
function newSeq1(){
    $hp = new Http();

    define("TNUM",400);

    for($t_num =0;$t_num<TNUM;$t_num++) {


        $r = intval(rand(-80, 80));
        while ($r==0){
            $r = intval(rand(-80, 80));
        }

        $b = intval(rand(-80, 80));
        $m = intval(rand(1,5));
        $title = '';
        for ($i = 0; $i < 7; $i++) {
            //An = Rn+B, 填中间
            if($i == $m){
                $title = $title . ",?";
                continue;
            }

            $data = $r * $i + $b;

            if($i == 0) {
                $title = $title . "$data";
            }else{
                $title = $title . ",$data";
            }
        }

        //An = Rn+B, 填末尾
//        $title = $title . ",?";
//        $res = $r*7 + $b;
        //An = Rn+B, 填中间
        $res = $r*$m + $b;

        $ar = [$res,$res+intval(rand(-5,-3)),$res+intval(rand(-2,-1)),$res+intval(rand(1,4))];
        shuffle($ar);
        $optionAr = [
            'a'=>$ar[0],
            'b'=>$ar[1],
            'c'=>$ar[2],
            'd'=>$ar[3],
        ];
        //find correct answer
        for ($i = 0; $i < 4; $i++) {
            if($ar[$i] == $res){
                break;
            }
        }

        $ks = ['a','b','c','d'];
        $answers =[$ks[$i]];
        $language = 'en';
        $classification = 'sequence';
        $pro_type = 'exclusive choice';
        $pro_source = 'new_seq';
        if($b==0) {
            $hint = "A[n]=$r*n";
        }else if($b>0){
            $hint = "A[n]=$r*n+$b";
        }else{
            $hint = "A[n]=$r*n$b";

        }
        $problem_info = compact('title', 'optionAr' ,'answers', 'language', 'classification', 'pro_type', 'pro_source', 'hint');

        echo $t_num;
        echo PHP_EOL;
        echo json_encode($problem_info);//insert
        echo PHP_EOL;

        $hp->post('http://exp.szer.me/parry/testlib/problem',$problem_info,false);
    }

    curl_close($hp->ch);


}

function newSeq2(){

}



//function insertPro(array $problem_info){
//    $dao = new BaseDao();
//    $database = $dao->getDatabase();
////
////        problem_info 加多了  $problem_info['answers_json'],
//    //插入 问题主体
//    $pdo = $database->insert($dao::$T_PROBLEM, [
//        'title' => $problem_info['title'],
//        'answers' => $problem_info['answers_json'],
//        'language' => $problem_info['language'],
//        'classification' => $problem_info['classification'],
//        'pro_type' => $problem_info['pro_type'],
//        'pro_source' => $problem_info['pro_source'],
//        'time' => date(DB_TIME_FORMAT),
//        'edit_time' => date(DB_TIME_FORMAT),
//        'total_edit' => 0,
//        'visible' => VISIBLE_NORMAL,
//        'comment_num' => 0
//
//    ]);
//
//    $pid = $database->id();
//    if (!is_numeric($pid) || $pid < 1) {
//        throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():  pid error', 500);
//
//    }
//
//    //插入 问题提示
//        if (!empty($problem_info['hint'])) {
//
//            $pdo = $this->database->insert($dao::$T_HINT, [
//                'pid' => $pid,
//                'hint' => $problem_info['hint'],
//                'time' => date(DB_TIME_FORMAT),
//                'visible' => VISIBLE_NORMAL
//
//            ]);
//
//            $hid = $database->id();
//            if (!is_numeric($hid) || $hid < 1) {
//                throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():  hid error', 500);
//            }
//        }
//
//}


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