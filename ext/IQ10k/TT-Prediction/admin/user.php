<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-4-26
 * Time: 18:50
 */
require '../Http.php';
require '../config/database_info.php';
require '../config/params.php';
require '../config/msg.php';
require '../config/Medoo.php';

require './dao/BaseDao.php';
require './dao/User.php';
require './dao/Action.php';

$res = "无数据输入";

try {
    //记录
    action();

    $app = isset($_GET['appKey']) ? $_GET['appKey'] : null;
    $account = isset($_GET['account']) ? $_GET['account'] : null;
    $name = isset($_GET['name']) ? $_GET['name'] : null;

    // 参数校验
    if (empty($app) || empty($account) || empty($name)) {
        $res = "无数据输入";

    }else {
        $res = "appKey参数错误 或其他输入内容不合法";
        strCheck($app);
        if ($app !== TU_APPKEY) {
            throw new Exception($res, 500);
        }
        strCheck($name);
        strCheck($account);

        //用户检查
        $user = new User();

        if ($user->hasValidUser($name, $account)) {
            $res = "信息已经登记，无需重复登记";

        }elseif ($user->hasInvalidUser($name, $account)) {
            $res = "信息已过期，无法登记";

        }else {
            $uid = $user->insert($name, $account);
            $res = "信息登记成功";
        }
    }

}catch (Exception $e){
    action(null,$e->getCode());
    echo $e->getMessage();
}

/** 行为记录 请求一次记录 报错一次记录
 * @param $uid = null
 * @param null $error_code
 */
function action($uid=null,$error_code = null){
    $http = new Http();
    $ip = $http->getIP();
    $agent = $http->getAgent();
    $uri = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];
    // 实现dao类
    $action = new Action();
    $action->insert($uid, $ip, $agent, $uri,$method, $error_code);
}

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

    if(hasInject($str)){
        throw new Exception("invalid params: $str,please contanct Administrator",500);
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
?>

<!DOCTYPE html>
<html>
<body>
<h2>内测账户白名单登记</h2>
<h2 style="color:#be0000;">当前状态：  <?php echo $res ?></h2><br>

<form action="user.php" method="get">

    appKey:<br>
    <input type="text" name="appKey" value="">
    <br><br>

    codalab账户名:<br>
    <input type="text" name="account" value="">
    <br><br>

    姓名的小写拼音:<br>
    <input type="text" name="name" value="">
    <br><br>

    <input type="submit" value=" 提交登记信息 ">
</form>


</body>
</html>


