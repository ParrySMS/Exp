<?php

namespace tlApp\common;


use \Exception;


class ThinkCrypt implements Crypt
{
    /**
     * 系统加密方法
     * @param string $data 要加密的字符串
     * @param string $key 加密密钥
     * @param int $expire 过期时间 单位 秒
     * @return string
     */
    public function thinkEncrypt($data, $key = '', $expire = 0, $withNonstr = 1)
    {
        if ($withNonstr == 1) {
            $data = $data . "+" . NONSTR;
        }
        $key = md5(empty($key) ? ST_AUTH_KEY : $key);
        $data = base64_encode($data);
        $x = 0;
        $len = strlen($data);
        $l = strlen($key);
        $char = '';

        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) $x = 0;
            $char .= substr($key, $x, 1);
            $x++;
        }

        $str = sprintf('%010d', $expire ? $expire + time() : 0);

        for ($i = 0; $i < $len; $i++) {
            $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1))) % 256);
        }
        return str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode($str));
    }


    /** 系统解密方法
     * @param $data
     * @param string $key
     * @return bool|string
     */
    public function thinkDecrypt($data, $key = '')
    {

        $key = md5(ST_AUTH_KEY);
        $data = str_replace(array('-', '_'), array('+', '/'), $data);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        $data = base64_decode($data);
        $expire = substr($data, 0, 10);
        $data = substr($data, 10);

        if ($expire > 0 && $expire < time()) {
            return '';
        }
        $x = 0;
        $len = strlen($data);
        $l = strlen($key);
        $char = $str = '';

        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) $x = 0;
            $char .= substr($key, $x, 1);
            $x++;
        }

        for ($i = 0; $i < $len; $i++) {
            if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
                $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
            } else {
                $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
            }
        }
        return base64_decode($str);
    }

    /** 解密拆分token并返回信息包数组
     * @param $token
     * @return array|null
     * 加密内容如下
     *   $str = $user_id . "+" . md5($openid) . "+" . $ip . "+" . date("M-d H:i:s") ;
     *  $str = $str.(补充的NONSTR)
     */
    public function tokenDecrypt($token)
        //todo:下面要修改具体的解密
    {
        if ($token == null) {
            throw new Exception("TOKEN_ERROR: invalid token1", 403);
        } else {
            $str = $this->thinkDecrypt($token);
            $user_id = strtok($str, "+");
            $md5Account = strtok("+");
            $ip = strtok("+");
            $date = strtok("+");
            $nonstr = strtok("+");
            if ($nonstr != NONSTR || empty($nonstr)) {
                throw new Exception("TOKEN_ERROR: invalid token2", 403);
            } else {
                unset($tokenAr);
                $tokenAr = compact('user_id', 'md5Account', 'ip', 'date', 'nonstr');
                if (!is_array($tokenAr)) {
                    throw new Exception("COMMON_ERROR: tokenDecrypt", 500);
                }
                return $tokenAr;
            }
        }
    }


}