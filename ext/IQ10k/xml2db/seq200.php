<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-11-30
 * Time: 21:28
 */

require './Http.php';
require './config/database_info.php';
require './config/params.php';
require './config/Medoo.php';
require './Seq.php';


$key = isset($_GET['secret_key']) ? $_GET['secret_key'] : null;

$http = new Http();

try {

    if (empty($key)) {
        throw new Exception("secret_key null", 400);
    }

    if ($key !== SECRET_KEY){
        throw new Exception("secret_key error", 400);
    }



} catch (Exception $e) {
    echo $e->getMessage();
    $http->status($e->getCode());
}