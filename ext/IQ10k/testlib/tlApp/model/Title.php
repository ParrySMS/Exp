<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-8-6
 * Time: 23:43
 */

namespace tlApp\model;


class Title
{
    public $text;
    public $pic = [];

    /**
     * Title constructor.
     * @param $text
     * @param array $pic
     */
    public function __construct($text, array $pic)
    {
        $this->text = $text;
        $this->pic = $pic;
    }


}