<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-10
 * Time: 17:16
 */


//todo 账号密码检查
function check($acc, $pw)
{
//    $acc_pw_ar = json_decode(ACC_PW_ARRAY,true);

    $user = new User();

    if($user->isEmptyTable()) {
        $user->insertAcc();
    }

    $acc_pw_ar = $user->getAccPwDatas();

    if (!is_array($acc_pw_ar)) {
        throw new Exception('config error: ACC_PW_ARRAY');
    }

    if (!array_key_exists($acc, $acc_pw_ar)) {
        throw new Exception('account error');
    }

    if ($pw != $acc_pw_ar[$acc]) {
        throw new Exception('pw error');
    }

}



function checkDBHas($acc, $pw){

    $user = new User();

    if($user->isEmptyTable()) {
        $user->insertAcc();
    }

    if(!$user->isPw($acc,$pw)){
        throw new Exception('account or pw error');
    }

}