<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-3-20
 * Time: 14:56
 */
namespace stuApp\model;
class execLog
{
    public $unit; //执行单位’
    public $timestamp;  //时间戳

    /**
     * execLog constructor.
     * @param $unit
     * @param $timestamp
     */
    public function __construct($unit, $timestamp = null)
    {
        //自动填充时间戳
        $timestamp = empty($timestamp)?time():$timestamp;

        $this->unit = $unit;
        $this->timestamp = $timestamp;
    }

}