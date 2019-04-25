<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-4-26
 * Time: 3:10
 */

$app = isset($_GET['appKey']) ? $_GET['appKey'] : null;
$account = isset($_GET['account']) ? $_GET['account'] : null;
$name = isset($_GET['name']) ? $_GET['name'] : null;
$res = "no data input";

if (!empty($app) && !empty($account) && !empty($name)) {
    $str = trim($app) . trim($account).trim($name);
    $res = md5($str);
}

?>

<!DOCTYPE html>
<html>
<body>
<h2>sign:</h2>
<h2><?php echo $res ?></h2><br>

<form action="./sign.php" method="get">

    appKey:<br>
    <input type="text" name="appKey" value="">
    <br><br>

    codalab账户名:<br>
    <input type="text" name="account" value="">
    <br><br>

    姓名的小写拼音:<br>
    <input type="text" name="name" value="">
    <br><br>

    <input type="submit" value=" -----   Create sign   ----- ">
</form>


</body>
</html>
