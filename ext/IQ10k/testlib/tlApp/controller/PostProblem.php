<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-7-23
 * Time: 1:08
 */

namespace tlApp\controller;

use \Exception;
use tlApp\common\LogicPmCheck;
use tlApp\service\Problem;

class PostProblem extends BaseController
{


    public function __construct(Array $problem_info)
    {
        try {
            //参数逻辑检查
            $pm = new LogicPmCheck();
            //todo 图片处理部分 临时开启选项和回答的空数组
            $pm->setAllowNullArray(true);
            $pm->ProInfoCheck($problem_info);

            $info = $pm->getProblemInfo();

            // 实现信息插入
            $this->postProblem($info);

        } catch (Exception $e) {
            //多次复用 把报错放进父类
           $this->error($e);
        }
    }

    /** 实现信息插入
     * @param array $problem_info
     * @throws Exception
     */
    public function postProblem(Array $problem_info)
    {
        $pro = new Problem();
        $pro->post($problem_info);
    }
}