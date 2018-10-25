<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-6-29
 * Time: 16:45
 */
require './config/database_info.php';
require './config/Medoo.php';

use Medoo\Medoo;

define('BASE_SIZE', 11);

try {

    //数据库配置初始化
    $database = new Medoo([
        'database_type' => DATABASE_TYPE,
        'database_name' => DATABASE_NAME,
        'server' => SERVER,
        'username' => USERNAME,
        'password' => PASSWORD,
        'port' => PORT,
        'charset' => CHARSET
    ]);

    //数据库表
//    $table_p = DB_PREFIX . '_problem';
    $table_p = DB_PREFIX . '_problem_adddigramspecial';
//    $table_h = DB_PREFIX . '_hint';
    $table_h = DB_PREFIX . '_hint_adddigramspecial';

} catch (Exception $e) {
    echo '错误信息<br/>' . $e->getMessage();
}

//子函数
function getTr($database, $table)
{
    unset($data);


    $data = $database->select($table, [
        'id',
        'title',
        'answers',
        'language',
        'classification',
        'pro_type',
        'pro_source'
    ], [
//        'visible' => 1,
		'AND'=>[
			'visible[!]'=>0
		],
		"ORDER" => ["id" => "DESC"]
    ]);
    //var_dump($data);
    return $data;
}

function echoTr()
{
    echo '<tr>';
    echo '<th>id</th>';
    echo '<th>title</th>';
    echo '<th>pro_type <br/>（exclusive单个<br/> 
            multiple多个<br/>
            fill填空<br/>
            choice选择）
            </th>';
    echo '<th>answers</th>';
    echo '<th>language <br/> (中文zh <br/>
            英文en<br/> 
            混合multi<br/>
            数字all)
            </th>';
    echo '<th>类目</th>';
    echo '<th>来源文件</th>';
    echo '</tr>';
}

function echoTd($datas)
{
    foreach ($datas as $data) {
        echo '<tr>';
        echo '<td>' . $data['id'] . '</td>';
        echo '<td>' . $data['title'] . '</td>';
        echo '<td>' . $data['pro_type'] . '</td>';
        echo '<td>' . $data['answers'] . '</td>';
        echo '<td>' . $data['language'] . '</td>';
        echo '<td>' . $data['classification'] . '</td>';
        echo '<td>' . $data['pro_source'] . '</td>';
        echo '</tr>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>当前题库题目</title>
</head>
<body>

<h2>当前题库题目</h2>
<h2>已隐藏题目提示 序号排列为倒序</h2>

<?php

$data = getTr($database, $table_p);
echo '<table border="1">';
echoTr();
echoTd($data);
echo '</table>';

?>

</body>
</html>