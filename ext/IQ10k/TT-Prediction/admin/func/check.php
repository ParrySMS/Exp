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
    if(!is_string($str)){
        throw new Exception("invalid paramsplease contanct Administrator", 500);
    }

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

/** 判断是否为邮箱
 * @param $str
 * @return false|int
 */
function isEmail($str){
    $pattern = '/^[a-z0-9]+([._-][a-z0-9]+)*@([0-9a-z]+\.[a-z]{2,14}(\.[a-z]{2})?)$/i';
    return preg_match($pattern,$str);
}


/** 行为记录 请求一次记录 报错一次记录
 * @param $uid = null
 * @param null $error_code
 */
function action($uid = null, $error_code = null)
{
    $http = new Http();
    $ip = $http->getIP();
    $agent = $http->getAgent();
    $uri = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];
    // 实现dao类
    $action = new Action();
    $action->insert($uid, $ip, $agent, $uri, $method, $error_code);
}
