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