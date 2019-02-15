<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-13
 * Time: 14:52
 */

require './func/pm.php';
require './func/check.php';
require './db/Db.php';
require './config/params.php';
require './config/db.php';
require './config/Medoo.php';


//todo 出两道题 -- 直到满n道

//todo 如果是当前用户第一次 应该开启一次quiz -- 拿到quiz
// todo 如果不是第一次 应该找用户对应的最近一次时间未结束quiz --- quiz参数


//todo 第几次  0-n -》保存答题结果---quiz--id
saveCurrentResult();

//  用 updateDiff --》 diff


if($times == QUIZ_TIMES_LIMIT || $diff >= 某个值 ){
    //todo 判断结束  已结束 马上算分


}


//todo html
?>

