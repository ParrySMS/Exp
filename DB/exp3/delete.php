<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-11-23
 * Time: 21:00
 */

require "./func.php";
require "./DB.php";
require "./config/database_info.php";
require "./config/Medoo.php";
use Medoo\Medoo;

$DB = new DB();
$database = $DB->database;

$table = $_GET['name'];
$id = $_GET['id'];

$database->query("DELETE FROM $table WHERE id = $id");

jump2UrlInTime("./table.php?name=$table",1);