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

require './func/check.php';

$res = "无数据输入";

try {
    //记录
    action();

    $app = isset($_GET['appKey']) ? $_GET['appKey'] : null;
    $account = isset($_GET['account']) ? $_GET['account'] : null;
    $name = isset($_GET['name']) ? $_GET['name'] : null;

    // 参数校验
    if (empty($app) || empty($account) || empty($name)) {
        $res = "有数据输入为空，请检查输入";

    } else {

        $res = "输入内容不合法";
        strCheck($app);
        if ($app !== TU_APPKEY) {
            throw new Exception('appKey参数错误', 500);
        }
        strCheck($account);
        strCheck($name);
        // 检查用户邮箱
        if(!isEmail($account)){
            throw new Exception('账户邮箱格式错误', 500);
        }

        //名字全小写拼音
        if(!allEngS($name)){
            throw new Exception('姓名拼音需要全小写', 500);
        }


        //用户检查
        $user = new User();

        if ($user->hasValidUser($name, $account)) {
            $res = "信息已经登记，无需重复登记";

        } elseif ($user->hasInvalidUser($name, $account)) {
            $res = "信息已过期，无法登记";

        } else {
            $uid = $user->insert($name, $account);
            $res = "信息登记成功";
        }
    }

} catch (Exception $e) {
    action(null, $e->getCode());
    echo '<h2 style="color:#be0000;">';
    echo '错误提示：'.$e->getMessage();
    echo  '</h2>';
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


?>

<!DOCTYPE html>
<html>
<body>
<h2 style="color:#be0000;">当前状态：<?php echo $res ?></h2><br>
<h2>内测账户白名单登记</h2>
<form action="user.php" method="get">

    appKey:<br>
    <input type="text" name="appKey" value= "<?php echo $app ?>" >
    <br><br>

    codalab账户邮箱:<br>
    <input type="text" name="account" value="<?php echo $account ?>">
    <br><br>

    姓名的小写拼音:<br>
    <input type="text" name="name" value="<?php echo $name ?>">
    <br><br>

    <input type="submit" value=" 提交登记信息 ">
</form>


</body>
</html>


