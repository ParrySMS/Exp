<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-13
 * Time: 15:33
 */


function takeSCQuiz($current_diff,int $times = 0,int $type = QUESTION_TYPE_SINGLE_CHOOSE)
{
        // todo 出题
        //todo 确认type --> 单选
        //todo 确认diff --> 取diff

        $quet = new Question();
        //todo 拿题
        $qusetions = $quet->getQt($type,$current_diff);
        //todo 输出到 HTML 里


}



// 答案————》 diff 确认当前你的难度等价情况-->diff
function updateDiff($uid, $quiz_id){

    //查这个用户submit LOG 的答题情况--最新的两条
    $db_submit = new Submit();

    $datas = $db_submit->getLatestResult($uid,$quiz_id);
    // 判断 --- 升级 --保存在quiz里
    $res = 0;//默认0题正确
    foreach ($datas as $d){//遍历全部结果
        if($d['result'] == ANSWER_INCORRECT ){//如果错了一题 退出
            break;
        }
        $res++;//没错 那就记录多1题正确
    }

    $db_quiz = new Quiz();
    if($res == QUIZ_EACH_TIMES_QUESTION){//如果正确的题数符合要求（全对）
        $db_quiz->addFinalDiff($quiz_id);
    }

    return $db_quiz->getFinalDiff($quiz_id);
}


function getMark(){

    //todo 查最后提交的等级
}


function saveCurrentResult(int $uid,int $qid,$answer,int $quiz_id){
    // 第一步 拿到答案
    $db_answer = new Answer();
    $std_answer = $db_answer->getAnswerContent($qid);

    //第二步 判断
    //
    $res = $answer == $std_answer ? ANSWER_CORRECT: ANSWER_INCORRECT;
    // 第三步 保存结果--insert
    $submit = [
        'uid'=>$uid,
        'qid'=>$qid,
        'time'=>date(TIME_FORMAT),
        'submit_content'=>$answer,
        'quiz_id'=>$quiz_id,
        'result' => $res,
        'visible'=>SUBMIT_VALID
    ];

    //INSERT FUNCTION
    $db_submit = new Submit();
    $db_submit->insert($submit);

    //todo 保存diff结果 到数据库
}

function getRefer($res){
    //todo 根据最终结果 输出推荐资料
     // todo 资料表
}

function getRecord($uid){

    //todo 展示最近一次测试的答题结果

}