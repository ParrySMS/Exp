<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-3-30
 * Time: 10:16
 */

namespace stuApp\common;


class paramsCheckSort
{
    private $field;
    private $sortWay;

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return mixed
     */
    public function getSortWay()
    {
        return $this->sortWay;
    }

    /**
     * paramsCheckSort constructor.
     * @param $field
     * @param $sortOption
     */
    public function __construct($field, $sortOption)
    {
        $safe = new Safe();


        if(empty($field)){
            throw new \Exception("field null $field",400);
        }

        if(!isset($sortOption)){
            throw new \Exception("sortOption null $sortOption",400);
        }


        $field = $safe->str_check($field);
        //操作数
        $sortOption = $safe->int_check($sortOption);
        //0 降序 1升序
        $sortRegion = ["DESC","ASC"];
        //确认参数
        if(empty($sortRegion[$sortOption])){
            throw new \Exception("sortWay error",400);
        }

        $sortWay = $sortRegion[$sortOption];

        $this->field = $field;
        $this->sortWay = $sortWay;
    }


}