<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-4-3
 * Time: 8:14
 */


//测试用例
require "Medoo.php";
require "database_info.php";
//todo 把这个做成定时任务
$table = "这里填你的数据库表名";
//$table = DB_PREFIX . "_stuInfo_testlog";
//请求测试的地址
$url = '这里填接口的地址';
//$url = 'http://exp.szer.me/parry/plExp/stuInfoOO/showInfo.php';

$database = new \Medoo\Medoo([
    'database_type' => DATABASE_TYPE,
    'database_name' => DATABASE_NAME,
    'server' => SERVER,
    'username' => USERNAME,
    'password' => PASSWORD,
    'charset' => CHARSET,
    'port' => PORT,
    'check_interval' => CHECK_INTERVAL
]);

//执行次数调整
for($i =0 ;$i<10;$i++) {
    echo "$i<br/>";
 //   $url = 'http://exp.szer.me/parry/plExp/stuInfoFunc/showInfo.php';
//    $res = request_get($url, null);
    $offset = 2000;
    $res = request_get($url, ["offset"=>$offset]);
//var_dump($res);
    $res = json_decode($res, true);


//东西存进数据库
    if (!empty($res)) {
        //这里填希望记录的类型
        $type = "stuInfoOO/showInfo.php/".$offset;
        $pdo = $database->insert($table, [
            "type" => $type,
            "dbtime" => $res['dbtime'],
            "exctime" => $res['exctime'],
            "logtime" => date("Y-m-d H:i:s"),
            "visible" => 1
        ]);
//    $insert = $pdo->rowCount();
//    if (!is_numeric($insert) || $insert != 1) {
////            var_dump($insert);
////        throw new Exception("DB_ERROR:".__CLASS__.'->'. __METHOD__, 500);
//
//    }

    }

}
/**
 * @param $url
 * @param $data
 * @return mixed|null
 */
function request_get($url, $data)
{
    $ch = curl_init();
    /* 设置验证方式 */
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept:text/plain;charset=utf-8',
        'Content-Type:application/x-www-form-urlencoded',
        'charset=utf-8'
    ));
    /* 设置返回结果为流 */
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    /* 设置超时时间*/
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    /* 设置通信方式 */
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    if (!empty($data)) {
        $url = $url . '?' . http_build_query($data);
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if ($result === false) {
        echo 'Curl error: ' . $error;
        return null;
    } else {
        return $result;
    }
}