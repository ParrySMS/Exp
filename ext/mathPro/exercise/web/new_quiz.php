<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-16
 * Time: 15:15
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

require './config/params.php';
require './config/db.php';
require './config/Medoo.php';




try {

    //todo 0 拿参数 参数校验

    $uid = $_GET['uid'];//拿到

    $url = "./new_quiz.php?uid=$uid";

    $qids = $_GET['qids']??null;// 用户拿过来的题目id数组

    $answers = [];// 可能用循环-- 很多题的答案
    $size = empty($qids)?0:sizeof($qids);
    for($i = 0;$i<$size;$i++){
        $input_name = 'Q' . (string)$i . 'Answer';
        if(!isset($_POST[$input_name])){
            break;
        }
        $answers[] = $_POST[$input_name];
    }


    //todo 1 用uid 找 quiz-id
    $quiz_id = getQuizid($uid);

    //todo 2 if 有答案 --> 保存答案（里面会记录 判断对错 更新diff）-- 拿到了diff
    //todo 有如果有答案
    if(!empty($answers)){
        //遍历数组里的每一个值 拿进来用
        for ($i = 0; $i < QUIZ_EACH_TIMES_QUESTION; $i++) {
            $qid = $qids[$i];
            $ans = $answers[$i];
            //一题题保存
            saveCurrentResult($uid, $qid, $ans, $quiz_id);
        }//保存完了

        //保存完 -》更新diff 拿到最新的diff
        $diff = updateDiff($uid, $quiz_id);
    } else {
        //如果没答案 第一次create的 取默认值
        $diff = getDiff($quiz_id);
    }

    //todo 3 判断结束（用diff、看次数） --> 结束就跳出去

    if ($diff == QUIZ_MAX_DIFF_LEVEL || isQuizOver($quiz_id)) {
        //结束quiz
        endAQuiz($quiz_id);
        //todo 跳
        echo 'jump';
    }

    //todo 4 用diff出题
    $questions = takeSCQuiz($diff);

    //todo 5 题目数据保存好 下面放到 html 展示
//    $url = "./new_quiz.php?uid=$uid";
     foreach ($questions as $key => $q) {
         $url = $url . '&qids[' . $key . ']=' . $q['qid'];
     }

} catch (Exception $e) {
    echo $e->getMessage();
    //todo 报错 --可能是跳转 可能重新来 输出报错结果
}


/** 输出问题和选项的html代码
 * @param $questions
 */
function echoQuestionContent($questions)
{

    if(!is_array($questions) || sizeof($questions) != QUIZ_EACH_TIMES_QUESTION){
        //输出错误
        echo 'ERROR';
    }else {
        //输出html代码
        foreach ($questions as $key => $q) {

            echo '<p>' . $q['content'] . '<br/></p>';//输出题目

            $optionArr = $q['optionArray'];
            foreach ($optionArr as $o) { //循环输出某题的n个选项
                //<label>
                //   <input name="Fruit" type="radio" value="A" /> A.苹果
                // </label>

                $input_name = 'Q' . (string)$key . 'Answer';
                $input_value = $o['key'];
                $input_text = $o['key'] . '. ' . $o['content'];

                $label_tag =
                    '<label><input name="' . $input_name
                    . '" type="radio" value="' . $input_value . '" />'
                    . $input_text . ' </label>';
                echo $label_tag;
            }
        }
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>答题页面</title>

</head>
<body>

<form action=" <?php echo $url ?? null  ?>" method="post">


        <?php
            echo $url;
            $q = $questions ?? null;
            echoQuestionContent($q);
        ?>
    <br/>
<input type="submit" value="Submit" />
</form>


</body>

</html>

