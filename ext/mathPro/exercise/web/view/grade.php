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
    $next_url = './unit.php?'.$_SERVER['QUERY_STRING'];

    //todo 选unit   传递参数进入下一个页面


} catch (Exception $e) {
    echo $e->getMessage();
}



function gradeText($base_url, int $grade_num = 2)
{
    $base_grade = 6;
    for ($i = 0; $i < $grade_num; $i++) {
        $grade_params = $base_grade+$i;
        print<<<ATAG
 <a href="{$base_url}&grade={$grade_params}"> Grade {$grade_params}</a><br/>
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
gradeText($next_url);
?>
<!--<a href="./new_quiz.php?uid=4&unit=1" > Unit 1: Alge</a>-->
</div>
</div>

</body>
</html>