<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-4-28
 * Time: 21:54
 */

require './Http.php';
require './config/params.php';
require './config/msg.php';

//测试接口

try {
    $http = new Http();

    $url = API_URL_TU;
    $appKey = APPKEY_TU;
    $account = TEST_ACCOUNT;
    $name = TEST_NAME;
    $type = TEST_TYPE;
//    $sign = TEST_SIGN;
    $sign = md5($appKey.$account.$name);

    $params = compact('appKey', 'account', 'type','sign');

    $json = $http->get($url, $params);

    $datas = json_decode($json);

    foreach ($datas as & $d){
        echo $d->id.PHP_EOL;
    }

    echo sizeof($datas);

}catch(Exception $e){
    echo $e->getMessage();

}

