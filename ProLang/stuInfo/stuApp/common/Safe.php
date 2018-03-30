<?php

// 修改自 http://www.jb51.net/article/30079.htm
namespace stuApp\common;

use \Exception;

class Safe
{
    private $msg;
    private $str;
    private $ar = array();

    /**
     * @return array|int|string
     */
    public function getAr()
    {
        return $this->ar;
    }

    /**
     * @return mixed
     */
    public function getStr()
    {
        return $this->str;
    }


    /**
     * @return mixed
     */
    public function getMsg()
    {
        return $this->msg;
    }

    function __construct($str = array())
    {


        if (empty($str)) {
            //空不操作
        } else {
            if (is_array($str)) {
                $this->ar = $this->sec($str);
            } else {
                // 判断magic_quotes_gpc状态
                if (@get_magic_quotes_gpc()) {
                    $_GET = $this->sec($_GET);
                    $_POST = $this->sec($_POST);
                    $_COOKIE = $this->sec($_COOKIE);
                    $_FILES = $this->sec($_FILES);
                }

                $_SERVER = $this->sec($_SERVER);
                $this->str = $this->strtrim_check($str);
            }
        }

    }

// 字符串过滤函数+去空格
    public function strtrim_check($str)
    {

        $str = trim($str);
        $str = strip_tags($str);
        $str = $this->search_check($this->str_check($str));
        $str = preg_replace("/\r\n/", " ", $str);
        $str = str_replace("<", " ", $str);
        $str = str_replace(">", " ", $str);
        return $str;
    }

// 整型过滤函数
    public function int_check($num)
    {

        if (is_null($num)) {// 判断是否为空
            throw new Exception("illegal numeric exception, null ", 400);
//            return null;
        } elseif ($this->inject_check($num)) {
            //return null;
            throw new Exception("illegal numeric exception, $num ", 400);
        } elseif (!is_numeric($num)) {
            throw new Exception("illegal numeric exception, $num ", 400);
        }
        $num = intval($num);
        return $num;
    }

//数字过滤函数
    public function num_check($num)
    {

        if (is_null($num)) {     // 判断是否为空
            return null;
        } elseif ($this->inject_check($num)) {
            return null;
        } elseif (!is_numeric($num)) {
            throw new Exception("illegal numeric exception, $num", 400);
        }
        return $num;
    }

// 数组过滤函数
    public function sec(&$array)
    {

        //如果是数组，遍历数组，递归调用
        if (is_array($array)) {
            foreach ($array as $k => $v) {
                $array [$k] = $this->sec($v);
            }
        } else if (is_string($array)) {
            //使用addslashes函数来处理
            $array = addslashes($array);
        } else if (is_numeric($array)) {
            $array = intval($array);
        }
        return $array;
    }

    //检查是否为手机号
    public function phone_check($phone)
    {

        if (preg_match("/^1[34578]\d{9}$/", $phone)) {
            return $phone;
        } else {
//            return -1;
            throw new Exception("PARAM_ERROR: invalid phone number,$phone", 400);
        }
    }

    //检查密码 数字字母+长度限制
    public function password_check($pw)
    {

        if (!preg_match('/^[0-9a-zA-Z]{' . PW_MIN . ',' . PW_MAX . '}$/i', $pw)) {
            throw new Exception("PARAM_ERROR: password not allowed", 400);
        }
        return $pw;
    }

// 字符过滤函数
    public function str_check($str)
    {

        if ($this->inject_check($str)) {
            throw new Exception("illegal argument exception, $str", 400);
            // die ('Illegal Argument Exception');
        }
        //注入判断
        $str = htmlspecialchars($str);
        //转换html
        return $str;
    }

// 替换字符的过滤函数
    public function search_check($str)
    {

        //$str = str_replace("_", "\_", $str);
        //把"_"过滤掉
        $str = str_replace("%", "\%", $str);
        //把"%"过滤掉
        $str = htmlspecialchars($str);
        //转换html
        return $str;
    }

// 长度检查
    public function len_check($str, $min, $max)
    {

        if (isset ($min) && mb_strlen($str) < $min) {
            throw new Exception("STRLEN_ERROR: min $min byte, $str", 400);
            //die ("min: $min byte");
        } else if (isset ($max) && mb_strlen($str) > $max) {
            throw new Exception("STRLEN_ERROR: max $max byte, $str", 400);
            //die ("max: $max byte");
        }
        return $this->stripslashes_array($str);
    }

// 防注入函数
    public function inject_check($sql_str)
    {
//        return preg_match('/select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|UNION|into|load_file|outfile/', $sql_str);
        return preg_match('/select|insert|update|delete|\'|\/\*|\.\.\/|\.\/|UNION|into|load_file|outfile/', $sql_str);
        // 进行过滤，防注入
    }

    /** 删除反斜杠
     * @param $array
     * @return array|string
     */
    public function stripslashes_array(&$array)
    {
        if (is_array($array)) {
            foreach ($array as $k => $v) {
                $array [$k] = $this->stripslashes_array($v);
            }
        } else if (is_string($array)) {
            $array = stripslashes($array);
        }
        return $array;
    }


}

?>