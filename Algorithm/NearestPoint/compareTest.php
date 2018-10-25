<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-10-24
 * Time: 21:50
 */

require "./countAll.php";
require "./PointSet.php";
require "./Line.php";


try {

for($i=1000;$i<10000;$i=$i+100){
    exc($i);
}

    echo "finish all";
    echo PHP_EOL;

} catch (Exception $e) {
    echo $e->getMessage();
    echo PHP_EOL;
}


/**
 * @param $size
 * @throws Exception
 */
function exc($size)
{

    //每个规模-每次2个样本

    //divide
    $pointSet = new PointSet($size);

    $start_time = microtime(true);

    $pointSet->getMinLine();

    $end_time = microtime(true);

    $exc_time = $end_time - $start_time;

    echo 'divide_time:' . $exc_time;
    $pointSet->exc_log('divide', $size, 0, $exc_time);

    //count all
    $exc_time = countAll($pointSet);
    $pointSet->exc_log('countAll', $size, 0, $exc_time);

}