<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-8-22
 * Time: 1:06
 */

namespace tlApp\service;


use tlApp\model\Json;

class Comment extends BaseService
{
    public function __construct()
    {
        $this->com = new \tlApp\dao\Comment();
        $this->json = new Json();
    }

    /** 实现评论添加
     * @param $pid
     * @param $comment
     * @return Json
     */
    public function add($pid, $comment)
    {
        $cid = $this->com->insert($pid, $comment);

        $retdata = (object)[
            'pid' => $pid,
            'cid' => $cid
        ];
        $this->json->setRetdata($retdata);
        return $this->json;

    }





}