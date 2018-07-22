<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-7-23
 * Time: 1:02
 */
namespace tlApp\controller;

class BaseController
{

    /**
     * @var int $status 用于路由调用的状态码 默认200
     */
    protected $status = 200;

    /** getter方法
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

}