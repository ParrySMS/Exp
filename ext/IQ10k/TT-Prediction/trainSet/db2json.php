<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-4-23
 * Time: 18:09
 */

require '../Http.php';
require '../config/database_info.php';
require '../config/params.php';
require '../config/msg.php';
require '../config/Medoo.php';
require './BaseDao.php';
require './Problem.php';

/**
 * 选取训练集相关的常数参数，需要自行预定义
 */
const TRAIN_SET_SELECT_RADIO = 0.50;
//const TEST_SET_SELECT_RADIO = 0.50;
const TEST_SET_SELECT_NUM = 100;

//TranSet-<typename>.json
const FILENAME_TRAIN_SET ='TranSet';
const FILENAME_NON_TRAIN_SET ='NonTranSet';
const FILENAME_TEST_SET ='TestSet';

set_time_limit(0);

try {

    //使用命令行参数来输出哪一个类别的训练集数据集
    //直接放出训练与非训练，测试则读取非训练 抽取固定的题目
    // * 使用 $argc $argv 接受参数

    $cmd_param_arr = getopt('H:T:N:');
    /**  选择命令行参数类型
     * H: help
     * T: type
     * N: num
     **/
    if(empty($cmd_param_arr) || array_key_exists('H',$cmd_param_arr)){
        cmdHelp();//in '../config/msg.php';
        return;
    }

    $param_t = $cmd_param_arr['T']??null;
    $param_n = $cmd_param_arr['N']??null;
//    print_r($cmd_param_arr);

//    $datas = [];
    //原始文档类别 拿到全部数据
    $pro = new Problem();
    $pro_source =getPro_source($param_t);
    $datas = $pro->getDatas($pro_source);
    $datas_size = sizeof($datas);
    shuffle($datas);

//    var_dump($datas);

    //确认具体的数据条数
    $train_select_len = intval($datas_size*TRAIN_SET_SELECT_RADIO);
    $param_n = $param_n ?? $datas_size;
    $train_select_len = $train_select_len < $param_n ? $train_select_len:$param_n;

    $non_train_select_len = $datas_size - $train_select_len;
//    $test_select_len = intval($non_train_select_len*TEST_SET_SELECT_RADIO);
    $test_select_len = TEST_SET_SELECT_NUM;


    //切分具体的数据json
    $train_set = array_slice($datas,0,$train_select_len);
    $non_train_set = array_slice($datas,$train_select_len);
    shuffle($non_train_set);
    $test_set = array_slice($non_train_set,0,$test_select_len);

    $json_train_set = json_encode($train_set);
    $json_non_train_set = json_encode($non_train_set);
    $json_test_set = json_encode($test_set);

    //写入文件流
    $file_suffix = "-$param_t.json";

    $file_train_set = fopen(FILENAME_TRAIN_SET.$file_suffix, "w") or die("Unable to open file:".FILENAME_TRAIN_SET);
    fwrite($file_train_set, $json_train_set);
    fclose($file_train_set);

    $file_non_train_set = fopen(FILENAME_NON_TRAIN_SET.$file_suffix, "w") or die("Unable to open file:".FILENAME_TRAIN_SET);
    fwrite($file_non_train_set, $json_non_train_set);
    fclose($file_non_train_set);

    $file_test_set = fopen(FILENAME_TEST_SET.$file_suffix, "w") or die("Unable to open file:".FILENAME_TRAIN_SET);
    fwrite($file_test_set, $json_test_set);
    fclose($file_test_set);

    //完成信息提示
    echo "The datas about <$param_t>:".$datas_size.PHP_EOL;
    echo "TranSet: $train_select_len".PHP_EOL;
    echo 'NonTranSet: '.($datas_size-$train_select_len).PHP_EOL;
    echo 'TestSet is '.TEST_SET_SELECT_NUM.PHP_EOL;

} catch (Exception $e) {
    echo $e->getMessage();
}


/** 根据输入的命令行参数，决定选取的题目类型
 * @param $argv_param_t
 * @return array
 * @throws Exception
 */
function getPro_source($argv_param_t):array
{
    switch ($argv_param_t){
        case 'logic':
        case 'LOGIC':
            return ['logic-C','logic-E'];

        case 'diagram':
        case 'DIAGRAM':
//            return ['diagram','logic-diagram'];
            return ['diagram'];

        case 'verbal':
        case 'VERBAL':
            return ['verbal-C','verbal-E'.'verbal-CE'];

        case 'seq':
        case 'SEQ':
            return ['seq'];
        default:
            throw new Exception("argv_param_t <typename> $argv_param_t is invaild",400);
    }
}