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

    public function withPid($pid)
    {
        try {
            //日志记录
            parent::actionLog();

            //参数逻辑检查
            $pm = new LogicPmCheck();
            $pid = $pm->pidCheck($pid,true);

            $this->getProblemById($pid);

        } catch (Exception $e) {
            $this->error($e);
        }
    }

    /**
     * @param $pid
     * @throws Exception
     */
    private function getProblemById($pid)
    {
        $pro = new Problem();
        $this->echoJson($pro->getOne($pid));

    }

}