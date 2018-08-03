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


    //todo 获取某条题目的信息
    $this->get('/{pid}',function($request, $response, array $args){

    });

    //todo 获取某页的题目信息（流式分页）
    $this->post('', function ($request, $response) {

    });

    //插入一条题目
    $this->post('', function ($request, $response) {
        //接收数据
//        $problem = isset($request->getParsedBody()['problem']) ? $request->getParsedBody()['problem'] : null;
//        //todo 临时处理图片才加入的option_num 后面要去掉
//        $option_num = isset($request->getParsedBody()['option_num']) ? $request->getParsedBody()['option_num'] : null;
//        $options = isset($request->getParsedBody()['options']) ? $request->getParsedBody()['options'] : null;
//        $answers = isset($request->getParsedBody()['answers']) ? $request->getParsedBody()['answers'] : null;
//        $language = isset($request->getParsedBody()['language']) ? $request->getParsedBody()['language'] : null;
//        $classification = isset($request->getParsedBody()['classification']) ? $request->getParsedBody()['classification'] : null;
//        $pro_type = isset($request->getParsedBody()['pro_type']) ? $request->getParsedBody()['pro_type'] : null;
////        $pro_source = isset($request->getParsedBody()['pro_source']) ? $request->getParsedBody()['pro_source'] : null;
//        $pro_source = 'diagram';
//        $hint = isset($request->getParsedBody()['hint']) ? $request->getParsedBody()['hint'] : null;
//
//        //合并
//        $problem_info = compact('problem', 'option_num', 'options', 'answers', 'language', 'classification', 'pro_type', 'pro_source', 'hint');
//        //启用控制器
        $c_pp = new tlApp\controller\PostProblem($request->getParsedBody());
        return $response->withStatus($c_pp->getStatus());
    });

    //编辑某题目
    $this->post('/{pid}',function($request, $response, array $args){
        $pid = (!empty($args['pid'])) ? $args['pid'] : null;
        $problem = isset($request->getParsedBody()['problem']) ? $request->getParsedBody()['problem'] : null;
        $options = isset($request->getParsedBody()['options']) ? $request->getParsedBody()['options'] : null;
        $answers = isset($request->getParsedBody()['answers']) ? $request->getParsedBody()['answers'] : null;
        $language = isset($request->getParsedBody()['language']) ? $request->getParsedBody()['language'] : null;
        $classification = isset($request->getParsedBody()['classification']) ? $request->getParsedBody()['classification'] : null;
        $pro_type = isset($request->getParsedBody()['pro_type']) ? $request->getParsedBody()['pro_type'] : null;
        $pro_source = isset($request->getParsedBody()['pro_source']) ? $request->getParsedBody()['pro_source'] : null;
        $hint = isset($request->getParsedBody()['hint']) ? $request->getParsedBody()['hint'] : null;

        //这个info 多了一个pid参数
        $problem_info = compact('pid','problem',  'options', 'answers', 'language', 'classification', 'pro_type', 'pro_source', 'hint');
        $c_ep = new tlApp\controller\EditProblem($problem_info);
        return $response->withStatus($c_ep->getStatus());
    });



});

$app->run();

