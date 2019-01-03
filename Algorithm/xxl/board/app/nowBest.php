<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-1-3
 * Time: 0:43
 */


require '../Http.php';
require './Board.php';
require './Box.php';

use xxl\Http;
use xxl\Board;

$h = new Http(false);
$size = $_GET['size'] ?? 6;

try{
    if(empty($size)){
        throw new Exception('null size',500);
    }

    $board = new Board($size);
    $board->echoBoard();
    $score = $board->clearAndGetScore();
    $board->echoBoard();
    echo "score:$score".PHP_EOL;
    echo "start:".PHP_EOL;
    $add_score = $board->loop4BestOnce();
    $board->echoBoard();
    $score += $add_score;
    echo "score:$score";




}catch (Exception $e){
    $h->status($e->getCode());
    echo $e->getMessage();
}

