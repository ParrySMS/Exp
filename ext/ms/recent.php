<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-10-28
 * Time: 23:09
 */

require "./BaseController.php";

try {
    //日志记录
    actionLog();

    //参数逻辑检查
    $pm = new LogicPmCheck();


    $pm->proCommentCheck($body);

    $pid = $pm->getPid();
    $comment = $pm->getComment();

    // 实现信息更新
    $this->addComment($pid, $comment);

} catch (\Exception $e) {
    $this->error($e);
}

