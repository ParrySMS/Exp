<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-7-23
 * Time: 1:08
 */

namespace tlApp\controller;
use \Exception;
use tlApp\model\Json;

class Problem extends BaseController
{

    public function __construct( Array $problem_info,$action)
    {
        try{
			switch ($action){
				case 'post':  //todo: 实现信息插入
				$this->postProblem($problem_info);
				break;
			
			}
          
            $json = null;

            if (!is_null($json)) {
                print_r(json_encode($json));
            }

        }catch (Exception $e){
            if ($e->getCode() <= 505 ) {//非200 直接输出
                $this->setStatus($e->getCode());
                echo MSG_ERROR_INFO . $e->getMessage();

            } else { //200下状态码 报错用json处理
                $this->setStatus(200);
                $json = new Json($e->getMessage(),null,$e->getCode());
                if (!is_null($json)) {
                    print_r(json_encode($json));
                }
            }
        }
    }

}