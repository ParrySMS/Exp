<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-4-17
 * Time: 2:18
 */

require "hannoRec.php";
require "hannoIter.php";



define('TIMES', 10);
define('NUM', 100);

function rowTable()
{
    unset($row);
    $row = array();

    for ($i = 0; $i < TIMES; $i++) {
    $row = getSortRow($row);
    }

    foreach ($row as $r) {
        print <<< TR
 <tr>
       <td>$r->iter</td>
       <td>$r->rec</td>
    </tr>
TR;
    }
}

function getSortRow(array $row)
{
    $num = NUM;
    $counter= 0;
    $stime = microtime(true);
    hanIter($num, $num, 'A', 'B', 'C', $counter);
    $etime = microtime(true);
    $iterTime = 1000 * ($etime - $stime);


    $counter = 0;
    $num = NUM;
    $stime = microtime(true);
    hanRec($num, 'A', 'B', 'C', $counter);
    $etime = microtime(true);
    $recTime = 1000 * ($etime - $stime);

    $row[] = (object)["iter" => $iterTime, "rec" => $recTime];
    return $row;
}


?>

<table border="1">
    <tr>
        <th>迭代 Iter/ms</th>
        <th>递归 Rec/ms</th>
    </tr>
    <?php rowTable(); ?>
    <!--    <tr>-->
    <!--        <td>January</td>-->
    <!--        <td>$100</td>-->
    <!--    </tr>-->

</table>

