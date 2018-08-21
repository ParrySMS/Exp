<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-8-22
 * Time: 0:31
 */

namespace tlApp\controller;

use tlApp\common\LogicPmCheck;

class Comment extends BaseController
{
    private $com;

    /**
     * Comment constructor.
     */
    public function __construct()
    {
        parent::actionLog();
        $this->com = new \tlApp\service\Comment();

    }

    public function add(array $body)
    {
        try {
            //日志记录
            parent::actionLog();

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
    }

    private function addComment($pid, $comment)
    {
        $this->echoJson($this->com->add($pid, $comment));
    }


}