<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-12-5
 * Time: 19:44
 */
require 'params.php';
require 'File.php';

$path1 = 'test.txt';
$path2 = 'test2.txt';

$file1 = new File($path1);
$file2 = new File($path2);

$mx_d = [];//Dij的二维数组
$line_num1 = 0; //标记的行数
$line_num2 = 0;
while (!feof($file1->io)) { //文件1和文件2的逐行比较
    $row1 = fgets($file1->io);

    while (!feof($file2->io)) {
        $row2 = fgets($file2->io);

        $simi = $file1->checkSimi($row1, $row2);
        $mx_d[$line_num1][$line_num2] = $simi > SIMILARITY ? 1 : 0;
        //TODO ECHO AND Repeated-Line-Num
    }
}