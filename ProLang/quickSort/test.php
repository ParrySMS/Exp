<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-4-16
 * Time: 23:45
 */

require "quickSortIter.php";
require "quickSortRec.php";
define('SORT_TIMES', 1000);
define('SIZE', 10);

function rowTable()
{
    unset($row);
    $row = array();

    for ($i = 0; $i < SORT_TIMES; $i++) {
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
    unset($ar);
    $ar = array();

    for ($i = 0; $i < SIZE; $i++) {
        $ar[] = rand(0, SIZE*2);
    }

    $stime = microtime(true);
    $recAr = quickSortR($ar);
    $etime = microtime(true);

    $recTime = 1000 * ($etime - $stime);

    $stime = microtime(true);
    $iterAr = quickSortI($ar);
    $etime = microtime(true);

    $iterTime = 1000 * ($etime - $stime);
//   print_r($recAr);
//   echo "<br/>";
//    print_r($iterAr);
    $row[] = (object)["iter" => $iterTime, "rec" => $recTime];
    return $row;
}


?>

<table border="1">
    <tr>
        <th>Iter/ms</th>
        <th>Rec/ms</th>
    </tr>
    <?php rowTable(); ?>
    <!--    <tr>-->
    <!--        <td>January</td>-->
    <!--        <td>$100</td>-->
    <!--    </tr>-->

</table>
