<?php

$str1 = isset($_GET['str1']) ? $_GET['str1'] : '';
$str2 = isset($_GET['str2']) ? $_GET['str2'] : '';

if (empty($str1) || empty($str2)) {
    $res = '输入字符空，暂无结果。';
} else {
    $len1 = strlen($str1);
    $len2 = strlen($str2);

    $max = 0;
    for ($i = 0; $i < $len1; $i++) {
        for ($j = 0; $j < $len2; $j++) {
            $t = '';

            $i_index = $i;
            $j_index = $j;

            while ($i_index < $len1 && $j_index < $len2 && $str1[$i_index] == $str2[$j_index]) {
                $t = $t . $str1[$i_index];
                $i_index ++;
                $j_index ++;
            }

            if (strlen($t) > $max) {
                    $max = strlen($t);
                    $res = $t;
            }
        }
    }
}


if (is_null($str1) || is_null($str2)) {
    $res = '输入字符空，暂无结果。';
}
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
    <a href="1.php">1 显示日期 </a> <br>
    <a href="./2.php">2 最长匹配字符</a><br>
    <a href="./3.php">3 数据库管理页面 </a><br>
</div>

<!--菜单内容-->
<div id="section">
    <h2>2 最长匹配字符</h2><br>

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
