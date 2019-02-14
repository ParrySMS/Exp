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


//todo 确认当前你的难度等价情况-->diff
function getDiff(){

    //todo 查这个用户LOG 的答题情况 -- 未结束 --是否升级

    //todo --> user表  log表
}


function getMark(){
    //todo 查这个用户LOG --> 拿到答题情况 算最后结果
    //todo 输出到 HTML 里

}


function saveCurrentResult($uid,$qid,$answer){
    //todo 保存当前答题结果
    //todo  谁  那个题  答案数据  --> 有没答对  查 answer表
    //todo 查 option
    //todo 保存diff结果 到数据库
}

function getRefer($res){
    //todo 根据最终结果 输出推荐资料
     // todo 资料表
}

function getRecord($uid){

    //todo 展示最近一次测试的答题结果

}