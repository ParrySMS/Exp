<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-11-25
 * Time: 20:13
 */
require "./func.php";
require "./DB.php";
require "./config/database_info.php";
require "./config/Medoo.php";
use Medoo\Medoo;

$DB = new DB();
$database = $DB->database;
$table = $_GET['name'];
//params
$stuno = $_POST['stuno'];
$name = $_POST['name'];
$age = $_POST['age'];
$sex = $_POST['sex'];
$score = $_POST['score'];
$grade = $_POST['grade'];
$time = date('Y-m-d H:i:s');
$visible =1;

$database->query("INSERT INTO $table 
('stuno','name','age','sex','score','grade','time','visible') VALUES
('$stuno','$name',$age,'$sex',$score,$grade,$time,$visible) "
);

jump2UrlInTime("./table.php?name=$table",1);