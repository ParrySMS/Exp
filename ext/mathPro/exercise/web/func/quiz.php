<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-13
 * Time: 15:33
 */


/** 出n道单选题
 * @param $current_diff
 * @param int $type
 * @throws Exception
 */
function takeSCQuiz($current_diff, int $type = QUESTION_TYPE_SINGLE_CHOOSE)
{
    //  出题
    // 确认type --> 单选
    // 确认diff --> 取diff

    $quet = new Question();
    // 拿题
    $qusetions = $quet->getQt($type, $current_diff);
    //准备交给上层 输出到 HTML 里
    return $qusetions;
}


/** 根据最近2次来更新 同时返回最新的结果
 * 答案——>diff 确认当前你的难度等价情况-->diff
 * @param $uid
 * @param $quiz_id
 * @return int
 * @throws Exception
 */
function updateDiff($uid, $quiz_id): int
{

    //查这个用户submit LOG 的答题情况--最新的两条
    $db_submit = new Submit();

    $datas = $db_submit->getLatestResult($uid, $quiz_id);
    // 判断 --- 升级 --保存在quiz里
    $res = 0;//res 正确题目数量 默认0题正确
    foreach ($datas as $d) {//遍历全部结果
        if ($d['result'] == ANSWER_INCORRECT) {//如果错了一题 退出
            break;
        }
        $res++;//没错 那就记录多1题正确
    }

    $db_quiz = new Quiz();
    if ($res == QUIZ_EACH_TIMES_QUESTION) {//如果正确的题数符合要求（全对）
        $db_quiz->addFinalDiff($quiz_id);//等级自动升级
    }

    return $db_quiz->getFinalDiff($quiz_id);//去数据库拿最新的等级 返回出去
}

/** 获取当前对应diff
 * @param $quiz_id
 * @return int
 * @throws Exception
 */
function getDiff($quiz_id)
{
    $db_quiz = new Quiz();
    return $db_quiz->getFinalDiff($quiz_id);
}

function getMark()
{

    //todo 查最后提交的等级
}


/** 保存1道题 把答题内容拿过来 同时取答案 判断对错 保存结果-更新submit 更新diff
 * @param int $uid
 * @param int $qid
 * @param $answer
 * @param int $quiz_id
 * @throws Exception
 */
function saveCurrentResult(int $uid, int $qid, $answer, int $quiz_id)
{
    // 第一步 拿到答案
    $db_answer = new Answer();
    $std_answer = $db_answer->getAnswerContent($qid);

    //第二步 判断
    //
    $res = ($answer == $std_answer) ? ANSWER_CORRECT : ANSWER_INCORRECT;
    // 第三步 保存结果--insert
    $submit = [
        'uid' => $uid,
        'qid' => $qid,
        'time' => date(TIME_FORMAT),
        'submit_content' => $answer,
        'quiz_id' => $quiz_id,
        'result' => $res,
        'visible' => SUBMIT_VALID
    ];

    //INSERT FUNCTION
    $db_submit = new Submit();
    $db_submit->insert($submit);

    //外面更新diff结果到数据库

}

function getRefer($res)
{
    //todo 根据最终结果 输出推荐资料
    // todo 资料表
}

function getRecord($uid)
{

    //todo 展示最近一次测试的答题结果

}


/** 用uid 拿到 quizid
 * @param int $uid
 * @return array|bool|int|mixed
 * @throws Exception
 */
function getQuizid(int $uid)
{
    $db_quiz = new Quiz();
    $quiz_id = $db_quiz->findLatestQuiz($uid);
    return $quiz_id;

}

/** 判断有没有结束 到次数了
 * @param $quiz_id
 * @return bool
 * @throws Exception
 */
function isQuizOver($quiz_id): bool
{
    $db_sub = new Submit();
    return $db_sub->isEnoughSubmit($quiz_id);
}


function endAQuiz($quiz_id)
{
    $db_quiz = new Quiz();
    $db_quiz->updateFinish($quiz_id);
}