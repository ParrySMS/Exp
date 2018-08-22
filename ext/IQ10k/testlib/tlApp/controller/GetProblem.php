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

    /**
     * GetProblem constructor.
     */
    public function __construct()
    {
        //日志记录
        parent::actionLog();
        //参数逻辑检查
        $this->pm = new LogicPmCheck();
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

    /** 获取页面
     * @param array $body
     */
    public function withFlow(array $body)
    {

        try {
            //参数逻辑检查
            $this->pm->pageCheck($body);
            $source = $this->pm->getSource();
            $last_id = $this->pm->getLastId();

            $this->getProblemByFlow($last_id,$source);

        } catch (Exception $e) {
            $this->error($e);
        }
    }

    public function hasComment(){
        //todo
    }


    /** 获取某个具体的题目详情
     * @param $pid
     * @throws Exception
     */
    private function getProblemById($pid)
    {
        $pro = new Problem();
        $this->echoJson($pro->getOne($pid));

    }

    /** 获取流式分页的页面简略题目信息
     * @param $last_id
     * @param $source
     * @throws Exception
     */
    private function getProblemByFlow($last_id, $source)
    {
        $pro = new Problem();
        $this->echoJson($pro->getFlow($last_id,$source));
    }

}