<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-7-6
 * Time: 23:46
 */

$str = 'An=(10-n*2)^2+(-1)^(n+1)';//运算式
$str = 'An=(2+3)*5+21*(2+3)-(-2)*2^(4-2)/n';

/**
 * ( op )  xxx
 * (() ) op (() )
 *
$str = 'An=2^(2*n-4)+An-1';//递推式

