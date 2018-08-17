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

    private $problem_info;
    private $pid;


    /** 检查题目信息 可选是否有pid
     * @param array $body
     * @param bool $has_pid
     * @throws Exception
     */
    public function proInfoCheck(Array $body, $has_pid = false)
    {

        //补齐body体的参数
        $problem_info = $this->keyComplete($body,$has_pid);

        //空检查
        $this->nullCheck($problem_info);

        //参数范围定义检查
        $this->regionCheck($problem_info);

        //todo 临时关闭 题型限制逻辑检查
//        $this->proTypeCheck($problem_info);

        $this->problem_info = $problem_info;

    }

    /** 检查题目id
     * @param $pid
     * @param bool $return
     * @return int|null|string
     * @throws Exception
     */
    public function pidCheck($pid, $return = false)
    {
        $pid = parent::getNumeric($pid);
        if ($pid === null) {
            throw new Exception('pid type error', 400);
        }

        $this->pid = $pid;

        if ($return == true) {
            return $pid;
        }
    }


    /** 补齐body体的key 用于后面的检查
     * @param array $body
     * @param bool $has_pid 是否需要pid检查
     * @return array
     */
    protected function keyComplete(Array $body, $has_pid = false)
    {
        //解决前端options关键字的问题
        if(isset($body['optionAr'])){
            $body['options']=$body['optionAr'];
            unset($body['optionAr']);
        }

        $problem_base = PROBLEM_BASE_ARRAY;
//        [
//            'problem' => null,
//            //todo option_num之后要去掉
//            'option_num' => null,
//            'options' => null,
//            'answers' => null,
//            'language' => null,
//            'classification' => null,
//            'pro_type' => null,
//            'pro_source' => null,
//            'hint' => null,
//        ];

        if($has_pid == true){
            $problem_base['pid'] = null;
        }

        return array_merge($problem_base,$body);

    }

    /** 根据题型进行的逻辑检查 查选项与答案
     * @param array $problem_info
     * @throws Exception
     */
    protected function proTypeCheck(Array $problem_info)
    {
        $pro_type = $problem_info['pro_type'];


        switch ($pro_type) {
            case 'exclusive choice'://单选题
                //选项数量检查 不得为0
                if (sizeof($problem_info['options'] == 0)) {
                    throw new Exception('option array should not be 0 length', 400);
                }

                //单选检查 长度必为1
                if (sizeof($problem_info['answers'] != 1)) {
                    throw new Exception('answer array should be 1 length', 400);
                }
                break;

            case 'multiple choice'://多选题
                //选项数量检查  不得为0
                if (sizeof($problem_info['options'] == 0)) {
                    throw new Exception('option array should not be 0 length', 400);
                }
                //多选检查 长度小于等于1报错
                if (sizeof($problem_info['answers'] <= 1)) {
                    throw new Exception('answer array should be over 1 length', 400);
                }
                break;

            case 'short answer'://简答题
            case 'exclusive fill'://单项填空
                //选项数量检查  必为0
                if (sizeof($problem_info['options'] != 0)) {
                    throw new Exception('option array should not be 0 length', 400);
                }

                //单选检查 长度必为1
                if (sizeof($problem_info['answers'] != 1)) {
                    throw new Exception('answer array should be 1 length', 400);
                }
                break;

            case 'multiple fill'://多项填空
                //选项数量检查  必为0
                if (sizeof($problem_info['options'] != 0)) {
                    throw new Exception('option array should not be 0 length', 400);
                }
                //多选检查 长度小于等于1报错
                if (sizeof($problem_info['answers'] <= 1)) {
                    throw new Exception('answer array should be over 1 length', 400);
                }
                break;


            default:
                throw new Exception("pro_type $pro_type invaild", 400);
                break;
        }
    }


    //todo 语言类型检查
    protected function langCheck()
    {


    }

    /** 参数空检查
     * @param array $problem_info
     * @throws Exception
     */
    protected function nullCheck(Array $problem_info)
    {
        if (sizeof($problem_info) == 0) {
            throw new \Exception("problem_info array null", 400);
        }


        // 部分参数的空检查 字符索引检查
        foreach ($problem_info as $key => $value) {

            //索引检查
            switch ($key) {
                case 'options':
                case 'answers':

                    //类型检查
                    if (!is_array($value) && !$this->isAllowNullArray()) {
                        throw new \Exception("$key is not array", 400);
                    }
                    //空数组
                    if (sizeof($value) == 0 && !$this->isAllowNullArray()) {
                        throw new \Exception("$key array null", 400);
                    }
                    break;

                //非空参数 todo 这个option_num后面要去掉
                case 'option_num':
                case 'pid':

                    //检查空 排除掉0的特殊情况
                    if ($value != 0 && empty($value) && !$this->isAllowNullParams()) {
                        throw new Exception("$key null", 400);
                    }
                    //类型检查 整数检查
                    if (parent::getNumeric($value,true) === null) {
                        throw new Exception( "$key : $value type error", 400);
                    }
                    break;

                case 'problem':
                case 'language':
                case 'classification':
                case 'pro_type':
                case 'pro_source':
                    //检查空
                    if (empty($value) && !$this->isAllowNullParams()) {
                        throw new Exception("$key null", 400);
                    }
                    break;

                //允许空的参数
                case 'hint':
                    break;

                default://索引不存在
                    throw new Exception("key: $key invaild", 400);
                    break;
            }
        }
    }


    /** 参数限制范围检查
     * @param array $problem_info
     * @throws Exception
     */
    protected function regionCheck(Array $problem_info)
    {
        //范围检查
        $region_lang = json_decode(PM_REGION_LANG_JSON);
        if (!in_array($problem_info['language'], $region_lang)) {
            throw new Exception('language: ' . $problem_info['language'] . ' not in region', 400);
        }

        $region_type = json_decode(PM_REGION_PROTYPE_JSON);
        if (!in_array($problem_info['pro_type'], $region_type)) {
            throw new Exception('proType: ' . $problem_info['language'] . ' not in region', 400);
        }
    }

    /**
     * @return mixed
     */
    public function getProblemInfo()
    {
        return $this->problem_info;
    }

    /**
     * @return mixed
     */
    public function getPid()
    {
        return $this->pid;
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