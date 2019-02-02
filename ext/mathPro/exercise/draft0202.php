<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-2
 * Time: 15:29
 */


$ter = fopen('php://stdin','r');

$n = (int)fgets($ter);

echo 'funcFor:'.funcFor($n).PHP_EOL;
echo 'funcWhile:'.funcWhile($n).PHP_EOL;


//$count = 0;
//for ($count = 0 ;$n != 1;$count++) {
//
//    if ($n % 2 == 1) {
//        $n = 3 * $n + 1;
//    } else {
//        $n = $n / 2;
//    }
//}
//echo $count;


fclose($ter);




function funcFor(int $n):int
{
    for ($count = 0 ;$n != 1;$count++) {

        if ($n % 2 == 1) {
            $n = 3 * $n + 1;
        } else {
            $n = $n / 2;
        }
    }

    return $count;
}

function funcWhile(int $n):int
{
    $count = 0;

    while($n != 1) {

        if ($n % 2 == 1) {
            $n = 3 * $n + 1;
        } else {
            $n = $n / 2;
        }
    }

    return $count;
}



