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
    private $allow_null_array = true;
    private $allow_null_params = false;

    public function ProInfoRegionCheck(Array $problem_info)
    {
//  problem_info = compact($problem, $option_num, $options, $answers, $language, $classification, $pro_type, $proSource, $hint);

        // 部分参数的空检查 字符索引检查
        foreach ($problem_info as $key => $value) {

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
                default:
                    if (empty($value) && !$this->isAllowNullParams()) {
                        throw new \Exception("$key null", 400);
                    }
            }
        }

        //参数逻辑检查
        $region_lang = json_decode(PM_REGION_LANG_JSON);
        if (!in_array($problem_info['language'], $region_lang)) {
            throw new \Exception('language: ' . $problem_info['language'] . ' not in region', 400);
        }

        $region_type = json_decode(PM_REGION_PROTYPE_JSON);
        if (!in_array($problem_info['pro_type'], $region_type)) {
            throw new \Exception('proType: ' . $problem_info['language'] . ' not in region', 400);
        }

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