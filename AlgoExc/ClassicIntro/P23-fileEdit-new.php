<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-1-24
 * Time: 0:31
 *
 * 已知该目录下有一个名为 math.txt的文件，内容如下所示：
3*2=
1*23+2=
34+21-2=
45/5+21=
2*(3+21)=
7*89=
7+8*9=
20+2*2=
 *
 * 现在想给每一行算式的末尾加上 “____" 四个下划线（不包含引号）,请用程序完成这项操作,将添加下划线后的文本内容存到名为 math1.txt 的文件里。
 *
 */

define('READ_FILE_NAME','./math.txt');
define('WRITE_FILE_NAME','./math1.txt');
define('ADD_STRING','____'.PHP_EOL);

if(!file_exists(READ_FILE_NAME)){
    echo 'no files'.PHP_EOL;
    return;
}

$fr = fopen(READ_FILE_NAME,'r');
$fw = fopen(WRITE_FILE_NAME,'w+');

while(!feof($fr)){ //判断文件指针是否到达末尾
    $line = fgets($fr);// 每执行一次，文件指针就向后移动

//    echo $line;//输出获取到的内容

    $line = str_replace(PHP_EOL,ADD_STRING,$line,$count);

    if($count==0){//没有换行符
        $line = $line.ADD_STRING;
    }
//    echo $line;

    fwrite($fw,$line);

}

fclose($fr);
fclose($fw);