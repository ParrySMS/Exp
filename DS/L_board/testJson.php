<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-12-24
 * Time: 22:13
 */
require './Http.php';

$size = empty($_GET['size']) ? 8 : $_GET['size'];

$h = new Http();

try {
    $url = 'http://[2001:250:3c00:3479:b17a:23e1:47b9:78e1]/code/chessboard_coverage/public/get_pattern/' . $size;
    echo $h->get($url);

} catch (Exception $e) {
    echo $e->getCode() . ': ' . $e->getMessage();
}
