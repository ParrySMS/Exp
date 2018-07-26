<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2018-6-18
 * Time: 1:20
 */



class PmCheck
{


    public function __construct($is_encode = false)
    {
        if($is_encode == false) {
            //默认检查
            $_GET = $this->arrayCheck($_GET);
            $_POST = $this->arrayCheck($_POST);
        }else {
            //部分前端加密数据
            $get_body = $this->pmDecode($_GET);
            $post_body = $this->pmDecode($_POST);
            $_GET = $this->arrayCheck($get_body);
            $_POST = $this->arrayCheck($post_body);
        }
//            $_COOKIE = $this->array_check($_COOKIE);
//            $_FILES = $this->array_check($_FILES);
    }




    /** 字符串过滤函数
     * @param $str
     * @return mixed|string
     */
    protected function strCheck($str)
    {
        $str = trim($str);
        $str = strip_tags($str);
        //使用addslashes函数 添加反斜杠来处理
        $str = addslashes($str);
        $str = preg_replace("/\r\n/", " ", $str);
        //过滤成全角
        $str = str_replace("<", '〈', $str);
        $str = str_replace(">", '〉', $str);
        $str = str_replace("_", "＿", $str);
        $str = str_replace("%", '％', $str);
        //html标签处理
        $str = htmlspecialchars($str);
//        var_dump($str);
        return $str;
    }


    /** 数字检查函数
     * @param $num
     * @param bool $intval 是否转为int
     * @return int|null
     */
    protected function numCheck($num, $intval = false)
    {
        if (!is_numeric($num)) {
            return null;
        }

        if ($intval == true) {
            $num = intval($num);
        }
        return $num;
    }

// 数组遍历过滤函数
    protected function arrayCheck(&$array)
    {
        //如果是数组，遍历数组，递归调用
        if (is_array($array)) {
            foreach ($array as $k => $v) {
                $array [$k] = $this->arrayCheck($v);
            }
        } else if (is_string($array)) {
            $array = $this->strCheck($array);
        } else if (is_numeric($array)) {
            //不适用强制转换
//            $array = intval($array);
        }
        return $array;
    }


    /** 是否含有可疑字符
     * @param $sql_str
     * @return bool
     */
   protected function hasInject($sql_str)
    {
        $num = preg_match('/select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|UNION|into|load_file|outfile/', $sql_str);
        return ($num == 0) ? false : true;
    }

    /**删除反斜杠
     * @param $array
     * @return array|string
     */
   protected function stripslashesArray(&$array)
    {
        if (is_array($array)) {
            foreach ($array as $k => $v) {
                $array [$k] = stripslashes_array($v);
            }
        } else if (is_string($array)) {
            $array = stripslashes($array);
        }
        return $array;
    }

    /** 前端传输的弱解密
     * @param $params
     * @return array|bool|string
     */
    public function pmDecode($params){
        if(is_array($params)){
            foreach ($params as $key => $p){
                $params[$key] = base64_decode(base64_decode($p));
            }
        }else{
            $params = base64_decode(base64_decode($params));
        }
        return $params;
    }



}