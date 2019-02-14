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

if($times == QUIZ_TIMES_LIMIT){
    //TODO 算分出结果
    getMark();

}else {

//todo 第几次  0-n -》保存答题结果
    saveCurrentResult();

    //todo 出卷子
}


//todo html
?>

