<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2018-6-18
 * Time: 1:20
 */

namespace tlApp\common;

use Exception;


class PmCheck
{


    public function __construct()
    {
        // 判断magic_quotes_gpc状态
            $_GET = $this->array_check($_GET);
            $_POST = $this->array_check($_POST);
//            $_COOKIE = $this->array_check($_COOKIE);
//            $_FILES = $this->array_check($_FILES);
    }




    /** 字符串过滤函数
     * @param $str
     * @return mixed|string
     */
    private function str_check($str)
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
    private function num_check($num, $intval = false)
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
    private function array_check(&$array)
    {
        //如果是数组，遍历数组，递归调用
        if (is_array($array)) {
            foreach ($array as $k => $v) {
                $array [$k] = $this->array_check($v);
            }
        } else if (is_string($array)) {
            $array = $this->str_check($array);
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
   private function hasInject($sql_str)
    {
        $num = preg_match('/select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|UNION|into|load_file|outfile/', $sql_str);
        return ($num == 0) ? false : true;
    }

    /**删除反斜杠
     * @param $array
     * @return array|string
     */
   private function stripslashes_array(&$array)
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


}