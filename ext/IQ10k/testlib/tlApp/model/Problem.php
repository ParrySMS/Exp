<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-8-6
 * Time: 22:16
 */

namespace tlApp\model;


//todo 新增之后返回对象
class Problem
{
    public $pid;
    public $title;
    public $title_pic;
    public $options = [];
    public $answers = [];
    public $language;
    public $classification;
    public $pro_type;
    public $pro_source;
    public $edit_time;
    public $total_edit;


    public function __construct(array $options)
    {

        $this->pid = isset($options['id']) ? $options['id'] : null;
        $this->title = isset($options['title']) ? $options['title'] : null;
        $this->title_pic = isset($options['title_pic']) ? $options['title_pic'] : null;
        $this->options = isset($options['options']) ? $options['options'] : [];
        $this->answers = isset($options['answers']) ? $options['answers'] : [];
        $this->language = isset($options['language']) ? $options['language'] : null;
        $this->classification = isset($options['classification']) ? $options['classification'] : null;
        $this->pro_type = isset($options['pro_type']) ? $options['pro_type'] : null;
        $this->pro_source = isset($options['pro_source']) ? $options['pro_source'] : null;
        $this->edit_time = isset($options['edit_time']) ? $options['edit_time'] : null;
        $this->total_edit = isset($options['total_edit']) ? $options['total_edit'] : null;
    }


}