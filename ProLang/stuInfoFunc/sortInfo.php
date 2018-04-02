<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-3-29
 * Time: 17:51
 */


//计时
$stime=microtime(true);
require "./safe.php";
require "./http.php";
require "./config/database_info.php";
require "./config/params.php";
require "./Medoo/Medoo.php";
try {


    //游标法记录条数
    $last_id = empty($_GET['last_id'])?0:$_GET['last_id'];//可选参数
    $offset = empty($_GET['offset'])?INFO_OFFSET:$_GET['offset'];//可选参数
    $field = empty($_GET['field']) ? null : $_GET['field'];
    //操作数可能为0
    $sortOption = isset($_GET['sort']) ? $_GET['sort']:null;


    //参数检查
    $last_id = int_check($last_id);
    $offset = int_check($offset);

    if(empty($field)){
        throw new \Exception("field null $field",400);
    }

    if(!isset($sortOption)){
        throw new \Exception("sortOption null $sortOption",400);
    }


    $field = str_check($field);
    //操作数
    $sortOption = int_check($sortOption);
    //0 降序 1升序
    $sortRegion = ["DESC","ASC"];
    //确认参数
    if(empty($sortRegion[$sortOption])){
        throw new \Exception("sortWay error",400);
    }

    $sortWay = $sortRegion[$sortOption];


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
    $sql = " SELECT id, stuno,name,age,sex, score,grade FROM $table WHERE visible = 1  ORDER BY $field $sortWay LIMIT $last_id,$offset";

    $result = mysqli_query($link, $sql);
    // 从数据库中查找记录
    if (!$result) {
        throw new Exception("mysqli_query error: ".mysqli_connect_error(), 500);
    } else {
        unset($infos);
        $infos = [];
        // 逐行取出 数据封装
        while ($row = mysqli_fetch_assoc($result)) {
            $info = (object)$row;
            $infos[] = $info;
        }
    }
    //数据库执行结束
    $db_endtime = microtime(true);
    $dbtime = $db_endtime-$db_starttime;
    //抽成对象属性
    $retdata = (object)["infos" => $infos];
    //输出
    $json = (object)[
        "dbtime"=>1000*$dbtime,
        "exctime"=>1000*(microtime(true)-$stime),
        "retcode" => RETCODE_DEF,
        "retmsg" => null,
        "retdata" => $retdata
    ];

    print_r(json_encode($json));


} catch (Exception $e) {
    httpStatus($e->getCode());
    echo $e->getMessage();
}


