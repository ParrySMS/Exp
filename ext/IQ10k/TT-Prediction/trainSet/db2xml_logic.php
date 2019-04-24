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


set_time_limit(0);

try {
    //原始文档类别 拿到全部数据
    $pro_source = ["logic-C","logic-E","logic-CE"];
    $pro = new Problem();
    $datas = $pro->getDatas($pro_source);

//    echo sizeof($datas).PHP_EOL;
//    var_dump($datas);

    //打乱 抽一半做训练集
    $half_len = intval(sizeof($datas)/2);
    shuffle($datas);

    unset($train_set);
    $train_set = [];
    $train_set = array_slice($datas,0,$half_len);

    $json = json_encode($train_set);

//    $myfile = fopen("./trainLogic500.json", "w") or die("Unable to open file!");
//    fwrite($myfile, $json);
//    fclose($myfile);
    echo "done: $half_len".PHP_EOL;

} catch (Exception $e) {
    echo $e->getMessage();
}
