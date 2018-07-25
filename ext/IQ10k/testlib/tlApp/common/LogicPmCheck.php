<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-7-23
 * Time: 16:38
 */

namespace tlApp\common;
use \Exception;

class LogicPmCheck extends PmCheck
{
    private $allow_null_array = false;
    private $allow_null_params = false;

    public function ProInfoRegionCheck(Array $problem_info)
    {
//        problem_info = compact($problem, $option_num, $options, $answers, $language, $classification, $pro_type, $pro_source, $hint);
        if (sizeof($problem_info) == 0 ) {
            throw new \Exception("problem_info array null", 400);
        }


        // 部分参数的空检查 字符索引检查
        foreach ($problem_info as $key => $value) {

            //索引检查
            switch ($key) {
                case 'options':
                case 'answers':
                    //类型检查
                    if (!is_array($value)) {
                        throw new \Exception("$key is not array", 400);
                    }
                    //空数组
                    if (sizeof($value) == 0 && !$this->isAllowNullArray()) {
                        throw new \Exception("$key array null", 400);
                    }
                    break;

                case 'option_num':
                case 'problem':
                case 'language':
                case 'classification':
                case 'pro_type':
                case 'pro_source':
                //索引不存在
                    if (empty($value) && !$this->isAllowNullParams()) {
                        throw new Exception("$key null", 400);
                    }
                    break;
                //允许空
                case 'hint':
                    break;
                default:
                        throw new Exception("$key invaild", 400);
                        break;
            }
        }

        //参数逻辑检查

        //整数检查
//        if($this->numCheck($problem_info['option_num'])===null){
//            throw new Exception('option_num: ' . $problem_info['option_num'] . ' type error', 400);
//        }
//
//        $region_lang = json_decode(PM_REGION_LANG_JSON);
//        if (!in_array($problem_info['language'], $region_lang)) {
//            throw new Exception('language: ' . $problem_info['language'] . ' not in region', 400);
//        }
//
//        $region_type = json_decode(PM_REGION_PROTYPE_JSON);
//        if (!in_array($problem_info['pro_type'], $region_type)) {
//            throw new Exception('proType: ' . $problem_info['language'] . ' not in region', 400);
//        }

    }

    /**
     * @return bool
     */
    public function isAllowNullArray()
    {
        return $this->allow_null_array;
    }

    /**
     * @param bool $allow_null_array
     */
    public function setAllowNullArray($allow_null_array)
    {
        $this->allow_null_array = $allow_null_array;
    }

    /**
     * @return bool
     */
    public function isAllowNullParams()
    {
        return $this->allow_null_params;
    }

    /**
     * @param bool $allow_null_params
     */
    public function setAllowNullParams($allow_null_params)
    {
        $this->allow_null_params = $allow_null_params;
    }


}