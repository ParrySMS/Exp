<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-8-21
 * Time: 16:57
 */

namespace tlApp\controller;

use tlApp\common\LogicPmCheck;
use Exception;
use tlApp\service\Problem;

class DeleteProblem extends BaseController
{
    public function __construct()
    {
        parent::actionLog();
    }

    public function withPid($pid)
    {
        try {


            //参数逻辑检查
            $pm = new LogicPmCheck();
            $pid = $pm->pidCheck($pid);

            $this->delete($pid);

        } catch (Exception $e) {
            $this->error($e);
        }
    }

    /** 实现删除
     * @param $pid
     * @throws Exception
     */
    private function delete($pid){
        $pro = new Problem();
        $this->echoJson($pro->delete($pid));
    }

}