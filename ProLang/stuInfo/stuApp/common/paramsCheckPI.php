<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-3-20
 * Time: 17:08
 */

namespace stuApp\common;


class paramsCheckPI
{
    private $stuInfoArray = array();

    /**
     * @return array
     */
    public function getStuInfoArray()
    {
        return $this->stuInfoArray;
    }


    /**
     * paramsCheckPI constructor.
     * postInfo 的参数检查
     */
    public function __construct(array $stuInfoArray)
    {
        //空检查
        if(in_array('',$stuInfoArray)||in_array(null,$stuInfoArray)){
            throw new \Exception("param null in stuInfoArray",400);
        }

        $safe = new Safe();
        //参数安全检查 过滤
        foreach ($stuInfoArray as $key => $value){
            if(empty($value)){
                throw new \Exception("$key null in stuInfoArray",400);

            }
            $stuInfoArray[$key] = $safe->str_check($value);
        }

        $this->stuInfoArray = $stuInfoArray;

    }
}