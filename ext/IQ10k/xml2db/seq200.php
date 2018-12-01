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


$uid = isset($_GET['uid']) ? $_GET['uid'] : null;

$http = new Http();
$seq = new Seq();

try {


    if (empty($uid)) {
        throw new Exception("uid null", 400);
    }

    $uid_list = json_decode(SEQ200_UID_LIST);
    if(!in_array($uid,$uid_list)){
        throw new Exception("uid error", 400);
    }

    //每个uid 只能调用5次 testuid 除外
    if($seq->isLimited($uid)){
        throw new Exception("Access has been restricted",403);
    }
    
    $seq->insertAction($uid,$http->getIP(),$http->getAgent(),null);

    if($uid == SEQ200_TESTUID){//调试
        //某道训练集题目
        $datas = $seq->getDatasInSet([10407],'new-train-seq');

        for($i=1;$i<200;$i++){
            $datas[$i] =  $datas[0];
        }

        echo json_encode($datas);

    }else {//正式申请考试
        $ids = $seq->getVaildId();
        shuffle($ids);

        $part_ids = array_slice($ids, 0, 200);

        $datas = $seq->getDatasInSet($part_ids);
        shuffle($datas);

        echo json_encode($datas);
    }

} catch (Exception $e) {
    $seq->insertAction($uid,$http->getIP(),$http->getAgent(),$e->getCode());
    echo $e->getMessage();
    $http->status($e->getCode());
}