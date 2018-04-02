<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-3-20
 * Time: 11:02
 */
//计时
$stime=microtime(true);
require "./autoload.php";
use stuApp\common\Safe;

try{

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
     //拆分数组
    extract($info,EXTR_OVERWRITE);

    //记录数据库执行
    $db_starttime = microtime(true);
    //数据插入
    $stuInfo = new \stuApp\dao\StuInfo();
    $stuInfo->insert($stuno,$name,$age,$sex,$score,$grade);
    //数据库执行结束
    $db_endtime = microtime(true);
    $dbtime = $db_endtime-$db_starttime;
    //插入成功
    $json =new \stuApp\model\Json($stime,$dbtime,null,"数据插入成功");
    print_r(json_encode($json));


}catch (Exception $e){
    httpStatus($e->getCode());
    echo $e->getMessage();
}
