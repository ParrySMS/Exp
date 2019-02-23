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

    public function getAccPwDatas()
    {


        $datas = $this->database->select($this->table, [
            'account',
            'password'
        ], [
            'visible[!]' => 0
        ]);

        if (!is_array($datas) || sizeof($datas) == 0) {
            throw new Exception('DB data error');
        }

        $acc_pw_ar = [];
        foreach ($datas as & $d) {
            $key = $d['account'];
            $value = $d['password'];
            $acc_pw_ar[$key] = $value;

//            $acc_pw_ar[$d['account']] = $d['password'];
        }


        return $acc_pw_ar;
    }

    public function deleteUser($uid)
    {
        //todo
    }

    public function insertAcc()
    {
        $acc_pw = json_decode(ACC_PW_ARRAY);

        foreach ($acc_pw as $account => $pw) {

            $this->getDatabase()->insert($this->table, [
                'account' => $account,
                'password' => $pw,
                'visible' => USER_VALID
            ]);

            $id = $this->getDatabase()->id();

            if (empty($id) || !is_numeric($id) || $id <= 0) {
                throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():insert id error');
            }

        }

    }

    public function isEmptyTable(): bool
    {
        $has = $this->getDatabase()->has($this->table, [
            'visible' => 1
        ]);

        return !$has;

    }

    public function isPw($acc, $pw): bool
    {
        $has = $this->getDatabase()->has($this->table, [
            'account' => $acc,
            'password' => $pw,
            'visible' => USER_VALID
        ]);

        return $has;
    }

    /** 返回uid 如果没有就报错
     * @param $acc
     * @param $pw
     * @return int
     * @throws Exception
     */
    public function getUid($acc, $pw):int
    {
        $uid = $this->getDatabase()->get($this->table,'uid',[
            'account'=>$acc,
            'password'=>$pw,
            'visible[!]'=>USER_INVALID
        ]);

        if(!is_numeric($uid) || $uid<=0){
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():uid error');
        }

        return $uid;
    }


}