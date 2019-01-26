<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-1-26
 * Time: 18:04
 */

require 'P15E1.5.6-Exc10.php';

echo '1-1: 3 4 5,avg: '.average(3,4,5).PHP_EOL;

echo '1-2: f->c f=96,c: '.temperature(96).PHP_EOL;

echo '1-3: sum 1 to 10,sum: '.sumN(10).PHP_EOL;

echo '1-4: angle:45 '.PHP_EOL;
sincos(45);

echo '1-5: distance (3,4) -- (4,5):'.distance(3.0,4.0,4.0,5.0).PHP_EOL;

echo '1-6: odd1 456:'.PHP_EOL;
odd1(456);

echo '1-6: odd2 456:'.PHP_EOL;
odd2(456);

echo '1-7: discount 2 unit:'.discount(2).PHP_EOL;
echo '1-7: discount 4 unit:'.discount(4).PHP_EOL;

echo '1-8: abs 3.1415926:'.absNum(3.1415926).PHP_EOL;
echo '1-8: abs -3.1415926:'.absNum(-3.1415926).PHP_EOL;

echo '1-9: Rt Tri 5 12 13:'.PHP_EOL;
triangle1(5,12 ,13);
triangle2(5,12 ,13);

echo '1-9: Rt Tri 3 4 4:'.PHP_EOL;
triangle1(3,4,4);
triangle2(3,4 ,4);

echo '1-10: year 1884:'.PHP_EOL;;
year1(1884);
year2(1884);

echo '1-10: year 2000:'.PHP_EOL;;
year1(2000);
year2(2000);

echo '1-10: year 2019:'.PHP_EOL;;
year1(2019);
year2(2019);
