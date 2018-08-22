<?php

require './vendor/autoload.php';

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Medoo\Medoo;

//跨域设置 上线后应关闭
//header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Methods:POST,GET');
header('Content-type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Shanghai');

//todo:debug模式 记得上线前关掉
$config = [
    'settings' => [
        'displayErrorDetails' => true
    ],
];

$app = new \Slim\App($config);

//自动遍历参数集
//todo 所有路由的登录鉴权处理 记得在pmChcek 里面加
$pm = new \tlApp\common\PmCheck();

//路由处理


//题目路由组
$app->group('/problem', function () {


    // 获取某条题目的信息
    $this->get('/{pid}',function($request, $response, array $args){
        $pid = isset($args['pid'])?$args['pid']:null;
        $c_gp = new tlApp\controller\GetProblem();
        $c_gp->withPid($pid);
        return $response->withStatus($c_gp->getStatus());
    });

    //todo 获取某页的题目信息（流式分页）
    $this->get('', function ($request, $response) {
        //todo 输入source来源参数 输入last_id
        $c_gp = new tlApp\controller\GetProblem();
        $c_gp->withPage($request->getParsedBody());

    });

    // 插入一条题目  先暂时不管图片处理
    $this->post('', function ($request, $response) {
        $c_pp = new tlApp\controller\PostProblem($request->getParsedBody());
        return $response->withStatus($c_pp->getStatus());
    });

    // 编辑某题目
    $this->post('/{pid}',function($request, $response, array $args){
//        var_dump($request->getParsedBody());
        $body = array_merge($request->getParsedBody(),$args);
        $c_ep = new tlApp\controller\EditProblem($body);
        return $response->withStatus($c_ep->getStatus());
    });

    //todo 搜索

    //删除
    $this->post('/delete/{pid}',function($request, $response, array $args){
        $pid = isset($args['pid'])?$args['pid']:null;
        $c_dp = new tlApp\controller\DeleteProblem();
        $c_dp->withPid($pid);
        return $response->withStatus($c_dp->getStatus());
    });

    //todo 添加评论 还差dao
    $this->post('/comment/{pid}',function($request, $response, array $args){
        $body = array_merge($request->getParsedBody(),$args);
        $c_ct = new tlApp\controller\Comment();
        return $response->withStatus($c_ct->getStatus());
    });

    //todo 查看有评论的题

});

$app->run();

