<?php
require './config/database_info.php';
require './config/params.php';
require './config/Medoo.php';

use Medoo\Medoo;


Class DB
{
    public $table_pro = DB_PREFIX . '_problem';
    public $table_h = DB_PREFIX . '_hint';
    public $table_pic = DB_PREFIX . '_pic';
    public $database;

    /**
     * DB constructor.
     * @param $database
     */
    public function __construct()
    {    //数据库配置初始化
        $this->database = new Medoo([
            'database_type' => DATABASE_TYPE,
            'database_name' => DATABASE_NAME,
            'server' => SERVER,
            'username' => USERNAME,
            'password' => PASSWORD,
            'port' => PORT,
            'charset' => CHARSET
        ]);
    }
}

try {


    //题目参数获取
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    //参数检查
    if (!is_numeric($id)) {
        throw new Exception('id error');
    }
    //下页设置
    $nid = $id + 1;
    $next = ROUTE . "check.php" . "?id=$nid";
    //链接数据库取出1条数据
    $db = new DB();
    $new_data = getData($id, $db);
    //只会取出1条
    unset($data);
    $data = $new_data[0];
    //设置内容
    if (isset($data['answers'])) {
        $answer = json_decode($data['answers']);
        if (is_array($answer) && sizeof($answer) == 1) {
            $answer = $answer[0];
        } else {
            $answer = '数据错误';
        }
    }

    if (isset($data['visible'])) {
        $status = $data['visible'] == 1 ? '合理' : '存疑';
    }

    //todo 展示题目图片 展示选项图片
    //todo 添加不合理原因
    //todo  (可以筛选完之后再弄)编辑框
    //todo 机器处理 转成英文


} catch (Exception $e) {
    echo '错误信息<br/>' . $e->getMessage();
}

//函数方法区

function getData($id, DB $db)
{

    $database = $db->database;
    $data = $database->select($db->table_pro, [
        //左连hint表
        "[>]$db->table_h(h)" => ['id' => 'pid'],
    ], [
        "$db->table_pro.id",
        "$db->table_pro.problem",
        "$db->table_pro.option_num",
//        "$db->table_pro.options",
        "$db->table_pro.answers",
        "$db->table_pro.language",
        "$db->table_pro.classification",
        "$db->table_pro.pro_type",
        "$db->table_pro.visible",
        'h.hint'
    ], [
        'AND' => [
            "$db->table_pro.id" => $id
        ]
    ]);

    if (!is_array($data) || sizeof($data) != 1) {
        throw new \Exception("db error: id = $id");
    }
    return $data;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>dataset</title>
</head>
<body>

<h2><a href=<?php echo isset($here) ? $here . '' : ''; ?>>改变状态</a></h2>
<h2><a href=<?php echo isset($next) ? $next : '' ?>>下一题</a></h2>

<h2>当前题目ID：<?php echo isset($id)?$id:'error'; ?></h2>
<h2>当前题目状态：<strong style="color: #be0000"> <?php echo isset($status)?$status:'error'; ?> </strong> </h2>

<table border="1">
    <tr>
        <th>id</th>
        <th>题型</th>
        <th>题目</th>
        <th>答案</th>
        <th>提示</th>
        <th>选项数量</th>
        <th>Classification</th>
        <th>语言</th>



    </tr>
    <tr>
        <td><?php echo isset($data['id'])?$data['id']:'error'?></td>
        <td><?php echo isset($data['pro_type'])?$data['pro_type']:'error' ?></td>
        <td><?php echo isset($data['problem'])?$data['problem']:'error' ?></td>
        <td><?php echo isset($answer)?$answer:'error' ?></td>
        <td><?php echo isset($data['hint'])?$data['hint']:'' ?></td>
        <td><?php echo isset($data['option_num'])?$data['option_num']:'error' ?></td>
        <td><?php echo isset($data['classification'])?$data['classification']:'error' ?></td>
        <td><?php echo isset($data['language'])?$data['language']:'error' ?></td>
    </tr>
</table>

</body>
</html>
