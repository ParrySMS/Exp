<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-3-29
 * Time: 17:35
 */
require "./autoload.php";
use stuApp\common\Safe;

try{
    //执行记录
    unset($logs);
    $logs = array();
    $log = new \stuApp\model\execLog(__FILE__);
    $logs[]=$log;

    //参数获取
    $id = empty($_POST["id"])?null:$_POST["id"];

    //参数检查
    $pmCheck = new \stuApp\common\paramsCheckDI($id);
    $id = $pmCheck->getId();

    //执行操作
    $stuInfo = new \stuApp\dao\StuInfo();
    $stuInfo->setInvisible($id);

    //执行成功
    $json =new \stuApp\model\Json(null,"数据删除成功");
    print_r(json_encode($json));
    //结束
    $log = new \stuApp\model\execLog(__FILE__);
    $logs[]=$log;

}catch (Exception $e){
    httpStatus($e->getCode());
    echo $e->getMessage();
}