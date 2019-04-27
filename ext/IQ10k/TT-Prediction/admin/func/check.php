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
    if (!is_string($str)) {
        throw new Exception("invalid paramsplease contanct Administrator", 500);
    }

    $str = trim($str);
    $str = strip_tags($str);
    //使用addslashes函数 添加反斜杠来处理
//    $str = addslashes($str);
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
function allEngS($str)
{
    return (preg_match("/^[a-z\s]+$/", $str));
}

/** 判断是否为邮箱
 * @param $str
 * @return false|int
 */
function isEmail($str)
{
    $pattern = '/^[a-z0-9]+([._-][a-z0-9]+)*@([0-9a-z]+\.[a-z]{2,14}(\.[a-z]{2})?)$/i';
    return preg_match($pattern, $str);
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


/** 用一个demo文件读取的1题重复生成一段测试数据
 * @param $file
 * @param int $num
 * @param bool $print
 * @return array
 */
function getDemoDatas( $num = DATAS_NUM, $print = true)
{

//    $file_steam = fopen($file, "r") or die("Unable to open file:" . $file);
//    $demo_obj = json_decode(fread($file_steam, filesize($file)));
//    fclose($file_steam);
    $demo_obj = json_decode(DEMO_PRO_JSON);
    $datas = [$demo_obj];

    for($i=1;$i<DATAS_NUM;$i++){
        $datas[$i] =  $datas[0];
    }

    if ($print) {
        print_r(json_encode($datas));
    }
    return $datas;
}

/** 返回测试数据
 * @param array & $ids
 * @param $typenaem
 * @param bool $print
 * @return array|bool
 * @throws Exception
 */
function getTestDatas(array & $ids,$typenaem,$print = true){
    $pro = new Problem();

    $pro_source = $pro->getSource($typenaem);
    $datas = $pro->getDatasByIds($ids,$pro_source);
    shuffle($datas);

    if ($print) {
        print_r(json_encode($datas));
    }

    return $datas;

}

/** 从json文件读取先前筛选的指定的测试集id
 * @param $ids_file
 * @return mixed
 */
function getIdsByFile($ids_file)
{
    $file_steam = fopen($ids_file, "r") or die("Unable to open file:" . $ids_file);
    $ids = json_decode(fread($file_steam, filesize($ids_file)), true);
    fclose($file_steam);
    return $ids;
}


/** 检查sign是否有效
 * @param $account
 * @param $sign
 * @throws Exception
 */

function signValidCheck($account, $sign)
{
    $user = new User();

    //检查用户存在 有效
    $username = $user->getName($account);//获取有效用户名 非法会throw

    $sign_real = md5(APPKEY_TU . $account . $username);
    if ($sign !== $sign_real) {
        throw new Exception('sign params invalid', 400);
    }

    //检查有效时间
    if (!$user->hasValidTime($name, $account)) {
        throw new Exception('user not in valid time', 403);
    }
}