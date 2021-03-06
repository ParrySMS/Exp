<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-8-29
 * Time: 15:47
 */

require './Http.php';
require './config/database_info.php';
require './config/params.php';
require './config/Medoo.php';

$filePath = './xml/';

//todo 根据具体情况填写参数
//$fileName = 'test.xml';
//$fileName = 'new-seq.xml';

//$fileArray = ['new-verbal-C.xml','new-verbal-E.xml','new-verbal-CE.xml'];
//$fileArray = ['new-verbal-E-4507part.xml'];

//define('SOURCE', 'test');

//define('SOURCE', 'verbal-E');

set_time_limit(0);

foreach ($fileArray as $fileName) {

    $xml_file = simplexml_load_file($filePath . $fileName);

    $http = new Http();
    $xml = new Xml();

//var_dump($xml_file->Data[11]);

    try {
        foreach ($xml_file->Data as $d) {
            //实现参数处理
            $pro_array = $xml->pmcheck($d);

            //插入题目
            $pid = $xml->insertPro($pro_array);

            //插入有关联的提示
            if (!empty($pro_array['hint']||$pro_array['hint']!=0)) {
                $xml->insertHint($pid, $pro_array['hint']);
            }

            if (isset($d->Option)) {
                //插入选项
                $optionAr = get_object_vars($d->Option);
                $oidsJson = $xml->getOidsJson($pid, $optionAr);
                //实现选项id关联
                $xml->setProOids($pid, $oidsJson);
            }

            echo 'finish one';
            echo PHP_EOL;


        }

        echo 'finish all';
        echo PHP_EOL;


    } catch (Exception $e) {
        echo $e->getMessage();
//    $http->status($e->getCode());
    }

}

/** 处理题目内容的xml类 **/
class Xml
{
    public $name;
    public $table;
    public $table_op;
    public $table_hint;
    public $database;

    /**
     * TitlePic constructor.
     */
    public function __construct()
    {
        $this->name = 'problem_addmostxml';
//        $this->name = 'problem_test';

        $this->table = DB_PREFIX . '_' . $this->name;
        $this->table_op = DB_PREFIX . '_option_addmostxml';
        $this->table_hint = DB_PREFIX . '_hint_addmostxml';

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

    //实现插入题目基本内容 返回pid

    /**
     * [insertPro description]
     * @param  array $problem_info [description]
     * @return [type]               [description]
     * @throws Exception
     */
    public function insertPro(array $problem_info)
    {
        /**
         * pro_array
         *  [title]
         *  [answers]
         *  [answers_json]
         *  [lang]
         *  [classification]
         *  [pro_type]
         *  [hint]
         */

        //插入 问题主体
        $pdo = $this->database->insert($this->table, [
            'title' => $problem_info['title'],
            'answers' => $problem_info['answers_json'],
            'language' => $problem_info['lang'],
            'classification' => $problem_info['classification'],
            'pro_type' => $problem_info['pro_type'],
            'pro_source' => SOURCE,
            'time' => date(DB_TIME_FORMAT),
            'edit_time' => date(DB_TIME_FORMAT),
            'total_edit' => 0,
            'visible' => VISIBLE_NORMAL,
            'comment_num' => 0

        ]);

        $pid = $this->database->id();
        if (!is_numeric($pid) || $pid < 1) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():  pid error', 500);

        }

        return $pid;


    }


    /** 插入提示
     * @param $pid
     * @param $hint
     * @return int|mixed|string
     * @throws Exception
     */
    public function insertHint($pid, $hint)
    {
        $pdo = $this->database->insert($this->table_hint, [
            'pid' => $pid,
            'hint' => $hint,
            'time' => date(DB_TIME_FORMAT),
            'visible' => VISIBLE_NORMAL
        ]);

        $hid = $this->database->id();
        if (!is_numeric($hid) || $hid < 1) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():  pid error', 500);

        }

