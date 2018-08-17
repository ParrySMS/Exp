<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-7-23
 * Time: 13:24
 */

namespace tlApp\service;

use tlApp\dao\Hint;
use tlApp\dao\Option;
use tlApp\model\Json;
use \Exception;


class Problem extends BaseService
{
    private $pro;

    /**创建json对象
     * Problem constructor.
     */
    public function __construct()
    {
        $this->pro = new \tlApp\dao\Problem();
        $this->json = new Json();

    }

//    /**
//     *  不合理 因为异常的时候对象释放也会 触发析构函数 返回json对象
//     */
//    public function __destruct() {
//        if (!is_null($this->json)) {
//            print_r(json_encode($this->json));
//        }
//    }


    /** 插入题目+提示 插入选项 插入选项ids
     * @param array $problem_info
     * @return Json
     * @throws Exception
     */
    public function post(Array $problem_info)
    {
//
//      problem_info = {$title, $options, $answers, $language, $classification, $pro_type, $proSource, $hint};

        //把数组json化
        $problem_info['answers_json'] = json_encode($problem_info['answers']);

        //dao 先插入题目主干
        $pid = $this->pro->insert($problem_info);

        //再插入题目选项内容
        $options = $problem_info['options'];
        $op = new Option();
        unset($oid);
        $oids =[];
        foreach ($options as $key => $value) {
            $oids[] = $op->insert($pid,$key,$value);
        }

        //然后更新选项id
        $option_ids = json_encode($oids);
        $this->pro->setOids($pid,$option_ids);

        $retdata = (object)['pid' => $pid];
        $this->json->setRetdata($retdata);

        return $this->json;
    }



    public function edit(Array $problem_info)
    {
//        先不考虑图片

//   这个有pid
//   problem_info = {'pid','problem',  'options', 'answers', 'language', 'classification', 'pro_type', 'pro_source', 'hint'};

        $pid = $problem_info['pid'];
        //把数组json化
        $problem_info['answers_json'] = json_encode($problem_info['answers']);

        //先插入提示
        if (!empty($problem_info['hint'])) {
            $hint = new Hint();
            $hint->update($pid, $problem_info['hint']);
        }

        //更新选项 先拿到已有选项的集合
        $op = new Option();
        $option_ids = $this->pro->getOids($pid);
        $db_options_data = $op->selectGroup($pid,$option_ids);



//        然后对比修改
        $options = $problem_info['options'];
        foreach ($options as $key => $value) {

            foreach ($db_options_data as $d) {
                if ($key == $d['key'] && $value != $d['content']) { //数据库原有的选项 并且值不同 那么就更新
                    $op->update($d['id'], $pid, $key, $value);
                    break;
                }
            }
            //todo 要判断 已经更新 不需要再插入 不在key里需要插入  七夕先休息一下



        }

        //最后再插入题目主体 因为要记录时间
        $this->pro->update($problem_info);
        return $this->json;
    }

    public function getOne($pid)
    {
        //todo 当前临时方法 先获取在主体题目信息 已含有title的text值
        $pro_data = $this->pro->selectOne_tmp($pid);

        //todo 改数据表 把problem变成 title_text 和 title_pic 单独抽出option做表
//        $pro_main = $this->pro->selectOne($pid);
//          $pro_main['answers'] = json_decode($pro_main['answers']);
//        $options = $this->getOptions($pid);
//        $pro_main['options'] = $options;

// todo 明确题目里每个属性的类型 有图有文字  属性是item对象  string，pic数组
// todo 根据题目属性 去改数据库
    }

    /** 获取选项的关联数组 name取小写
     * @param $pid
     * @return array
     * @throws Exception
     */
    protected function getOptions($pid)
    {
        $op = new \tlApp\dao\Option();
        $data = $op->selectGroup($pid);

        unset($options);
        $options = [];

        foreach ($data as $d) {
            $options[$d['name']] = new \tlApp\model\Option($d['has_pic'], $d['content']);
        }

        return $options;

    }


}