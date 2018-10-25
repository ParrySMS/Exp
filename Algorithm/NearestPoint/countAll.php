<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-10-23
 * Time: 23:30
 */

require "./PointSet.php";
require "./Line.php";

define("BIG_DIS", 99999);

countAll(new PointSet());

function countAll(PointSet $mypoint)
{
//    $mypoint = new Point();

    $size = sizeof($mypoint->set);

    $min_dis = BIG_DIS;//first give a big data

    $start_time = microtime(true);
    for ($i = 0; $i < $size; $i++) {//get point

        for ($j = 0; $j < $size; $j++) {//count others point

            if ($j == $i) {//no need to count itself
                continue;
            }

            $dis = $mypoint->disInSet($i, $j);
            if ($dis < $min_dis) {
                $min_dis = $dis;
                $line = new Line($i, $mypoint->set[$i], $j, $mypoint->set[$j], $dis);
            }
        }
    }
    $end_time = microtime(true);
    var_dump($line);
//    echo PHP_EOL;
    $exc_time = $end_time - $start_time;

    echo 'countALL time:' . $exc_time;
//    echo PHP_EOL;

    return $exc_time;
}