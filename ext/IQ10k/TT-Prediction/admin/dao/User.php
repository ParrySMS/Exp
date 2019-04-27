<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-4-26
 * Time: 18:54
 */

class User extends BaseDao
{
    protected $table;


    public function __construct()
    {
        parent::__construct();

        $this->table = $this::$T_USER;
    }

    /**
     * @param $name
     * @param $account
     * @return int|mixed|string
     * @throws Exception
     */
    public function insert($name, $account)
    {
        $pdo = $this->getDatabase()->insert($this->table, [
            'name' => $name,
            'account' => $account,
            'reg_time' => date(DB_TIME_FORMAT),
            'valid_time' => date(DB_TIME_FORMAT, time() + USER_VALID_TIME_INTERVAL),
            'visible' => VISIBLE_NORMAL
        ]);
        //插入成功后通过id检查是否异常
        $id = $this->database->id();
        if (!is_numeric($id) || $id < 1) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():  insert id error', 500);
        }
        return $id;

    }

    /** 判断是否存在该用户
     * @param $name
     * @param $account
     * @return bool
     */
    public function hasValidUser($name, $account)
    {
        $has = $this->getDatabase()->has($this->table, [
            'name' => $name,
            'account' => $account,
            'visible' => VISIBLE_NORMAL,
        ]);

        return $has;

    }

    public function hasInvalidUser($name, $account)
    {
        $has = $this->getDatabase()->has($this->table, [
            'name' => $name,
            'account' => $account,
            'visible[!]' => VISIBLE_NORMAL,
        ]);
        return $has;
    }

    /** 获取用户名 内含黑名单用户检查
     * @param $account
     * @return array|bool|mixed
     * @throws Exception
     */
    public function getName($account)
    {
        $name = $this->getDatabase()->get($this->table,
            'name',
            [
                'account' => $account,
                'visible' => VISIBLE_NORMAL,
            ]);

        if (!is_string($name)||empty($name)) {

            if ($this->hasInvalidUser($name, $account)) {
                throw new Exception(MSG_BLACK_USER . "account:$account", 403);
            }

            throw new Exception('DB ' . __FUNCTION__ . '() ERROR', 500);
        }

        return $name;
    }

    /** 检查用户是否过期
     * @param $name
     * @param $account
     * @return bool
     */
    public function hasValidTime($name, $account)
    {
        $has = $this->getDatabase()->has($this->table,
            [
                'name' => $name,
                'account' => $account,
                'visible' => VISIBLE_NORMAL,
                'valid_time[><]'=>[ // NOT BETWEEN
                    date(DB_TIME_FORMAT,time()-USER_VALID_TIME_INTERVAL),
                    date(DB_TIME_FORMAT)
                ]
            ]);

        return $has;
    }


}