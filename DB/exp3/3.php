<?php
require "./func.php";
require "./DB.php";
require "./config/database_info.php";
require "./config/Medoo.php";
use Medoo\Medoo;

$DB = new DB();
$database = $DB->database;

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./style.css"/>
</head>

<script type="text/javascript" src="./define.js"></script>

<body>


<!--大标题-->
<div id="header">
    <h1>实验3-数据库</h1>
</div>

<!--十个菜单-->
<div id="nav">
    <br>
    <a href="./1.php">1 显示日期 </a> <br>
    <a href="./2.php">2 最长匹配字符</a><br>
    <a href="./3.php">3 数据库管理页面 </a><br>
</div>

<!--菜单内容-->

<div id="section">

    <h2>3 数据库内的表：</h2><br>
    <?php showTable($database); ?>
</div>


</body>

</html>
