<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-13
 * Time: 15:33
 */


/** 出n道单选题  弃用 加上了单元选择参数
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
    $qusetions = $quet->getQt($type, $current_diff,0);// 弃用 加上了单元unit参数
    //准备交给上层 输出到 HTML 里
    return $qusetions;
}

function takeSCQuizWithUnit($current_diff, int $unit,int $type = QUESTION_TYPE_SINGLE_CHOOSE)
{
    //  出题
    // 确认type --> 单选
    // 确认diff --> 取diff
    // 指定单元

    $quet = new Question();
    // 拿题
    $qusetions = $quet->getQt($type, $current_diff,$unit);
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
    $res = ($answer == $std_answer['content']) ? ANSWER_CORRECT : ANSWER_INCORRECT;
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


/** 取出了 一个quiz 全部题目
 * 参考推荐 $refer
 * {
 *  name
 *  content
 * }
 *
 * 多个题目$submit_res  ar{  ...
 *  array{
 *      题目内容 qid--q_content,
 *      题目难度 q_diff
 *      选项数组 optionAr
 *      答案 standard_content 和 submit_content
 *      正误 result
 *      时间 time
 *  }
 * }
 * @param int $uid
 * @param int $quiz_id
 * @return array
 * @throws Exception
 */
function getQuizRecord(int $uid, int $quiz_id): array
{
    //todo 展示最近一次测试的答题结果
    // submit--> qids --> questions and answers
    $db_sub = new Submit();
    $submit_res = $db_sub->getAllQidsInQuiz($uid, $quiz_id);

    $db_que = new Question();
    $db_ans = new Answer();
    $db_op = new Option();
    $refer_ids = [];//保存题目对应的类型id  无重复
    foreach ($submit_res as & $s) {//引用传递 要改值
        $qid = $s['qid'];
        $q_cdr = $db_que->getQContentDiffRid($qid);
        $s['standard_content'] = $db_ans->getAnswerContent($qid);
        $s['optionAr'] = $db_op->getOptionsByQid($qid);
        $s['q_content'] = $q_cdr['content'];
        $s['q_diff'] = $q_cdr['diff'];

        $rid = $q_cdr['refer_id'];
        if (!in_array($rid, $refer_ids)) {
            $refer_ids[] = $rid;
        }

    }
    //题目完整了

    //题目对应的类型id数组 -- 拿refer内容
    $db_refer = new Refer();
    $refer_name_content_ar = [];//保存若干个rid对应的推荐

    foreach ($refer_ids as $rid) {
        $refer_name_content_ar[] = $db_refer->getNameContent($rid);
    }


    return [
        'refer' => $refer_name_content_ar,
        'submit_res' => $submit_res
    ];

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

/**
 * @param $quiz_id
 * @throws Exception
 */
function endAQuiz($quiz_id)
{
    $db_quiz = new Quiz();
    $db_quiz->updateFinish($quiz_id,QUIZ_FINISHED);
}


/** 找对应的quiz 拿finaldiff 参数获取comment
 * @param $quiz_id
 * @return string
 * @throws Exception
 */
function getQuizComment($quiz_id): string
{
    //final diff -- the diff of finished quiz-- 2 id

    $db_quiz = new Quiz();
    $final_diff = $db_quiz->getFinalDiff($quiz_id);

    // diff --> comment

    switch ($final_diff) {
        case QUESTION_DIFF_LEVEL_1:
            $comment = QUIZ_DIFF_COMMENT_LEVEL_1;
            break;
        case QUESTION_DIFF_LEVEL_2:
            $comment = QUIZ_DIFF_COMMENT_LEVEL_2;
            break;
        case QUESTION_DIFF_LEVEL_3:
            $comment = QUIZ_DIFF_COMMENT_LEVEL_3;
            break;
        case QUIZ_MAX_DIFF_LEVEL:
            $comment = QUIZ_DIFF_COMMENT_LEVEL_4;
            break;
    }

    return $comment;
}