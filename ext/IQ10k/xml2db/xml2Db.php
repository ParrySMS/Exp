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

define('SOURCE', '');//todo 手动调整

$xml_file = simplexml_load_file($filePath . $fileName);

$http = new Http();
$xml = new Xml();

//var_dump($xml_file->Data[11]);

try {
    foreach ($xml_file->Data as $d) {
        //todo 实现参数处理
        $pro_array = $xml->pmcheck($d);

        //插入题目
        $pid = $xml->insertPro($pro_array);

        if (isset($data->Option)) {
            //选项
            $optionAr = get_object_vars($d->Option);
            $oidsJson = $xml->getOidsJson($pid,$optionAr);
            //todo 实现
            $xml->setProOids($oidsJson);
        }
    }
} catch (Exception $e) {
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

    }

    //todo 实现插入题目基本内容 返回pid
    public function insertPro(array $pro)
    {

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
            throw new Exception('answer null', 500);
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

        $pro_array = compact('title', 'answers', 'answers_json', '$lang', 'classification', 'pro_type', 'hint');

        return $pro_array;
    }

    /** 获取oid的json
     * @param $pid
     * @param $optionAr
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


    public function insertOption($pid, $key, $content, $is_pic = 0)
    {
        //todo 数据库插入1条 返回oid

    }

    /** 获取语言类型
     * @param $str
     * @return string
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
}
