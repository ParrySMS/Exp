<?php
$days = (time() - strtotime('2017-12-25'))/(24*3600);
$days = intval($days);

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./style.css"/>
</head>

<script type="text/javascript" src="./define.js"></script>
<script type="text/javascript">


    //定义函数：构建要显示的时间日期字符串
    function showTime()
    {
        //创建Date对象
        var today = new Date();
        //分别取出年、月、日、时、分、秒
        var year = today.getFullYear();
        var month = today.getMonth()+1;
        var day = today.getDate();
        var hours = today.getHours();
        var minutes = today.getMinutes();
        var seconds = today.getSeconds();
        //如果是单个数，则前面补0
        month  = month<10  ? "0"+month : month;
        day  = day <10  ? "0"+day : day;
        hours  = hours<10  ? "0"+hours : hours;
        minutes = minutes<10 ? "0"+minutes : minutes;
        seconds = seconds<10 ? "0"+seconds : seconds;

        //构建要输出的字符串
        var str = "当前时间:    " + year+"-"+month+"-"+day+"- "+hours+":"+minutes+":"+seconds;

        //获取id=result的对象
        var obj = document.getElementById("result");
        //将str的内容写入到id=result的<div>中去
        obj.innerHTML = str;
        //延时器
        window.setTimeout("showTime()",1000);
    }
</script>
<style type="text/css">
    #result{
        width:500px;
        border:1px solid #CCCCCC;
        background: #000510;
        margin:50px auto;
        font-size:20px;
        color: #fafff8;
        padding:20px;
    }
</style>

<body onload="showTime()">


<!--大标题-->
<div id="header">
    <h1>实验3-数据库</h1>
</div>

<!--十个菜单-->
<div id="nav">
    <br>
    <a href="1.php">1 显示日期 </a> <br>
    <a href="./2.php">2 最长匹配字符</a><br>
    <a href="./3.php">3 数据库管理页面 </a><br>

</div>

<!--菜单内容-->
<div id="section">
    <h2>1 显示日期</h2><br>
    <p>
        1）	建立一个php页面，打印出现在的时间，同时计算出与2017年圣诞节相差的天数，用适当的方式显示
    </p>

    <div id="result"></div>

    <p>
        <strong>与2017年圣诞节相差的天数: <?php echo $days;?> 天 </strong>
        <br>
    </p>



</div>



</body>

</html>
