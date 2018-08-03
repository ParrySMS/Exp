<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/8/2
 * Time: 8:58
 */

namespace tlApp\controller;

use \Exception;
use tlApp\common\LogicPmCheck;
use tlApp\service\Problem;


class EditProblem extends BaseController
{
    public function __construct(Array $body)
    {
        try {
            //参数逻辑检查
            $pm = new LogicPmCheck();
            //todo 图片处理部分 临时开启选项和回答的空数组
            $pm->setAllowNullArray(true);
            $pm->ProInfoCheck($body,true);

            $info = $pm->getProblemInfo();

            // 实现信息更新
            $this->editProblem($info);

        } catch (Exception $e) {
            $this->error($e);
        }
    }

    /** 实现题目信息编辑
     * @param $problem_info
     * @throws Exception
     */
    public function editProblem($problem_info)
    {

        $pro = new Problem();
        $this->echoJson($pro->edit($problem_info));
    }

}