<?php

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./style.css"/>
</head>

<script type="text/javascript" src="./define.js"></script>

<body>


<!--大标题-->
<div id="header">
    <h1>实验3-数据库</h1>
</div>

<!--十个菜单-->
<div id="nav">
    <br>
    <a href="./1.php">1 显示日期 </a> <br>
    <a href="./2.php">2 最长匹配字符</a><br>
    <a href="./3.php">3 数据库管理页面 </a><br>
</div>

<!--菜单内容-->
<h2>3 数据库管理页面</h2><br>

<div id="section">

    <p>
        2） 建立一个用户界面，对用户输入的两行字符串进行比较，取出最长匹配字符串并显示出来。注意用户界面的美观性
    </p>

    <h3>请输入两个字符串</h3><br>

    <form method="get" action="2.php">
        字符串1 :
        <input type="text" name="str1" placeholder=" <?php echo $str1?>"/>
        <br>
        <br>
        <br>
        字符串2 :
        <input type="text" name="str2" placeholder=" <?php echo $str2?>"/>
        <br>
        <br>


        <input type="submit" value="开始匹配" name="submitBtn" />
    </form>


    <br>
    <h3>匹配结果：</h3><br>

    <?php echo $res; ?>
</div>


</body>

</html>
