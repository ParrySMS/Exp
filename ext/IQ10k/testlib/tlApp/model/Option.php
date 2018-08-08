<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-8-6
 * Time: 22:14
 */

namespace tlApp\model;


class Option
{

    public $type; //0无图文字 1有图url
    public $value;

    /**
     * Item constructor.
     * @param $type
     * @param $value
     */
    public function __construct($type, $value)
    {
        $this->type = $type;
        $this->value = $value;
    }


}