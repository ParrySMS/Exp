<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-3-16
 * Time: 15:15
 */
require '../func/pm.php';
require '../func/check.php';
require '../func/quiz.php';

require '../db/Db.php';
require '../db/Answer.php';
require '../db/Option.php';
require '../db/Question.php';
require '../db/Quiz.php';
require '../db/Submit.php';
require '../db/User.php';

require '../config/params.php';
require '../config/db.php';
require '../config/Medoo.php';


try {
    //todo 获取参数
    $uid = $_GET['uid'];//拿到
    $next_url = './new_quiz.php?'.$_SERVER['QUERY_STRING'];

    //todo 选unit   传递参数进入下一个页面


} catch (Exception $e) {
    echo $e->getMessage();
}



function classificationText($base_url)
{
    $num = sizeof(TYPE_NAME_ARRAY);
    for ($i = 0; $i < $num; $i++) {
        $classifi_params = TYPE_NAME_ARRAY[$i];
        //参数只存编号
        print<<<ATAG
 <a href="{$base_url}&classification={$i}">  {$classifi_params}</a><br/>
ATAG;
    }

//    <a href="./new_quiz.php?uid=4&unit=1" > Unit 1: Alge</a>
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>选择年级</title>
    <link rel="stylesheet" type="text/css" href="../css/unit.css"/>
</head>
<body>
<div class="outer-wrap">
<div class="unit-panel">
<?php
classificationText($next_url);
?>
<!--<a href="./new_quiz.php?uid=4&unit=1" > Unit 1: Alge</a>-->
</div>
</div>

</body>
</html>