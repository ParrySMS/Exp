<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-11-30
 * Time: 21:28
 */

require './Http.php';
require './config/database_info.php';
require './config/params.php';
require './config/Medoo.php';
require './Seq.php';


$key = isset($_GET['secret_key']) ? $_GET['secret_key'] : null;
$uid = isset($_GET['secret_key']) ? $_GET['secret_key'] : null;

$http = new Http();

try {

    if (empty($key)) {
        throw new Exception("secret_key null", 400);
    }

    if ($key !== SECRET_KEY) {
        throw new Exception("secret_key error", 400);
    }

    if (empty($uid)) {
        throw new Exception("uid null", 400);
    }

    $uid_list = json_decode(SEQ200_UID_LIST);
    if(!in_array($uid,$uid_list)){
        throw new Exception("uid error", 400);
    }

    $seq = new Seq();
    $seq->insertAction($uid,$http->getIP(),$http->getAgent(),null);
    $ids = $seq->getVaildId();
    shuffle($ids);

    $part_ids = array_slice($ids,0,200);

    $datas = $seq->getDatasInSet($part_ids);
    shuffle($datas);

    echo json_encode($datas);


} catch (Exception $e) {
    $seq->insertAction($uid,$http->getIP(),$http->getAgent(),$e->getCode());
    echo $e->getMessage();
    $http->status($e->getCode());
}