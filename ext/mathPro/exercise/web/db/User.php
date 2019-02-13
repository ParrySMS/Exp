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
            $acc_pw_ar[$d['account']] = $d['password'];
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
                'visible' => VALID_USER
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
            'visible' => VALID_USER
        ]);

        return $has;
    }


}