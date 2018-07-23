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
use tlApp\service\Problem;

class PostProblem extends BaseController
{

    public function __construct( Array $problem_info)
    {
        try{

            //参数逻辑检查
            $region_lang = json_decode(PM_REGION_LANG_JSON);
            if(!in_array($problem_info['language'], $region_lang)){
                throw new \Exception('language: '.$problem_info['language'].' not in region',400);
            }

            $region_type = json_decode(PM_REGION_PROTYPE_JSON);
            if(!in_array($problem_info['pro_type'], $region_type)){
                throw new \Exception('proType: '.$problem_info['language'].' not in region',400);
            }



            //todo: 实现信息插入

				$this->postProblem($problem_info);


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

    public function postProblem(Array $problem_info)
    {


        $pro = new Problem();
        $pro->post(Array $problem_info);


    }
}