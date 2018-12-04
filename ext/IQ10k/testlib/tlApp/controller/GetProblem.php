<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-8-3
 * Time: 17:24
 */

namespace tlApp\controller;

use \Exception;
use tlApp\common\LogicPmCheck;
use tlApp\service\Problem;



class GetProblem extends BaseController
{
    private $pm;
    private $pro;

    /**
     * GetProblem constructor.
     */
    public function __construct()
    {
        //日志记录
        parent::actionLog();
        //参数逻辑检查
        $this->pm = new LogicPmCheck();
        $this->pro = new Problem();

    }

    /** 获取单条
     * @param bool $trans 是否带上翻译信息
     * @param $pid
     */
    public function withPid($pid,$trans = false)
    {
        try {
            //参数逻辑检查
            $pid = $this->pm->pidCheck($pid);

            $this->getProblemById($pid,$trans);

        } catch (Exception $e) {
            $this->error($e);
        }
    }

    /** todo 获取以及相邻id 还没开始改 底下的函数还是旧的 出去一下
     * @param bool $trans 是否带上翻译信息
     * @param $pid
     */
    public function withPidNear($pid,$trans = false)
    {
        try {
            //参数逻辑检查
            $pid = $this->pm->pidCheck($pid);

            $this->getProblemById($pid,$trans);

        } catch (Exception $e) {
            $this->error($e);
        }
    }

    /** 获取页面 流式分页
     * @param bool trans 是否需要带上翻译数据
     * @param array $query
     */
    public function withFlow(array $query,$trans = false)
    {

        try {
            //参数逻辑检查
            $this->pm->pageCheck($query);
            $source = $this->pm->getSource();
            $last_id = $this->pm->getLastId();

            $this->getProblemByFlow($last_id, $source,$trans);

        } catch (Exception $e) {
            $this->error($e);
        }
    }

    /** 获取页面 不分页
     * @param array $query
     */
    public function withAll(array $query)
    {

        try {
            //参数逻辑检查
            $this->pm->pageCheck($query);
            $source = $this->pm->getSource();

            $this->getAllProblem($source);

        } catch (Exception $e) {
            $this->error($e);
        }
    }

    /** 获取评论题目页面
     * @param $last_id
     */
    public function hasComment($last_id)
    {
        try {
            //可选参数
            $last_id = $this->pm->lastIdCheck($last_id);

            $this->getComProByFlow($last_id);

        } catch (Exception $e) {
            $this->error($e);
        }
    }


    /** 获取搜索结果页面
     * @param $word
     */
    public function search($word)
    {
        try {
            //可选参数
            $word = $this->pm->wordCheck($word);

            $this->getSearch($word);

        } catch (Exception $e) {
            $this->error($e);
        }

    }


    /** 获取题目id集合
     * @param array $query
     */
    public function idList(array $query){
        try {
            //可选参数
            //参数逻辑检查
            $this->pm->pageCheck($query);
            $source = $this->pm->getSource();
            $last_id = $this->pm->getLastId();

            $this->getIds($last_id,$source);

        } catch (Exception $e) {
            $this->error($e);
        }
    }

    /** 获取某个具体的题目详情
     * @param $pid
     * @param bool $trans 是否带上翻译信息
     * @throws Exception
     */
    private function getProblemById($pid,$trans)
    {
        if($trans){
            $this->echoJson($this->pro->getTrans($pid));
        }else {
            $this->echoJson($this->pro->getOne($pid));
        }
    }

    /** 获取流式分页的页面简略题目信息
     * $trans 是否带上翻译数据
     * @param $last_id
     * @param $source
     * @param bool $trans 是否带上翻译数据
     * @throws Exception
     */
    private function getProblemByFlow($last_id, $source,$trans)
    {
        if($trans){
            $this->echoJson($this->pro->getTransFlow($last_id, $source));

        }else {
            $this->echoJson($this->pro->getFlow($last_id, $source));
        }
    }


    /** 获取对应分类全部的页面简略题目信息
     * @param $source
     * @throws Exception
     */
    private function getAllProblem($source)
    {
        $this->echoJson($this->pro->getAll($source));
    }


    /**获取有评论的流式页面
     * @param $last_id
     * @throws Exception
     */
    private function getComProByFlow($last_id){

        $this->echoJson($this->pro->getFlow($last_id,'all',true));

    }

    /**获取搜索结果页
     * @param $word
     * @throws Exception
     */
    private function getSearch($word)
    {

        $this->echoJson($this->pro->search($word));
    }

    /** 获取有效的题目id数组
     * @param $last_id
     * @throws Exception
     */
    private function getIds($last_id,$source)
    {
        $this->echoJson($this->pro->getVaildIds($last_id,$source));

    }

}