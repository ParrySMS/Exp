<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-8-20
 * Time: 10:40
 */

namespace tlApp\common;
use tlApp\dao\Action;

class Log
{

    /** 记录action,进入记录一次，报错记录一次
     * @param $uid
     */
    public function action($uid, $error_code = null)
    {
        $http = new Http();
        $ip = $http->getIP();
        $agent = $http->getAgent();
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        // 实现dao类
        $action = new Action();
        $action->insert($uid, $ip, $agent, $uri,$method, $error_code);
    }


}