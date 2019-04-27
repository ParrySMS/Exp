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
const FILENAME_TEST_SET_IDS ='TestSetIds';

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

    //有H 输出说明文字 函数在配置文件里 纯内容输出
    if(empty($cmd_param_arr) || array_key_exists('H',$cmd_param_arr)){
        cmdHelp();//in '../config/msg.php';
        return;
    }

    //获取对应的命令行参数 根据参数来调后面的条件
    $param_t = $cmd_param_arr['T']??null;
    $param_n = $cmd_param_arr['N']??null;
//    print_r($cmd_param_arr);

//    $datas = [];
    $pro = new Problem();  //功能封装到对象里了
    //根据参数调整条件数组
    $pro_source =$pro->getSource($param_t);
    //原始文档的类别 拿到该大类别下的全部数据
    $datas = $pro->getDatas($pro_source);

    //拿出来之后打乱
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

    $test_ids = [];
    foreach ($test_set as & $pro){
        $test_ids[] = $pro['id'];
    }


    $json_train_set = json_encode($train_set);
    $json_non_train_set = json_encode($non_train_set);
    $json_test_set = json_encode($test_set);
    $json_test_ids = json_encode($test_ids);


    //写入文件流
    $file_suffix = "-$param_t.json";

    $file_train_set = fopen(FILENAME_TRAIN_SET.$file_suffix, "w") or die("Unable to open file:".FILENAME_TRAIN_SET . $file_suffix);
    fwrite($file_train_set, $json_train_set);
    fclose($file_train_set);

    $file_non_train_set = fopen(FILENAME_NON_TRAIN_SET.$file_suffix, "w") or die("Unable to open file:".FILENAME_NON_TRAIN_SET . $file_suffix);
    fwrite($file_non_train_set, $json_non_train_set);
    fclose($file_non_train_set);

    $file_test_set = fopen(FILENAME_TEST_SET.$file_suffix, "w") or die("Unable to open file:".FILENAME_TEST_SET . $file_suffix);
    fwrite($file_test_set, $json_test_set);
    fclose($file_test_set);

    $file_test_ids = fopen(FILENAME_TEST_SET_IDS.$file_suffix, "w") or die("Unable to open file:".FILENAME_TEST_SET_IDS . $file_suffix);
    fwrite($file_test_ids, $json_test_ids);
    fclose($file_test_ids);

    //完成信息提示
    echo "The datas about <$param_t>: ".$datas_size.PHP_EOL;
    echo "TranSet: $train_select_len".PHP_EOL;
    echo 'NonTranSet: '.($datas_size-$train_select_len).PHP_EOL;
    echo 'TestSet is '.TEST_SET_SELECT_NUM.PHP_EOL;

} catch (Exception $e) {
    echo $e->getMessage();
}

