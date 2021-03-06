<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-3-29
 * Time: 17:51
 */
//计时
$stime=microtime(true);
require "./autoload.php";

use stuApp\common\Safe;

try {

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

    //记录数据库执行
    $db_starttime = microtime(true);
    //数据库执行
    $stuInfo = new \stuApp\dao\StuInfo();
    //执行排序取出数据
    $datas = $stuInfo->sortInfo($field,$sortWay,$last_id,$offset);

    unset($infos);
    $infos = [];
    //数据封装
    foreach ($datas as $dataOptionArray){
        $info = new \stuApp\model\Info($dataOptionArray);
        $infos[] = $info;
    }

    //数据库执行结束
    $db_endtime = microtime(true);
    $dbtime = $db_endtime-$db_starttime;

    //抽成对象属性
    $retdata = (object)["infos"=>$infos];
    //输出
    $json = new \stuApp\model\Json($stime,$dbtime,$retdata);
    print_r(json_encode($json));


} catch (Exception $e) {
    httpStatus($e->getCode());
    echo $e->getMessage();
}


