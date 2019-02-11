<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-11
 * Time: 16:30
 */

class User extends Db
{
    protected $table = 'user_login';

    public function getAccPwDatas(){


        $datas = $this->database->select($this->table,[
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


        return $acc_pw_ar;
    }

    public function deleteUser($uid){
        //todo
    }


}