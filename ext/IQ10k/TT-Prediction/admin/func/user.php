<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-4-26
 * Time: 18:50
 */


$app = isset($_GET['appKey']) ? $_GET['appKey'] : null;
$account = isset($_GET['account']) ? $_GET['account'] : null;
$name = isset($_GET['name']) ? $_GET['name'] : null;
$res = "无数据输入";

//todo 参数校验 , new User(), user->insert()
if (!empty($app) && !empty($account) && !empty($name)) {
    $str = trim($app) . trim($account).trim($name);
    $res = md5($str);
}


?>

<!DOCTYPE html>
<html>
<body>
<h2>内测账户白名单登记</h2>
<h2>当前状态： <?php echo $res ?></h2><br>

<form action="./user.php" method="get">

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
