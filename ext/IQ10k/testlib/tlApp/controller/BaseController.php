<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-7-23
 * Time: 1:02
 */
namespace tlApp\controller;
use tlApp\model\Json;
use \Exception;
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

    public function error(Exception $e){
        if ($e->getCode() <= 505) {//非200 直接输出
            $this->setStatus($e->getCode());
            echo MSG_ERROR_INFO . $e->getMessage();

        } else { //200下状态码 报错用json处理
            $this->setStatus(200);
            $json = new Json($e->getMessage(), null, $e->getCode());
            $this->echoJson($json);
        }
    }

    public function echoJson(Json $json)
    {
        if (!is_null($json)) {
            print_r(json_encode($json));
        }
    }
}