        return $hid;
    }

    /** 参数检查 返回题目数组
     * @param $data
     * @throws Exception
     */
    public function pmcheck($data)
    {


        if (!isset($data->Problem)) {
            throw new Exception('title null', 500);
        }
        $title = trim($data->Problem);


        if (!isset($data->Answer)) {
            $data->Answer = "null";
//            throw new Exception("title:$title  -- answer null", 500);
        }


        $hint = isset($data->Hint) ? trim($data->Hint) : null;
        $classification = isset($data->Classification) ? trim($data->Classification) : null;

        //语言
        $lang = $this->getLang($title . $hint);


        unset($answers);
        $answers = [];

        //确认pro_type题型和answers回答
        if (!isset($data->Option)) {//无选项
            //判断题型
            $pro_type = 'exclusive fill';
            $answers = [trim($data->Answer)];//注意是数组 因为填空 直接写
        } else {//有选项

            $answer = trim($data->Answer);
            $len = strlen($answer);

            if ($len == 1) {//单选
                $pro_type = 'exclusive choice';
                $answers = [$answer];

            } else {//多选
                $pro_type = 'multiple  choice';
                for ($i = 0; $i < $len && !empty($answer{$i}); $i++) {//逐个非空字符读入
                    $answers[] = $answer{$i};
                }
            }
        }

        $answers_json = json_encode($answers);

        $pro_array = compact('title', 'answers', 'answers_json', 'lang', 'classification', 'pro_type', 'hint');
        /**
         * pro_array
         *  [title]
         *  [answers]
         *  [answers_json]
         *  [lang]
         *  [classification]
         *  [pro_type]
         *  [hint]
         */

        return $pro_array;
    }

    /** 获取oid的json
     * @param $pid
     * @param $optionAr
     * @throws Exception
     * @return string
     */
    public function getOidsJson($pid, $optionAr)
    {
        //有选项还有要分开插入获取ids
        unset($option_ids);
        $option_ids = [];

        if (sizeof($optionAr) != 0) {//有内容的数组
            foreach ($optionAr as $key => $value) {
                $option_ids[] = $this->insertOption($pid, strtolower($key), $value);
            }
        }

        return json_encode($option_ids);

    }


    /** 数据库插入1条 返回oid
     * [insertOption description]
     * @param  [type]  $pid     [description]
     * @param  [type]  $key     [description]
     * @param  [type]  $content [description]
     * @param  integer $is_pic [description]
     * @return [type]           [description]
     * @throws Exception
     */
    public function insertOption($pid, $key, $content, $is_pic = 0)
    {

        $pdo = $this->database->insert($this->table_op, [
            'pid' => $pid,
            'key' => $key,
            'content' => $content,
            'is_pic' => $is_pic,
            'time' => date(DB_TIME_FORMAT),
            'edit_time' => date(DB_TIME_FORMAT),
            'visible' => VISIBLE_NORMAL
        ]);

        $id = $this->database->id();

        if (!is_numeric($id) || $id < 1) {
            throw new Exception(__CLASS__ . __FUNCTION__ . '():  pid error', 500);

        }

        return $id;

    }

    /** 获取语言类型
     * @param $str
     * @return string
     * @throws Exception
     */
    public function getLang($str)
    {

        $isCh = preg_match('/[' . chr(0xa1) . '-' . chr(0xff) . ']/', $str);
        $isAlp = preg_match('/[a-zA-Z]/', $str);
//        $isNum=preg_match('/[0-9]/', $str);

        if (!$isCh && $isAlp) {
            return 'en';

        } else if ($isCh && !$isAlp) {
            return 'zh';

        } else {
            return 'mutil';
        }

    }

    /** 补充插回选项数据
     * @param $pid
     * @param $oidsJson
     * @throws Exception
     */
    public function setProOids($pid, $oidsJson)
    {
        $pdo = $this->database->update($this->table, [
            'option_ids' => $oidsJson
        ], [
            'AND' => [
                'id' => $pid,
                'visible' => VISIBLE_NORMAL,
            ]
        ]);

        $affected = $pdo->rowCount();
        if (!is_numeric($affected) || $affected != 1) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():  error', 500);
        }


    }
}
