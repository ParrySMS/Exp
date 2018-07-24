<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-7-23
 * Time: 16:38
 */

namespace tlApp\common;


class LogicPmCheck extends PmCheck
{

    public function ProInfoRegionCheck(Array $problem_info)
    {
        //todo: 部分参数的空检查 字符索引检查
//        problem_info = compact($problem, $option_num, $options, $answers, $language, $classification, $pro_type, $proSource, $hint);

        if(in_array('',$problem_info)
        ||in_array(null,$problem_info)){
            throw new \Exception('null in problem_info',400);

        }

        //参数逻辑检查
        $region_lang = json_decode(PM_REGION_LANG_JSON);
        if(!in_array($problem_info['language'], $region_lang)){
            throw new \Exception('language: '.$problem_info['language'].' not in region',400);
        }

        $region_type = json_decode(PM_REGION_PROTYPE_JSON);
        if(!in_array($problem_info['pro_type'], $region_type)){
            throw new \Exception('proType: '.$problem_info['language'].' not in region',400);
        }

    }

}