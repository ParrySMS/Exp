<?php
require "./func.php";
require "./DB.php";
require "./config/database_info.php";
require "./config/Medoo.php";
use Medoo\Medoo;

$DB = new DB();
$database = $DB->database;
$name = $_GET['name'];
$id = $_GET['id'];

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
    <a href="./3.php" style="color: #eeeeee"> <h1> 返回 </h1></a>
    <h1>实验3-数据库</h1>
</div>

<h1>数据库-表-[ <?php echo $name?> ]</h1>

   <?php showDetail($database,$name); ?>


</body>

</html>
