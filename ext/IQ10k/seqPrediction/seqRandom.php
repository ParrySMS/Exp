<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-12-21
 * Time: 15:21
 */

namespace IQ10K;

use Exception;

require './Http.php';

define('NAME', '');//姓名评拼音
define('STU', '');//学号
define('SEQ_URL', '');//请求地址
define('OUTPUT_FILE_NAME', 'seq.predict');//输出的文件名

//$uid = md5(NAME . STU);
$uid ='testuid';

$http = new Http();//预定义的 http请求类
try {

    $quiz_json = $http->get(SEQ_URL, compact('uid'));
    //json 格式详见Seq内测接口说明文档

    echo 'GET quiz_json' . PHP_EOL;

    $questionAr = json_decode($quiz_json);
    $output = json_encode(seqPredict($questionAr));

    echo 'WRITE ' . OUTPUT_FILE_NAME . PHP_EOL;
    //写入文件
    writeIn($output);

    echo 'done' . PHP_EOL;

} catch (Exception $e) {
    echo $e->getCode() . ': ' . $e->getMessage();
}


/** 把题目数据抽取出来 调用预测的方法来选出答案
 * @param array $questionAr
 * @return array
 */
function seqPredict(array $questionAr)
{
    $output = [];
    foreach ($questionAr as $q) {
        $id = $q->id;
        $title_content = $q->title_content;
        $options = $q->options;


        // todo 对题目内容 $title_content 以及选项内容 $key_value_option
        // todo 调用训练好的模型
        // todo 进行分析处理得出答案 然后选出对应的选项

        $random_key = rand(0, sizeof($options) - 1);
        $answer = $options[$random_key]->key;

        echo "id:$id, answer:$answer" . PHP_EOL;

        //写入数组尾部
        $output[] = (object)[
            'Answer' => $answer,
            'ID' => $id
        ];
    }

    return $output;
}


/**
 * @param $output
 * @throws Exception
 */
function writeIn($output,$filename = OUTPUT_FILE_NAME ){
    $file = fopen($filename, "w");
    if (!$file) {
        throw new Exception('Unable to open file: ' . OUTPUT_FILE_NAME, 500);
    }
    fwrite($file, $output);
    fclose($file);
}



