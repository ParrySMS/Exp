<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-6-29
 * Time: 16:45
 */
require './config/db.php';
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
    $table_list = [
        PREFIX . 'logic_c',
        PREFIX . 'logic_e',
        PREFIX . 'seq',
        PREFIX . 'verbal_c',
        PREFIX . 'verbal_ce',
        PREFIX . 'verbal_e'
    ];


} catch (Exception $e) {
    echo '错误信息<br/>' . $e->getMessage();
}

//子函数
function getTr($database, $table)
{
    unset($data);


    $data = $database->select($table, '*', [
        'visible' => 0
    ]);
    //var_dump($data);
    return $data;
}

function EchoTr($size)
{
    echo '<tr>';
    echo '<th>来源表</th>';
    echo '<th>id</th>';
    echo '<th>PostProblem</th>';
    echo '<th>Classification</th>';
    echo '<th>A</th>';
    echo '<th>B</th>';
    echo '<th>C</th>';
    echo '<th>D</th>';
    if ($size >= BASE_SIZE + 1) {
        echo '<th>E</th>';
    }
    if ($size >= BASE_SIZE + 2) {
        echo '<th>F</th>';
    }
    if ($size >= BASE_SIZE + 3) {
        echo '<th>G</th>';
    }
    if ($size >= BASE_SIZE + 4) {
        echo '<th>H</th>';
    }
    if ($size >= BASE_SIZE + 5) {
        echo '<th>I</th>';
    }
    if ($size >= BASE_SIZE + 6) {
        echo '<th>J</th>';
    }
    if ($size >= BASE_SIZE + 7) {
        echo '<th>K</th>';
    }
    if ($size >= BASE_SIZE + 8) {
        echo '<th>L</th>';
    }
    if ($size >= BASE_SIZE + 9) {
        echo '<th>M</th>';
    }
    if ($size >= BASE_SIZE + 10) {
        echo '<th>N</th>';
    }
    echo '<th>Answer</th>';
    echo '<th>Hint</th>';
    echo '</tr>';
}

function EchoTd($table, $datas, $size)
{
    foreach ($datas as $data) {
        echo '<tr>';
        echo "<td>$table</td>";
        echo '<td>' . $data['id'] . '</td>';
        echo '<td>' . $data['PostProblem'] . '</td>';
        echo '<td>' . $data['Classification'] . '</td>';
        echo '<td>' . $data['A'] . '</td>';
        echo '<td>' . $data['B'] . '</td>';
        echo '<td>' . $data['C'] . '</td>';
        echo '<td>' . $data['D'] . '</td>';
        if ($size >= BASE_SIZE + 1) {
            echo '<td>' . (isset($data['E']) ? $data['E'] : null) . '</td>';
        }
        if ($size >= BASE_SIZE + 2)
            echo '<td>' . (isset($data['F']) ? $data['F'] : null) . '</td>';
        if ($size >= BASE_SIZE + 3)
            echo '<td>' . (isset($data['G']) ? $data['G'] : null) . '</td>';
        if ($size >= BASE_SIZE + 4)
            echo '<td>' . (isset($data['H']) ? $data['H'] : null) . '</td>';
        if ($size >= BASE_SIZE + 5)
            echo '<td>' . (isset($data['I']) ? $data['I'] : null) . '</td>';
        if ($size >= BASE_SIZE + 6)
            echo '<td>' . (isset($data['J']) ? $data['J'] : null) . '</td>';

        echo '<td>' . $data['Answer'] . '</td>';
        echo '<td>' . $data['Hint'] . '</td>';
        echo '</tr>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>dataset</title>
</head>
<body>

<h2>当前存疑题目</h2>


    <?php
    foreach ($table_list as $table) {

        echo "<h2>$table</h2>";

        $columns = $database->query("SHOW COLUMNS FROM $table")->fetchAll();
        unset($field_list);
        $field_list = [];

        foreach ($columns as $col) {
            $field_list[] = $col['Field'];
        }

        $data = getTr($database, $table);
        echo '<table border="1">';
        EchoTr(sizeof($field_list));
        EchoTd($table, $data,sizeof($field_list));
        echo '</table>';
    }

    ?>
    <!--    <tr>-->
    <!--        <th>来源表</th>-->
    <!--        <th>id</th>-->
    <!--        <th>PostProblem</th>-->
    <!--        <th>Classification</th>-->
    <!--        <th>A</th>-->
    <!--        <th>B</th>-->
    <!--        <th>C</th>-->
    <!--        <th>D</th>-->
    <!--        <th>E</th>-->
    <!--        <th>Answer</th>-->
    <!--        <th>Hint</th>-->
    <!--    </tr>-->
    <!---->
    <!--    <tr>-->
    <!--        <td>--><?php //echo $table ?><!--</td>-->
    <!--        <td>--><?php //echo $data['id'] ?><!--</td>-->
    <!--        <td>--><?php //echo $data['PostProblem'] ?><!--</td>-->
    <!--        <td>--><?php //echo $data['Classification'] ?><!--</td>-->
    <!--        <td>--><?php //echo $data['A'] ?><!--</td>-->
    <!--        <td>--><?php //echo $data['B'] ?><!--</td>-->
    <!--        <td>--><?php //echo $data['C'] ?><!--</td>-->
    <!--        <td>--><?php //echo isset($data['D']) ? $data['D'] : null ?><!--</td>-->
    <!--        <td>--><?php //echo isset($data['E']) ? $data['E'] : null ?><!--</td>-->
    <!--        <td>--><?php //echo $data['Answer'] ?><!--</td>-->
    <!--        <td>--><?php //echo $data['Hint'] ?><!--</td>-->
    <!--    </tr>-->



</body>
</html>