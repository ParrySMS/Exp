<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-8-3
 * Time: 17:24
 */

namespace tlApp\controller;


use tlApp\common\LogicPmCheck;

class GetProblem extends BaseController
{

    public function withPid($pid)
    {
        try {
            //参数逻辑检查
            $pm = new LogicPmCheck();
            //todo 图片处理部分 临时开启选项和回答的空数组
            $pm->setAllowNullArray(true);
            $pm->ProInfoCheck($body);

            $info = $pm->getProblemInfo();

            // 实现信息插入
            $this->postProblem($info);

        } catch (Exception $e) {
            //多次复用 把报错放进父类
            $this->error($e);
        }
    }

}