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
     * @param $pid
     */
    public function withPid($pid)
    {
        try {
            //参数逻辑检查
            $pid = $this->pm->pidCheck($pid);

            $this->getProblemById($pid);

        } catch (Exception $e) {
            $this->error($e);
        }
    }

    /** 获取页面 流式分页
     * @param array $query
     */
    public function withFlow(array $query)
    {

        try {
            //参数逻辑检查
            $this->pm->pageCheck($query);
            $source = $this->pm->getSource();
            $last_id = $this->pm->getLastId();

            $this->getProblemByFlow($last_id, $source);

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
     * @throws Exception
     */
    private function getProblemById($pid)
    {
        $this->echoJson($this->pro->getOne($pid));

    }

    /** 获取流式分页的页面简略题目信息
     * @param $last_id
     * @param $source
     * @throws Exception
     */
    private function getProblemByFlow($last_id, $source)
    {
        $this->echoJson($this->pro->getFlow($last_id, $source));
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