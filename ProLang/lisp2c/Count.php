<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-5-29
 * Time: 10:29
 */

class Count
{

    public $funcList = ['add', 'sub', 'mul', 'div', 'mod', 'gt', 'lt', 'equ'];
    public $boolList = ['FunAnd', 'FunOr', 'FunNot'];
    public $res;
    public $bool_params = ['T', 'F'];

    /**
     * Count constructor.
     * @param $funcName
     */
    public function __construct($funcName, $p1, $p2)
    {
        if (!in_array($funcName, $this->funcList) && !in_array($funcName, $this->boolList)) {
            throw new Exception("funcName is not in the list:]", 200);
        }

        if (!is_numeric($p1) && !in_array($p1, $this->bool_params) && $p1 != 'e') {
            var_dump($p1);
            echo '<br/>';
            throw new Exception("params1 is not allow <br/>", 200);
        }

        if (!isset($p2)&&!is_numeric($p2) && !in_array($p1, $this->bool_params) && $p2 != 'e') {
            var_dump($p2);
            echo '<br/>';
            throw new Exception("params2 is not alllow <br/>", 200);
        }


        $this->res = $this->$funcName($p1, $p2);
    }


    public function add($p1, $p2)
    {

        return $this->isIntParams($p1, $p2) ? $p1 + $p2 : 'e';
    }

    public function sub($p1, $p2)
    {
        return $this->isIntParams($p1, $p2) ? $p1 - $p2 : 'e';

    }

    public function mul($p1, $p2)
    {

        return $this->isIntParams($p1, $p2) ? $p1 * $p2 : 'e';

    }

    public function div($p1, $p2)
    {
        //除0错误
        if ($p2 == 0) {
            return 'e';
        }
        return $this->isIntParams($p1, $p2) ? $p1 / $p2 : 'e';
    }

    public function mod($p1, $p2)
    {
        //除0错误
        if ($p2 == 0) {
            return 'e';
        }
        return $this->isIntParams($p1, $p2) ? $p1 % $p2 : 'e';
    }

    public function gt($p1, $p2)
    {
        if (!$this->isIntParams($p1, $p2)) {
            return 'e';
        }

        return $p1 > $p2 ? 'T' : 'F';

    }

    public function lt($p1, $p2)
    {
        if (!$this->isIntParams($p1, $p2)) {
            return 'e';
        }
        return $p1 < $p2 ? 'T' : 'F';

    }

    public function equ($p1, $p2)
    {
        if (!$this->isIntParams($p1, $p2)) {
            return 'e';
        }

        return $p1 == $p2 ? 'T' : 'F';

    }

    public function FunAnd($p1, $p2)
    {
        if (!$this->isBoolParams($p1, $p2)) {
            return 'e';
        }

        $p = [$p1, $p2];
        return in_array('F', $p) ? 'F' : 'T';
    }

    public function FunOr($p1, $p2)
    {
        if (!$this->isBoolParams($p1, $p2)) {
            return 'e';
        }

        $p = [$p1, $p2];
        return in_array('T', $p) ? 'T' : 'F';
    }

    public function FunNot($p,$p2)
    {
        if (!$this->isBoolParams($p, 'T')) {
            return 'e';
        }
        return $p == 'F' ? 'T' : 'F';
    }


    public function isIntParams($p1, $p2)
    {
        return (is_numeric($p1) && is_numeric($p2)) ? true : false;
    }


    public function isBoolParams($p1, $p2)
    {
        return (in_array($p1, $this->bool_params)
            && in_array($p2, $this->bool_params)) ? true : false;
    }

}
