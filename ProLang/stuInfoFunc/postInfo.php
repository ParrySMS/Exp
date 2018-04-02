<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-3-20
 * Time: 11:02
 */
//计时
$stime = microtime(true);
require "./safe.php";
require "./http.php";
require "./config/database_info.php";
require "./config/params.php";
require "./Medoo/Medoo.php";
try {

    $stuno = empty($_POST['stuno']) ? null : $_POST['stuno'];
    $name = empty($_POST['name']) ? null : $_POST['name'];
    $age = empty($_POST['age']) ? null : $_POST['age'];
    $sex = empty($_POST['sex']) ? null : $_POST['sex'];
    $score = empty($_POST['score']) ? null : $_POST['score'];
    $grade = empty($_POST['grade']) ? null : $_POST['grade'];

    //合并成关联数组
    $info = compact('stuno', 'name', 'age', 'sex', 'score', 'grade');
    //参数检查
    //空检查
    if (in_array('', $info) || in_array(null, $info)) {
        throw new \Exception("param null in stuInfoArray", 400);
    }

    //参数安全检查 过滤
    foreach ($info as $key => $value) {
        if (empty($value)) {
            throw new \Exception("$key null in stuInfoArray", 400);

        }
        $info[$key] = str_check($value);
    }

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
    $sql = "INSERT INTO $table (stuno, name, age, sex, score, grade, time, visible ) 
        VALUES ( '$stuno' , '$name' , '$age' , '$sex' , '$score', '$grade', ' " . date('Y-m-d H:i:s') . "' ,'1')";
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
            "retmsg" => "数据插入成功",
            "retdata" => null
        ];
        print_r(json_encode($json));

} catch (Exception $e) {
    httpStatus($e->getCode());
    echo $e->getMessage();
}
