<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-3-29
 * Time: 17:51
 */
require "./autoload.php";

use stuApp\common\Safe;

try {
    //执行记录
    unset($logs);
    $logs = array();
    $log = new \stuApp\model\execLog(__FILE__);
    $logs[] = $log;


    $field = empty($_GET['field']) ? null : $_GET['field'];
    //操作数可能为0
    $sortOption = isset($_GET['sort']) ? $_GET['sort']:null;
    //游标法记录条数
    $last_id = empty($_GET['last_id'])?0:$_GET['last_id'];//可选参数
    $offset = empty($_GET['offset'])?INFO_OFFSET:$_GET['offset'];//可选参数


    //参数检查
    $pmCheckSI = new \stuApp\common\paramsCheckSI($last_id,$offset);
    $last_id = $pmCheckSI->getLastId();
    $offset = $pmCheckSI->getOffset();
    //参数检查
    $pmCheck = new \stuApp\common\paramsCheckSort($field,$sortOption);
    $sortWay = $pmCheck->getSortWay();
    $field = $pmCheck->getField();

    //执行排序取出数据
    //数据库执行
    $stuInfo = new \stuApp\dao\StuInfo();
    $datas = $stuInfo->sortInfo($field,$sortWay,$last_id,$offset);

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

    //结束
    $log = new \stuApp\model\execLog(__FILE__);
    $logs[]=$log;
//    var_dump($logs);

} catch (Exception $e) {
    httpStatus($e->getCode());
    echo $e->getMessage();
}


