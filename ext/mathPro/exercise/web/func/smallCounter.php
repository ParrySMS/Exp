<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-14
 * Time: 17:23
 */


require '../db/Db.php';
require '../db/Answer.php';
require '../db/Option.php';
require '../db/Question.php';
require '../db/Quiz.php';
require '../db/Submit.php';
require '../db/User.php';
require '../db/Refer.php';

require '../config/params.php';
require '../config/db.php';
require '../config/Medoo.php';

for ($i=0;$i<50;$i++) {
    insertNewQusetionOptionAnswer();
}
echo 'finished!';



function varOpVar()
{

    $a = rand(1, 100);
    $b = rand(1, 100);

    $len = sizeof(SMALL_OP);
    $key = rand(0, $len-1);

    $op = SMALL_OP[$key];

    $content = "$a$op$b=?";

    $small_q = [
        'a' => $a,
        'b' => $b,
        'op' => $op,
        'content' => $content,
        'type' => QUESTION_TYPE_SINGLE_CHOOSE,
        'diff' => QUESTION_DIFF_LEVEL_1,
        'content' => $content,

    ];

    return $small_q;

}


function varOpVarAll()
{

    $contents = [];//存每种运算符 的100题
    foreach (SMALL_OP as $op) {

        for ($i = 0; $i < 100; $i++) {//每个出100次

            $a = rand(1, 100);
            $b = rand(1, 100);
            $contents[] = "$a$op$b=?";
        }
    }

    return $contents;
}

/** 课堂的一种写法
 * @param $answer
 * @return bool
 */
function getOptions($answer)
{

    $op = (int)rand(-1, 1);
    while ($op == 0) {
        $op = (int)rand(-1, 1);
    }

    $rand1 = $op * rand(1, 5);
    $rand2 = $op * rand(1, 5);
    $rand3 = $op * rand(1, 5);

    while ($rand1 == $rand2 || $rand1 == $rand3 || $rand2 == $rand3) {
        if ($rand1 == $rand2) {
            $rand2 = $op * rand(1, 5);
        }

        if ($rand1 == $rand3) {
            $rand3 = $op * rand(1, 5);
        }

        if ($rand2 == $rand3) {
            $rand3 = $op * rand(1, 5);
        }
    }
    $arr = [$answer + $rand1, $answer, $answer + $rand2, $answer + $rand3];
    return shuffle($arr);
}

/** 另一种更简单的写法
 * @param $answer
 */
function getOptions2($answer)
{
    $arr = [$answer];//一个个放进arr里

    for ($i = 0; $i < 3; $i++) {//产生另外3个选项
        $rand = rand($answer - 5, $answer + 5);
        while (in_array($rand, $arr)) {//循环重新取 直到不重复
            $rand = rand($answer - 5, $answer + 5);
        }
        $arr[] = $rand;//放进去 开始下一个选项生成
    }
    shuffle($arr);

    $key = 'A';
    $new_arr = [];
    foreach ($arr as $op){
        $new_arr[$key]= $op;
        $key++;
    }

    return $new_arr;
}


function getAnswer(int $a, int $b, $op)
{
    switch ($op) {
        case '+':
            return $a + $b;
        case '-':
            return $a - $b;
        case 'x':
        case '*':
            return $a * $b;
        case '÷':
        case '/':
            return $a / $b;
        case '%':
            return $a % $b;
    }

}


/** 主逻辑 拿到了 题目
 *
 */
function getTotalQuestion()
{
    $small_q = varOpVar();
    $content = $small_q['content'];
    $a = $small_q['a'];
    $b = $small_q['b'];
    $op = $small_q['op'];


    $answer = getAnswer($a, $b, $op);


    $type = $small_q['type'];
    $diff = $small_q['diff'];


    $options = getOptions2($answer);

    return [
        'content' => $content,
        'type'=>$type,
        'diff'=>$diff,
        'correct_num' => $answer,
        'optionCharIndexAr' => $options,
        'refer_id'=> 1
    ];
}

/** 插入题目到DB里
 * @throws Exception
 */
function insertNewQusetionOptionAnswer(){

    $total = getTotalQuestion();//1个新的随机题

    $db_que = new Question();
    $qid = $db_que->insert($total);//插入题目的得到qid


    $db_option = new Option();
    $key_num_optionAr = $total['optionCharIndexAr'];
    foreach ( $key_num_optionAr as $key => $content){
        $db_option->insert($key,$content,$qid);
    }


    $db_ans = new Answer();

    $ans_content = array_search($total['correct_num'],$key_num_optionAr);
    $db_ans->insert($ans_content,$qid);

}

function insertImageQusetionOptionAnswer(){
    $db_que = new Question();

    for($i=58;$i<65;$i++){
        $imageQue = [
            'content' => '/quesimg/q'.$i.'.png',
            'type'=>1,
            'diff'=>1,
//            'correct_num' => $answer,
//            'optionCharIndexAr' => $options,
            'refer_id'=> 1
        ];

        $qid = $db_que->insert($imageQue);//插入题目的得到qid
    }

}