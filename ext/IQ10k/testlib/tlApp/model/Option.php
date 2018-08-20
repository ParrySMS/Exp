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
    public $oid; //每一个选项的唯一id 与题目关联
    public $key;
    public $is_pic;//0无图文字 1有图url
    public $content;


    public function __construct(array $data)
    {
        $this->oid = isset($data['id'])?$data['id']:null;
        $this->key = isset($data['key'])?$data['key']:null;
        $this->is_pic = isset($data['is_pic'])?$data['is_pic']:null;
        $this->content = isset($data['content'])?$data['content']:null;
    }


}