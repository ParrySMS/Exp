<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-3-29
 * Time: 17:35
 */
//计时
$stime=microtime(true);
require "./autoload.php";
use stuApp\common\Safe;

try{

    //参数获取
    $id = empty($_POST["id"])?null:$_POST["id"];

    //参数检查
    $pmCheck = new \stuApp\common\paramsCheckDI($id);
    $id = $pmCheck->getId();

    //记录数据库执行
    $db_starttime = microtime(true);
    //执行操作
    $stuInfo = new \stuApp\dao\StuInfo();
    $stuInfo->setInvisible($id);
    //数据库执行结束
    $db_endtime = microtime(true);
    $dbtime = $db_endtime-$db_starttime;
    //执行成功
    $json =new \stuApp\model\Json($stime,$dbtime,null,"数据删除成功");
    print_r(json_encode($json));

}catch (Exception $e){
    httpStatus($e->getCode());
    echo $e->getMessage();
}