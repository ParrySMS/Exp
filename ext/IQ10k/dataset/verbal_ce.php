<?php
require './config/db.php';
require './config/Medoo.php';
use Medoo\Medoo;

try {
    $name = 'verbal_ce';
    $table = PREFIX .$name;
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

    //展示基本信息 变量初始化
    $status = null;
    $next = null;
    $here = null;
    $data['id'] = null;
    $data['PostProblem'] = null;
    $data['Classification'] = null;
    $data['A'] = null;
    $data['B'] = null;
    $data['C'] = null;
    $data['D'] = null;
    $data['E'] = null;
    $data['Answer'] = null;
    $data['Hint'] = null;

    //参数获取
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $action = isset($_GET['action']) ? $_GET['action'] : null;

    //参数检查
    if (!is_numeric($id)) {
        throw new Exception('id error');
    }

    $nid = $id + 1;
    // $here = "/AI/$name.php" . "?id=$id";
    $here = ROUTE."$name.php" . "?id=$id";
   // $next = "/AI/$name.php" . "?id=$nid";
    $next = ROUTE."$name.php" . "?id=$nid";

    //检查是否改变状态
    if ($action !== null) {
        if ($action !== 'change') {
            throw new Exception('action error');
        } else {
            changeStatus($id, $database, $table);
        }
    }


    $new_data = getData($id, $database, $table);
    unset($data);
    $data = $new_data[0];
    if (isset($data['visible'])) {
        $status = $data['visible'] == 1 ? '合理' : '存疑';
    } else {
        $status = null;
    }
//    var_dump($data);
//    var_dump($status);




} catch (Exception $e) {
    echo '错误信息<br/>' . $e->getMessage();
}

//函数方法区

function getData($id, $database, $table)
{


    $data = $database->select($table, [
        'id',
        'PostProblem',
        'Answer',
        'Classification',
        'Hint',
        'A',
        'B',
        'C',
        'D',
        'E',
        'visible'
    ], [
        'id' => $id
    ]);

    if (!is_array($data) || sizeof($data) != 1) {
        var_dump($data);
        throw new Exception("db error:table = $table, id = $id");
    }
    return $data;
}

function changeStatus($id, $database, $table)
{
    $v = $database->get($table,
        'visible'
        , [
            'id' => $id
        ]);
    if (!is_numeric($v)) {
        throw new Exception('visible error');
    }

    $v = $v == 1 ? 0 : 1;

    $pdo = $database->update($table, [
        'visible' => $v
    ], [
        'id' => $id
    ]);

    if ($pdo->rowCount() != 1) {
        throw new Exception('status change error');
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

<h2><a href=<?php echo $here . '&action=change'; ?>>改变状态</a></h2>
<h2><a href=<?php echo $next ?>>下一题</a></h2>

<h2>当前题目ID：<?php echo $id; ?></h2>
<h2>当前题目状态：<?php echo $status; ?></h2>

<table border="1">
    <tr>
        <th>id</th>
        <th>Problem</th>
        <th>Classification</th>
        <th>A</th>
        <th>B</th>
        <th>C</th>
        <th>D</th>
        <th>E</th>
        <th>Answer</th>
        <th>Hint</th>
    </tr>
    <tr>
        <td><?php echo $data['id'] ?></td>
        <td><?php echo $data['PostProblem'] ?></td>
        <td><?php echo $data['Classification'] ?></td>
        <td><?php echo $data['A'] ?></td>
        <td><?php echo $data['B'] ?></td>
        <td><?php echo $data['C'] ?></td>
        <td><?php echo $data['D'] ?></td>
        <td><?php echo $data['E'] ?></td>
        <td><?php echo $data['Answer'] ?></td>
        <td><?php echo $data['Hint'] ?></td>
    </tr>
</table>

</body>
</html>
