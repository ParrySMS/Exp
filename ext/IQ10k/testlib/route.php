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

//todo 导入数据 展示题目图片 展示选项图片
//todo 机器处理 转成英文

//获取某个分类下有效的题目id数组
$app->get('/pids', function ($request, $response) {
//    xxxxxxxxxx/pids?source={urlencode（必选来源参数pro_source)}&last_id=可选参数
    $c_gp = new tlApp\controller\GetProblem();
    $c_gp->idList($request->getQueryParams());
    return $response->withStatus($c_gp->getStatus());
});


//题目路由组
$app->group('/problem', function () {


    // 获取某条题目的信息
    $this->get('/{pid}', function ($request, $response, array $args) {
        $pid = isset($args['pid']) ? $args['pid'] : null;
        $c_gp = new tlApp\controller\GetProblem();
        $c_gp->withPid($pid);
        return $response->withStatus($c_gp->getStatus());
    });


    //todo 新建 source表 原本Pro表的source 改成source_id
    //todo 取题目要连表 入/编辑题目要查souce然后得id 做source限制 页面改成来源选项
    //todo 要加多一个添加来源的接口
    //todo 要做一个获取各个来源的列表的接口 取遍source表即可

    //TODO emmm 但是现在数据还没录完处理完，最后再来拆表吧，先用这个很low的方法来解决一下
    $this->get('/source/', function ($request, $response, array $args) {
        print_r(SOURCE_FILE_JSON);
        return $response->withStatus(200);
    });



    //获取某页的题目信息（流式分页）
    $this->get('', function ($request, $response) {
//        xxxxxxxxxx?source={urlencode（必选来源参数pro_source)}&last_id=可选参数
        $c_gp = new tlApp\controller\GetProblem();
        $c_gp->withFlow($request->getQueryParams());
        return $response->withStatus($c_gp->getStatus());

    });

    //获取全部的题目信息（不分页）
    $this->get('/all/', function ($request, $response) {
//        xxxxxxxxxx?source={urlencode（必选来源参数pro_source)}
        $c_gp = new tlApp\controller\GetProblem();
        $c_gp->withAll($request->getQueryParams());
        return $response->withStatus($c_gp->getStatus());
    });

    // 插入一条题目  先暂时不管图片处理
    $this->post('', function ($request, $response) {
        $c_pp = new tlApp\controller\PostProblem($request->getParsedBody());
        return $response->withStatus($c_pp->getStatus());
    });

    // 编辑某题目
    $this->post('/{pid}', function ($request, $response, array $args) {
//        var_dump($request->getParsedBody());
        $body = array_merge($request->getParsedBody(), $args);
        $c_ep = new tlApp\controller\EditProblem($body);
        return $response->withStatus($c_ep->getStatus());
    });
//
    // 搜索
    $this->get('/search/', function ($request, $response, array $args) {
//        xxxxxxxxxx/search/?word=xxxxx
        $word = isset($request->getQueryParams()['word']) ? $request->getQueryParams()['word'] : null;
        $c_gp = new tlApp\controller\GetProblem();
        $c_gp->search($word);
        return $response->withStatus($c_gp->getStatus());
    });

    //删除
    $this->post('/delete/{pid}', function ($request, $response, array $args) {
        $pid = isset($args['pid']) ? $args['pid'] : null;
        $c_dp = new tlApp\controller\DeleteProblem();
        $c_dp->withPid($pid);
        return $response->withStatus($c_dp->getStatus());
    });

    //添加评论
    $this->post('/comment/{pid}', function ($request, $response, array $args) {
        $body = array_merge($request->getParsedBody(), $args);
        $c_ct = new tlApp\controller\Comment();
        $c_ct->add($body);
        return $response->withStatus($c_ct->getStatus());
    });

    //查看有评论的题
    $this->get('/comment/', function ($request, $response) {
        // 不允许0
        $last_id = empty($query['last_id']) ? null : $query['last_id'];
        $c_gp = new tlApp\controller\GetProblem();
        $c_gp->hasComment($last_id);
        return $response->withStatus($c_gp->getStatus());
    });


});

//翻译处理路由组
$app->group('/trans',function (){

    // 获取某条题目的信息
    $this->get('/{pid}', function ($request, $response, array $args) {
        $pid = isset($args['pid']) ? $args['pid'] : null;
        $c_gp = new tlApp\controller\GetProblem();
        $c_gp->withPid($pid,true);
        return $response->withStatus($c_gp->getStatus());
    });

    //需有翻译的题目
    $this->get('/problem/', function ($request, $response, array $args) {
    //    xxxxxxxxxx?source={urlencode（必选来源参数pro_source)}&last_id=可选参数
        $c_gp = new tlApp\controller\GetProblem();
        $c_gp->withFlow($request->getQueryParams(),true);
        return $response->withStatus($c_gp->getStatus());
    });


});


$app->run();

