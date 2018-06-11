<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-5-29
 * Time: 10:29
 */

class Count
{

    public $funcList = ['add', 'sub', 'mul', 'div', 'mod'];
    public $res;

    /**
     * Count constructor.
     * @param $funcName
     */
    public function __construct($funcName, $p1, $p2)
    {
        if (!is_numeric($p1) && $p1 != 'e') {
            var_dump($p1);
            echo '<br/>';
            throw new Exception("params1 is not numeric <br/>", 200);
        }

        if (!is_numeric($p2) && $p2 != 'e') {
            var_dump($p2);
            echo '<br/>';
            throw new Exception("params2 is not numeric <br/>", 200);
        }

        if (!in_array($funcName, $this->funcList)) {
            throw new Exception("funcName is not in the list: funcName=$funcName", 200);
        }

        $this->res = $this->$funcName($p1, $p2);
    }


    public function add($p1, $p2)
    {
        if ($p1 === 'e' || $p2 === 'e') {
            return 'e';
        }

        return $p1 + $p2;
    }

    public function sub($p1, $p2)
    {
        if ($p1 === 'e' || $p2 === 'e') {
            return 'e';
        }

        return $p1 - $p2;
    }

    public function mul($p1, $p2)
    {
        if ($p1 === 'e' || $p2 === 'e') {

            return 'e';
        }


        return $p1 * $p2;

    }

    public function div($p1, $p2)
    {
        if ($p1 === 'e' || $p2 === 'e') {
            return 'e';
        }


        //除0错误
        if ($p2 == 0) {
            return 'e';
        }

        return $p1 / $p2;

    }

    public function mod($p1, $p2)
    {
        if ($p1 === 'e' || $p2 === 'e') {

            return 'e';
        }

        //除0错误
        if ($p2 == 0) {
            return 'e';
        }

        return $p1 % $p2;
    }


}