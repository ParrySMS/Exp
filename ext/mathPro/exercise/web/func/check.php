<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-10
 * Time: 17:16
 */


//todo 账号密码检查
function check($acc,$pw){


//    $acc_pw_ar = json_decode(ACC_PW_ARRAY,true);

    $medoo = new Db();
    $database = $medoo->getDatabase();

    $datas = $database->select('user_login',[
        'account',
        'password'
    ],[
        'visible[!]'=>0
    ]);

    if(!is_array($datas)||sizeof($datas) == 0){
        throw new Exception('DB data error');
    }

    $acc_pw_ar = [];
    foreach ($datas as & $d){
        $acc_pw_ar[$d['account']] = $d['password'];
    }

    if(!is_array($acc_pw_ar)){
        throw new Exception('config error: ACC_PW_ARRAY');
    }

    if(!array_key_exists($acc,$acc_pw_ar)){
        throw new Exception('account error');
    }

    if($pw!=$acc_pw_ar[$acc]){
        throw new Exception('pw error');
    }

}