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
    private $com;

    public function __construct()
    {
        $this->com = new \tlApp\dao\Comment();
        $this->json = new Json();
    }

    /** 实现评论添加
     * @param $pid
     * @param $comment
     * @return Json
     * @throws \Exception
     */
    public function add($pid, $comment)
    {
        $cid = $this->com->insert($pid, $comment);
        //还有更新评论数
        $pro = new Problem();
        $pro->addCommentNum($pid);

        $retdata = (object)[
            'pid' => $pid,
            'cid' => $cid
        ];
        $this->json->setRetdata($retdata);
        return $this->json;

    }

    /** 返回comments数组
     * 可能是空数组
     * @param $pid
     * @return mixed
     * @throws \Exception
     */
    public function getComments($pid){

        return $this->com->select($pid);
    }





}