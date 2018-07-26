<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-7-25
 * Time: 15:53
 */
require 'PmCheck.php';
require 'Http.php';

try {
    $pm = new PmCheck();

    $problem = $_POST['problem'];
    $option_num = $_POST['option_num'];
//定义空数组
    $options = array();
//转为数组
    $answer = $_POST['answers'];
    $answers = array($answer);

    json_encode($options);

    $hint = $_POST['hint'];
    $classification = $_POST['classification'];
    $language = $_POST['language'];
    $pro_type = $_POST['pro_type'];
    $pro_source = $_POST['pro_source'];

    //获取参数之后 发送请求
    $http = new Http();
    $url = 'http://exp.szer.me/parry/testlib/problem';
    $data = compact('problem','option_num','options','answers',
        'hint','classification','language','pro_type','pro_source');

//    var_dump($data);
    $res = $http->post($url,$data);
    var_dump($res);


}catch (Exception $e){
    echo '错误信息：'.$e->getMessage();
}


//var_dump($_POST);