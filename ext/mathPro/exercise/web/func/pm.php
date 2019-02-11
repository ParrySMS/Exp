<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-10
 * Time: 16:48
 */



class UserCheck
{
    protected $account;
    protected $password;

    public function __construct($account,$password)
    {
        $this->account = $account;
        $this->password = $password;

        $this->accPwCheck($account,$password);
    }

    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }


    public function accPwCheck($account,$password){
        $this->nullCheck($account);
        $this->nullCheck($password);
        $this->lenCheck($account, 5, 10);
        $this->lenCheck($password, 6, 12);
        $this->numChar($account);//还没写好
        $this->noSP($account);
        $this->noZH($account);
        $this->noSP($password);
        $this->noZH($password);
    }

    /**
     * @param $string
     * @param int $min_len
     * @param int $max_len
     * @throws Exception
     */
    public function lenCheck($string, int $min_len, int $max_len)
    {
        $len = mb_strlen(trim($string));

        if ($len < $min_len || $len > $max_len) {
            throw new Exception('len error');
        }

//    return ($len>=$min_len && $len<=$max_len);
    }


    /**
     * @param $string
     * @throws Exception
     */
    public function numChar($string)
    {
        //todo 只能是数字或者字母

        //todo 不满足就报错
        if (false) {
            throw new Exception('type error：num or char only');
        }

    }


//todo 没有中文 没有空格
    public function noZH($string)
    {
    }

    public function noSP($string)
    {
    }


    public function nullCheck($string){
        if(empty($string)){
            throw new Exception('null error');
        }
    }

}