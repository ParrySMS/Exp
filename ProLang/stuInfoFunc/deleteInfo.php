<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-3-29
 * Time: 17:35
 */
//计时
$stime=microtime(true);
require "./safe.php";
require "./http.php";
require "./config/database_info.php";
require "./config/params.php";
require "./Medoo/Medoo.php";
try{
    //参数获取
    $id = empty($_POST["id"])?null:$_POST["id"];

    //参数检查
    $id = int_check($id);

    //执行操作

    //记录数据库执行
    $db_starttime = microtime(true);
    //配置数据库
    $link = mysqli_init();
    if (!$link) {
        throw new Exception("mysqli_init failed", 500);
    }

    $connect = mysqli_real_connect(
        $link,
        SERVER,
        USERNAME,
        PASSWORD,
        DATABASE_NAME,
        PORT
    );
    $table = DB_PREFIX . '_stuinfo';
    //数据库执行

    //小心sql里面VALUES需要''单引号的问题
    $sql = "UPDATE $table SET visible = '0' WHERE id = $id ";
    //数据插入

    $result = mysqli_query($link, $sql);
    // 从数据库中查找记录
    if (!$result) {
        throw new Exception("mysqli_query error: " . mysqli_connect_error(), 500);
    }

    //数据执行结束
    $db_endtime = microtime(true);
    $dbtime = $db_endtime - $db_starttime;
    //插入成功
    $json = (object)[
        "dbtime" => 1000 * $dbtime,
        "exctime" => 1000 * (microtime(true) - $stime),
        "retcode" => RETCODE_DEF,
        "retmsg" => "数据删除成功",
        "retdata" => null
    ];
    print_r(json_encode($json));

}catch (Exception $e){
    httpStatus($e->getCode());
    echo $e->getMessage();
}