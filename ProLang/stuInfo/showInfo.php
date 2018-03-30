<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-3-29
 * Time: 12:54
 */
require "./autoload.php";
use stuApp\common\Safe;

try{
    //执行记录
    unset($logs);
    $logs = array();
    $log = new \stuApp\model\execLog(__FILE__);
    $logs[]=$log;

    //游标法记录条数
    $last_id = empty($_GET['last_id'])?0:$_GET['last_id'];//可选参数
    $offset = empty($_GET['offset'])?INFO_OFFSET:$_GET['offset'];//可选参数

    //参数检查
    $pmCheck = new \stuApp\common\paramsCheckSI($last_id,$offset);
    $last_id = $pmCheck->getLastId();
    $offset = $pmCheck->getOffset();

    //数据库执行
    $stuInfo = new \stuApp\dao\StuInfo();
    $datas = $stuInfo->selectInfo($last_id,$offset);

    unset($infos);
    $infos = [];
    //数据封装
    foreach ($datas as $dataOptionArray){
        $info = new \stuApp\model\Info($dataOptionArray);
        $infos[] = $info;
    }
    //抽成对象属性
    $retdata = (object)["infos"=>$infos];
    //输出
    $json = new \stuApp\model\Json($retdata);
    print_r(json_encode($json));

    $log = new \stuApp\model\execLog(__FILE__);
    $logs[]=$log;
//    var_dump($logs);

}catch (Exception $e){
    httpStatus($e->getCode());
    echo $e->getMessage();
}