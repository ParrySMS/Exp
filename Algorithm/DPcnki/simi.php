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
$line_num1 = sizeof($file1->rows); //标记的行数
$line_num2 = sizeof($file2->rows);

//LCS 拿到Dij
for ($i = 0; $i < $line_num1; $i++) {
    for ($j = 0; $j < $line_num2; $j++) {

        $row1 = $file1->rows[$i];
        $row2 = $file2->rows[$j];
        $simi = $file1->checkSimi($row1, $row2);
        //拿到Dij矩阵
        $mx_d[$i][$j] = $simi > SIMILARITY ? 1 : 0;

    }
}

if (ECHO_DIJ) {
    echo 'Dij:' . PHP_EOL;
    for ($i = 0; $i < $line_num1; $i++) {
        for ($j = 0; $j < $line_num2; $j++) {
            echo "$mx_d[$i][$j]  ";
        }
        echo PHP_EOL;
    }
}

//TODO Repeated-Line-Num