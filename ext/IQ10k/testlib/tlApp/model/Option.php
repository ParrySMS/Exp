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

    public $key;
    public $is_pic;//0无图文字 1有图url
    public $content;

    /**
     * Option constructor.
     * @param $key
     * @param $content
     * @param $is_pic
     */
    public function __construct($key, $is_pic, $content)
    {
        $this->key = $key;
        $this->is_pic = $is_pic;
        $this->content = $content;
    }


}