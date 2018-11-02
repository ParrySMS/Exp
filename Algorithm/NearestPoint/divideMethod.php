<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-10-24
 * Time: 14:29
 */


require "./PointSet.php";
require "./Line.php";
//require "./countAll.php";

$mypoint = new PointSet(1500);


$start_time = microtime(true);
$line = $mypoint->getMinLine();
$end_time = microtime(true);
var_dump($line);
echo PHP_EOL;
echo 'time:'. ($end_time - $start_time);
echo PHP_EOL;
echo PHP_EOL;


//countAll($mypoint);
