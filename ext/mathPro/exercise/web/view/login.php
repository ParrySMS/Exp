<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-10
 * Time: 16:36
 */
require '../func/pm.php';
require '../func/check.php';
require '../func/crypy.php';
require '../db/Db.php';
require '../db/User.php';
require '../config/params.php';
require '../config/db.php';
require '../config/Medoo.php';


try {


//todo 获取参数
    $acccout = isset($_POST['account']) ? $_POST['account'] : null;
    $password = $_POST['password'] ?? null;
    $res = 'FAILED';
    $next_url = '';


//todo 参数校验
    $usercheck = new UserCheck($acccout,$password);


//todo 验证账号密码

    $uid = checkDBHas($acccout,$password);
    $res = 'SUCCESS';

//todo 返回结果
//    $next_url = "./new_quiz.php?uid=$uid";
    $next_url = "./grade.php?uid=$uid";

}catch (Exception $e){
//    echo 'INFO:'.$e->getMessage().'<br/>';

    $res = DEBUG_MODE ? 'FAILED:'.$e->getMessage(): ERROR_INFO;

}


function jump($res,int $second ,string $url){
    if($res == 'SUCCESS'){
        echo  '<meta http-equiv="refresh" content="'.$second.';url=\''.$url.'\'">';
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php
    jump($res,0,$next_url);
    ?>
    <title>登录页面</title>
    <link rel="stylesheet" type="text/css" href="../css/login.css"/>
</head>
<body>
<div class="outer-wrap">
    <div class="login-panel">

        <form class="login-form" action="./login.php" method="post">
            <h3>WELCOME TO MATH TEST </h3>
            <hr/>
            <h2><?php echo $res ?></h2><br/>
            <p>ACCOUNT</p>
            <input type="text" name="account" value="admin" />
            <p>PASSWORD</p>
            <input type="password" name="password" placeholder="please input password" />
            <input class="login-submit-input" type="submit" name="submit" value="LOGIN" />
        </form>


    </div>
</div>
</body>
</html>
