<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-4-27
 * Time: 19:08
 */

/** 字符串过滤
 * @param $str
 * @throws Exception
 */
function strCheck(& $str)
{
    $str = trim($str);
    $str = strip_tags($str);
    //使用addslashes函数 添加反斜杠来处理
    $str = addslashes($str);
    $str = preg_replace("/\r\n/", " ", $str);
    //过滤成全角
//    $str = str_replace("<", '〈', $str);
//    $str = str_replace(">", '〉', $str);
//    $str = str_replace("_", "＿", $str);
//    $str = str_replace("%", '％', $str);
    //html标签处理
    $str = htmlspecialchars($str);

    if (hasInject($str)) {
        throw new Exception("invalid params: $str,please contanct Administrator", 500);
    }
//        var_dump($str);
//    return $str;
}

/** 是否有可疑注入字符
 * @param $sql_str
 * @return bool
 */
function hasInject($sql_str)
{
    $num = preg_match('/select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|UNION|into|load_file|outfile/', $sql_str);
    return ($num == 0) ? false : true;
}

/** 全英文小写
 * @param $str
 * @return false|int
 */
function allEngS($str){
    return (preg_match("/^[a-z\s]+$/",$str));
}
