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

    static $T_USER = DB_PREFIX . '_competition_user';

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
    public function insert($name,$account)
    {
        $pdo = $this->getDatabase()->insert($this->table,[
            'name' => $name,
            'account' => $account,
            'reg_time' => date(DB_TIME_FORMAT),
            'valid_time' => date(DB_TIME_FORMAT,time()+USER_VALID_TIME_INTERVAL),
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
    public function hasValidUser($name,$account)
    {
        $has = $this->getDatabase()->has($this->table,[
            'name' => $name,
            'account' => $account,
            'visible' => VISIBLE_NORMAL,
        ]);

        return $has;

    }

    public function hasInvalidUser($name,$account){
        $has = $this->getDatabase()->has($this->table,[
            'name' => $name,
            'account' => $account,
            'visible[!]' => VISIBLE_NORMAL,
        ]);
    }



}