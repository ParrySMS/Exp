<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-4-1
 * Time: 23:10
 */

//测试用例
require "Medoo.php";
require "database_info.php";
//todo 把这个做成定时任务
$table = DB_PREFIX."_stuInfo_testlog";
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

//请求地址
//$url = 'http://exp.szer.me/parry/plExp/stuInfoOO/postInfo.php';
$url = 'http://exp.szer.me/parry/plExp/stuInfoFunc/deleteInfo.php';

//一次测试100条
define('INDEX',0*100);

for($i=INDEX;$i<INDEX+100;$i++) {
//模拟测试数据包
    unset($post_data);
//    $post_data['name'] = createName();
//    $post_data['stuno'] = createStuno();
//    $post_data['age'] = createAge();
//    $post_data['sex'] = createSex();
//    $post_data['score'] = createScore();
//    $post_data['grade'] = createGrade($post_data['stuno']);
    $post_data['id']= $i;

    $res = request_post($url, $post_data);
    $res = json_decode($res, true);
//    var_dump($res);
    echo $i.'<br/>';
//东西存进数据库
    if (!empty($res)) {
        $type = "stuInfoFunc/deleteInfo.php";
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
 * 模拟post进行url请求
 * @param string $url
 * @param array $post_data
 */
function request_post($url, $data)
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
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $result = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if ($result === false) {
//        echo 'Curl error: ' . $error;
        return null;
    } else {
        return $result;
    }
}


function createName()
{
    //大写字母
    $name = chr(rand(65, 90));
    //小写字母
    for ($i = 0; $i <= 4; $i++) {
        $name = $name . chr(rand(97, 122));
    }
    return $name;
}

function createStuno()
{
    return rand(1990000000, 2020999999);
}

function createAge()
{
    return rand(18, 99);
}

function createSex()
{
    if (rand(1, 10) > 5) {
        return '男';
    } else {
        return '女';
    }
}

function createScore()
{
    return rand(0, 100);

}

function createGrade($stuno)
{
    return substr($stuno, 0, 4);
}