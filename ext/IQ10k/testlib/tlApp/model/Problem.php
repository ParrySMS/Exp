<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-8-6
 * Time: 22:16
 */

namespace tlApp\model;


class Problem
{
    public $pid; //题目唯一id
    public $title; //题目标题
    public $title_pic; //题目图片 可能为空
//    public $options = []; //选项的对象数组 对象内容参见 Option对象

    //前端关键字问题 替换
    public $optionAr = []; //选项的对象数组 对象内容参见 Option对象
    public $hint; //提示文字
    public $answers = []; //答案的索引数组
    public $language; //语言类别
    public $classification; //题目类目
    public $pro_type; //题型
    public $pro_source; //题目来源
    public $comments; //审核的评论意见
    public $edit_time; //最后一次编辑时间
    public $total_edit; //编辑次数


    public function __construct(array $options)
    {

        $this->pid = isset($options['id']) ? $options['id'] : null;
        $this->title = isset($options['title']) ? $options['title'] : null;
        $this->title_pic = isset($options['title_pic']) ? $options['title_pic'] : null;
//        $this->options = isset($options['options']) ? $options['options'] : [];
        //前端关键字问题 替换
        $this->optionAr = isset($options['options']) ? $options['options'] : [];
        $this->answers = isset($options['answers']) ? $options['answers'] : [];
        $this->language = isset($options['language']) ? $options['language'] : null;
        $this->classification = isset($options['classification']) ? $options['classification'] : null;
        $this->pro_type = isset($options['pro_type']) ? $options['pro_type'] : null;
        $this->pro_source = isset($options['pro_source']) ? $options['pro_source'] : null;
        $this->edit_time = isset($options['edit_time']) ? $options['edit_time'] : null;
        $this->total_edit = isset($options['total_edit']) ? $options['total_edit'] : null;

        $this->hint = isset($options['hint']) ? $options['hint'] : null;
        $this->comments = isset($options['comments']) ? $options['comments'] : null;


    }


}