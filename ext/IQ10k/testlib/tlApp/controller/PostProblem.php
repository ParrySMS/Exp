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
use tlApp\model\Json;
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
            $pm->ProInfoRegionCheck($problem_info);
            $problem_info = $pm->getProblemInfo();

            // 实现信息插入
            $json =$this->postProblem($problem_info);

            if (!is_null($json)) {
                print_r(json_encode($json));
            }

        } catch (Exception $e) {
            if ($e->getCode() <= 505) {//非200 直接输出
                $this->setStatus($e->getCode());
                echo MSG_ERROR_INFO . $e->getMessage();

            } else { //200下状态码 报错用json处理
                $this->setStatus(200);
                $json = new Json($e->getMessage(), null, $e->getCode());
                if (!is_null($json)) {
                    print_r(json_encode($json));
                }
            }
        }
    }

    /** 实现信息插入
     * @param array $problem_info
     * @return Json
     * @throws Exception
     */
    public function postProblem(Array $problem_info)
    {

        $pro = new Problem();
        return  $pro->post($problem_info);

    }
}