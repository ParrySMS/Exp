<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-1-3
 * Time: 0:43
 */


require '../Http.php';
use xxl\Http;

$h = new Http(false);
$size = $_GET['size'] ?? null;

try{
    if(empty($size)){
        throw new Exception('null_size',500);
    }

    getMarksData



}catch (Exception $e){
    echo $e->getMessage();
    $h->status($e->getCode());
}

