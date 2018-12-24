<?php


$n = empty($_GET['n']) ? 3 : $_GET['n'];

$size = pow(2, $n);



function echoMainBox($size)
{

    for ($i = 0; $i < $size; $i++) {
        for ($j = 0; $j < $size; $j++) {
            print <<<EOT
    <div class="main-box" id="box-{$i}-{$j}"></div>
EOT;
        }
    }
}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width,height=device-height,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>L型棋盘覆盖问题</title>
    <link href="style.css" type="text/css" rel="stylesheet"/>
    <script src="http://libs.baidu.com/jquery/1.9.0/jquery.min.js" type="text/javascript"></script>
    <script src="./js/Support.js"></script>
    <script src="./js/animation.js" type="text/javascript"></script>
    <script src="./js/main.js" type="text/javascript"></script>
</head>

<body>
<header>
    <h1>L型棋盘覆盖问题</h1>
    <a href="javascript:startCover();" id="bot">开始覆盖</a>
</header>

<div id="main">

    <?php echoMainBox($size) ?>
    <!---->
    <!--    <div class="main-box" id="box-0-0"></div>-->

</div>

</body>
</html>