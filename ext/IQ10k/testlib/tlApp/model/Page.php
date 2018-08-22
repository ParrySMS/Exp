<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-8-22
 * Time: 17:02
 */

namespace tlApp\model;


class Page
{

    public $pre; //流式分页 一直下滑获取新数据 暂时不需要上一页
    public $self; //当前页面请求api的uri
    public $next;

    /**
     * Page constructor.
     * @param $pre
     * @param $self
     * @param $next
     */
    public function __construct($pre, $self, $next)
    {
        $this->pre = $pre;
        $this->self = $self;
        $this->next = $next;
    } //下一个页面的uri


}