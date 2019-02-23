<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-23
 * Time: 15:02
 */

require './func/pm.php';
require './func/check.php';
require './func/quiz.php';

require './db/Db.php';
require './db/Answer.php';
require './db/Option.php';
require './db/Question.php';
require './db/Quiz.php';
require './db/Submit.php';
require './db/User.php';
require './db/Refer.php';

require './config/params.php';
require './config/db.php';
require './config/Medoo.php';

$quiz_records = [];
$quiz_comment = 'error';

try {
    //todo 第一步 取参数 uid quiz_id


    $uid = $_GET['uid'] ?? null;
    $quiz_id = $_GET['quiz_id'] ?? null;

    if (!is_numeric($uid) || !is_numeric($quiz_id)) {
        throw new Exception('params error');
    }


    //todo 拿题  diff --拿评价
    $quiz_records = getQuizRecord($uid, $quiz_id);
    $quiz_comment = getQuizComment($quiz_id);
    //todo 输出


} catch (Exception $e) {
    echo $e->getMessage();
}


function echoQuizRecord(array $quiz_records)
{
    if (empty($quiz_records)) {
        echo 'error';
    } else {
        //输出 refer 列表
        $refer = $quiz_records['refer'];
        echo '<ul>';
        foreach ($refer as $r) {
            echo '<li>' . $r['name'] . ':' . $r['content'] . '</li>';
        }
        echo '</ul>';

        $q_res = $quiz_records['submit_res'];
        /**
         *    多个题目$submit_res  ar{  ...
         *  array{
         *      题目内容 qid--q_content,
         *      题目难度 q_diff
         *      选项数组 optionAr
         *      答案 standard_content 和 submit_content
         *      正误 result
         *      时间 time
         *  }
         * }
         **/
        foreach ($q_res as $q) {
            echo '<p>';
            echo '<h3>' . $q['q_content'] . '</h3><br/>';

            $option_ar = $q['optionAr'];
            foreach ($option_ar as $op) {
                echo $op['key'] . '. ' . $op['content'] . '<br/>';

            }

            echo 'Your Answer:' . $q['submit_content'] . '<br/>';
            echo 'Standard Answer:' . $q['standard_content']['content'] . '<br/>';
            $res_string = $q['result'] == ANSWER_CORRECT ? 'Correct' : 'Wrong';
            echo 'Your result:' . $res_string . '<br/>';
            echo 'Question Diff:' . $q['q_diff'] . '<br/>';
            echo 'Time:' . $q['time'] . '<br/>';
            echo '</p>';
        }

    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">


    <title>答题结果页面</title>

</head>
<body>

<!- 输出 评价comment-->
<?php
echo '<p><h3>' . $quiz_comment . '</h3></p>';
// 输出 题目 -- 答题 -- 答案-->
echoQuizRecord($quiz_records)

?>


</body>

</html>

