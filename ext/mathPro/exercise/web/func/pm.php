<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-10
 * Time: 16:48
 */

/**
 * @param $string
 * @param int $min_len
 * @param int $max_len
 * @throws Exception
 */
function lenCheck($string,int $min_len,int $max_len)
{
    $len = mb_strlen(trim($string));

    if($len<$min_len || $len>$max_len) {
        throw new Exception('len error');
    }

//    return ($len>=$min_len && $len<=$max_len);
}


/**
 * @param $string
 * @throws Exception
 */
function numChar($string)
{
    //todo 只能是数字或者字母

    //todo 不满足就报错
    if( false ) {
        throw new Exception('type error：num or char only');
    }

}


//todo 没有中文 没有空格
function noZH($string){}

function noSP($string){}

