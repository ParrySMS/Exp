<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-1-4
 * Time: 16:07
 */
require "Http.php";
use IQ10K\Http;

$h = new Http();

try {
    for ($i = 0; $i < 2000; $i++) {
    $url = '';
    $res = $h->get($url,[],false);
    echo json_encode($res);
    }
}catch (Exception $e){
    echo $e->getMessage();
}