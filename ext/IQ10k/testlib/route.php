<?php

require './vendor/autoload.php';

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Medoo\Medoo;

//跨域设置 上线后应关闭
header("Access-Control-Allow-Credentials:true");
header("Access-Control-Allow-Methods:POST,GET");
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set("Asia/Shanghai");

//todo:debug模式 记得上线前关掉
$config = [
    'settings' => [
        'displayErrorDetails' => true
    ],
];

$app = new \Slim\App($config);
//自动遍历参数集
$pm_check = new \tlApp\common\PmCheck();

//路由组

//todo: 插入一条题目
$app->group('/problem', function ($request, $response) {
    $this->post('', function ($request, $response) {
        //接收数据
        $problem = isset($request->getParsedBody()["problem"]) ? $request->getParsedBody()["problem"] : null;
        $option_num = isset($request->getParsedBody()["option_num"]) ? $request->getParsedBody()["option_num"] : null;
        $language = isset($request->getParsedBody()["language"]) ? $request->getParsedBody()["language"] : null;
        $classification = isset($request->getParsedBody()["classification"]) ? $request->getParsedBody()["classification"] : null;
        $proType = isset($request->getParsedBody()["proType"]) ? $request->getParsedBody()["proType"] : null;
//        $proSource = isset($request->getParsedBody()["proSource"]) ? $request->getParsedBody()["proSource"] : null;
        $proSource = 'diagram';
        $hint = isset($request->getParsedBody()["hint"]) ? $request->getParsedBody()["hint"] : null;
        $problem_info = compact($problem, $option_num, $language, $classification, $proType, $proSource, $hint);
        //启用控制器
        //todo: 内部服务 dao数据库
        $c_pp = new tlApp\controller\PostProblem($problem_info);

        return $response->withStatus($c_pp->getStatus());
    });

});

$app->run();

