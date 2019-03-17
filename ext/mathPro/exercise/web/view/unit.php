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
    $url = "./new_quiz.php?uid=$uid";

    //todo 选unit   传递参数进入下一个页面


} catch (Exception $e) {
    echo $e->getMessage();
}



function unitText($base_url, int $unit_num = 5, array $unit_name = UNIT_NAME_ARRAY)
{

    for ($i = 0; $i < $unit_num; $i++) {
        $unit_params = $i + 1;//为了从1开始
        print<<<ATAG
 <a href="{$base_url}&unit={$unit_params}"> Unit {$unit_params}: {$unit_name[$i]}</a><br/>
ATAG;
    }

//    <a href="./new_quiz.php?uid=4&unit=1" > Unit 1: Alge</a>
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>选择单元</title>
    <link rel="stylesheet" type="text/css" href="../css/unit.css"/>
</head>
<body>
<div class="outer-wrap">
<div class="unit-panel">
<?php
unitText($url);
?>
<!--<a href="./new_quiz.php?uid=4&unit=1" > Unit 1: Alge</a>-->
</div>
</div>

</body>
</html>