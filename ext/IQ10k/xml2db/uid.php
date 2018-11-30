<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-11-30
 * Time: 23:24
 */

$name = isset($_GET['name']) ? $_GET['name'] : null;
$stu = isset($_GET['stu']) ? $_GET['stu'] : null;
$res = "no data";

if (!empty($name) && !empty($stu)) {
    $str = trim($name) . trim($stu);
    $res = md5($str);
}

?>


<!DOCTYPE html>
<html>
<body>
<h2>uid:</h2>
<h2><?php echo $res ?></h2><br>

<form action="./uid.php" method="get">
    姓名的小写拼音:<br>
    <input type="text" name="name" value="">
    <br>
    <br>
    学号:<br>
    <input type="text" name="stu" value="">
    <br><br>
    <input type="submit" value="Create Uid">
</form>


</body>
</html>
