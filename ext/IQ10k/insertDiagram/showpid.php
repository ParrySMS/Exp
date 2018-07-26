<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-7-25
 * Time: 15:53
 */
require 'PmCheck.php';
require 'Http.php';

try {
    //参数检查
    $pm = new PmCheck();
    //获取参数
    $problem = $_POST['problem'];
    $option_num = $_POST['option_num'];
    //定义空数组
    $options = array();
    //转为数组
    $answers = array($_POST['answers']);

    $hint = $_POST['hint'];
    $classification = $_POST['classification'];
    $language = $_POST['language'];
    $pro_type = $_POST['pro_type'];
    $pro_source = $_POST['pro_source'];

    //获取参数之后 发送请求
    $http = new Http();
    $url = 'http://exp.szer.me/parry/testlib/problem';
    $data = compact('problem', 'option_num', 'options', 'answers',
        'hint', 'classification', 'language', 'pro_type', 'pro_source');

//    var_dump($data);
    $res = $http->post($url, $data);
//    var_dump($res);
    /**
     *  返回结果
    {
    "retmsg": 操作成功,
    "retdata": {
    "pid": "1",
    }
    "retcode":200200
    }
     */
    //解析结果
    $res_obj = json_decode($res,true);
    if($res_obj->retcode != 200200){
        throw new Exception($res_obj->retmsg,$res_obj->retcode);
    }
    //获取pid
    $pid = $res_obj->retdata->pid;
    $msg = $res_obj->retmsg;

} catch (Exception $e) {
    echo 'code: '.$e->getCode().' ,错误信息：' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> <? echo isset($msg)?$msg:'error'; ?></title>


</head>
<body>

<h2><a href="./form.html"> 返回继续添加题目</a></h2>
<br/>

<h2><? echo isset($msg)?$msg:'error' ?></h2>
<h1>新添加的题目id为： <strong style="color: #9b0000"> <?php echo isset($pid)?$pid:'error'; ?> </strong> </h1>
<br/>
<h3>题目中的题图，命名格式为 id-t，例如 <?php echo isset($pid)?$pid:'error'; ?> -A</h3>
<h3>如果题目有多张图，在保证清晰的情况下，将多张图片上下连接变成一张图片</h3>
    <br/>
<h3>切分出每个选项的图，命名格式为 id-小写选项，例如 <?php echo isset($pid)?$pid:'error'; ?>-a</h3>
<h3> 如果有一个包含四选项的大图，命名格式为 id-0，例如 <?php echo isset($pid)?$pid:'error'; ?>-0</h3>



</body>
</html>
