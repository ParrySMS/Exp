<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-3-20
 * Time: 11:02
 */
require "./autoload.php";
use stuApp\common\Safe;

try{
    //执行记录
    unset($logs);
    $logs = array();
    $log = new \stuApp\model\execLog(__FILE__);
    $logs[]=$log;

    $stuno = empty($_POST['stuno'])?null:$_POST['stuno'];
    $name = empty($_POST['name'])?null:$_POST['name'];
    $age = empty($_POST['age'])?null:$_POST['age'];
    $sex = empty($_POST['sex'])?null:$_POST['sex'];
    $score = empty($_POST['score'])?null:$_POST['score'];
    $grade = empty($_POST['grade'])?null:$_POST['grade'];

    //合并成关联数组
    $info = compact('stuno','name','age','sex','score','grade');
    //参数检查
    $pmCheck = new \stuApp\common\paramsCheckPI($info);
    //

    //数据插入
    $stuInfo = new \stuApp\dao\StuInfo();
    $stuInfo->insert($info['stuno'],$info['name'],$info['age'],$info['sex'],$info['score'],$info['grade']);

    //插入成功
    $json =new \stuApp\model\Json(null,"数据插入成功");
    print_r(json_encode($json));
    //结束
    $log = new \stuApp\model\execLog(__FILE__);
    $logs[]=$log;

    //var_dump($logs);

}catch (Exception $e){
    httpStatus($e->getCode());
    echo $e->getMessage();
}
