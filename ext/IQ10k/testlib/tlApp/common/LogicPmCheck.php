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
    private $comment;
    private $source;
    private $last_id;


    /** 检查题目信息 可选是否有pid
     * @param array $body
     * @param bool $has_pid
     * @throws Exception
     */
    public function proInfoCheck(array $body, $has_pid = false)
    {

        //补齐body体的参数
        $problem_info = $this->proKeyComplete($body, $has_pid);

        //空检查
        $this->proNullCheck($problem_info);

        //参数范围定义检查
        $this->proRegionCheck($problem_info);

        // 题型限制逻辑检查
        $this->proTypeCheck($problem_info);

        $this->problem_info = $problem_info;

    }

    /** 检查题目id
     * @param $pid
     * @param bool $return
     * @return int|null|string
     * @throws Exception
     */
    public function pidCheck($pid)
    {
        $pid = parent::getNumeric($pid, true);
        if ($pid === null) {
            throw new Exception('pid type error', 400);
        }

        $this->pid = $pid;

        return $pid;
    }


    /** 添加评论的参数检查
     * @param array $body
     * @throws Exception
     */
    public function proCommentCheck(array $body)
    {

        $pid = isset($body['pid']) ? $this->pidCheck($body['pid']) : null;

        if (empty($pid)) {
            throw new \Exception('pid null', 400);
        }

        if (empty($body['comment'])) {
            throw new \Exception('comment null', 400);
        }

        $comment = parent::lenCheck($body['comment']);
        $comment = parent::strCheck($comment);

        $this->pid = $pid;
        $this->comment = $comment;
    }


    /** 获取分页数据的参数检查
     * @param array $query
     * @throws Exception
     */
    public function pageCheck(array $query)
    {
        $source = isset($query['source']) ? $query['source'] : null;

        if (empty($source)) {
            throw new \Exception('source null', 400);
        }

        $source = urldecode($source);
        $source = parent::strCheck($source);
        $source = parent::lenCheck(($source));

        //可选参数 不允许0
        $last_id = empty($query['last_id']) ? null : $query['last_id'];

        $this->source = $source;
        $this->last_id = $this->lastIdCheck($last_id);



    }

    /** 可选参数last_id检查
     * @param $last_id
     * @return int|null|string
     */
    public function lastIdCheck($last_id)
    {

        if (!empty($last_id)) {
             $last_id = parent::getNumeric($last_id, true);
        }else{
            $last_id = null;
        }

        return $last_id;
    }


    /** 检查word字符串
     * @param $word
     * @throws Exception
     */
    public function wordCheck($word)
    {
        if(empty($word)){
            throw new \Exception('word null', 400);
        }

        $word = urlencode($word);
        $word = parent::strCheck($word);
        $word = parent::lenCheck(($word));

        return $word;
    }

    /** 补齐body体的key 用于后面的检查
     * @param array $body
     * @param bool $has_pid 是否需要pid检查
     * @return array
     */
    protected function proKeyComplete(Array $body, $has_pid = false)
    {
        //解决前端options关键字的问题
        if (isset($body['optionAr'])) {
            $body['options'] = $body['optionAr'];
            unset($body['optionAr']);
        }

        //补齐字段
        $problem_base = json_decode(PROBLEM_BASE_INFO_JSON, true);

        if ($has_pid == true) {
            $problem_base['pid'] = null;
        }

        return array_merge($problem_base, $body);

    }

    /** 根据题型进行的逻辑检查 查选项与答案
     * @param array $problem_info
     * @throws Exception
     */
    protected function proTypeCheck(Array $problem_info)
    {
        $pro_type = $problem_info['pro_type'];

        $region = json_decode(PM_REGION_PROTYPE_JSON);
        switch ($pro_type) {
            case  $region[0]: //  'exclusive choice', 单选 0
                //选项数量检查 不得为0
                if (sizeof($problem_info['options']) == 0) {
                    throw new Exception( $pro_type.': option array should not be 0 length', 400);
                }

                //单选检查 长度必为1
                if (sizeof($problem_info['answers']) != 1) {
                    throw new Exception( $pro_type.': answer array should be 1 length', 400);
                }
                break;

            case $region[1]: // 'multiple choice': 多选题01
                //选项数量检查  不得为0
                if (sizeof($problem_info['options']) == 0) {
                    throw new Exception($pro_type.': option array should not be 0 length', 400);
                }
                //多选检查 长度小于等于1报错
                if (sizeof($problem_info['answers']) <= 1) {
                    throw new Exception($pro_type.': answer array should be over 1 length', 400);
                }
                break;


            case $region[4]: // 'short answer': // 简答题 4
            case $region[2]://  'exclusive fill', 单项填空 2

                //选项数量检查  必为0
                if ( isset($problem_info['options']) && sizeof($problem_info['options']) != 0) {
                    throw new Exception($pro_type.': option array should be 0 length', 400);
                }

                //单选检查 长度必为1
                if (sizeof($problem_info['answers']) != 1) {
                    throw new Exception($pro_type.': answer array should be 1 length', 400);
                }
                break;

            case $region[3] ://'multiple fill'://多项填空 3
                //选项数量检查  必为0
                if ( isset($problem_info['options']) && sizeof($problem_info['options']) != 0) {
                    throw new Exception($pro_type.': option array should be 0 length', 400);
                }
                //多选检查 长度小于等于1报错
                if (sizeof($problem_info['answers']) <= 1) {
                    throw new Exception($pro_type.': answer array should be over 1 length', 400);
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
    protected function proNullCheck(Array $problem_info)
    {
        if (sizeof($problem_info) == 0) {
            throw new \Exception('problem_info array null', 400);
        }


        // 部分参数的空检查 字符索引检查
        foreach ($problem_info as $key => & $value) {

            //索引检查
            switch ($key) {
                case 'options':
                    //关联数组狐狸
//                    $value = $value[0];
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

                //非空参数
//                case 'option_num':
                case 'pid':

                    //检查空 排除掉0的特殊情况
                    if ($value != 0 && empty($value) && !$this->isAllowNullParams()) {
                        throw new Exception("$key null", 400);
                    }
                    //类型检查 整数检查
                    if (parent::getNumeric($value, true) === null) {
                        throw new Exception("$key : $value type error", 400);
                    }
                    break;

                case 'title':
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
                    //todo 临时关闭冗余索引检查
//                    throw new Exception("key: $key invaild", 400);
                    break;
            }
        }
    }


    /** 参数限制范围检查
     * @param array $problem_info
     * @throws Exception
     */
    protected function proRegionCheck(Array $problem_info)
    {
        //范围检查
        $region_lang = json_decode(PM_REGION_LANG_JSON, true);
        if (!in_array($problem_info['language'], $region_lang)) {
            throw new Exception('language: ' . $problem_info['language'] . ' not in region', 400);
        }

        $region_type = json_decode(PM_REGION_PROTYPE_JSON, true);
        if (!in_array($problem_info['pro_type'], $region_type)) {
            throw new Exception('proType: ' . $problem_info['language'] . ' not in region', 400);
        }
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return mixed
     */
    public function getLastId()
    {
        return $this->last_id;
    }



    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
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