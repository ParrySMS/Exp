<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-7-23
 * Time: 13:24
 */
namespace tlApp\service;
use tlApp\dao\Hint;
use tlApp\model\Json;

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


    /** 插入题目数据
     * @param array $problem_info
     * @return Json
     */
    public function post(Array $problem_info){
//
//      problem_info = {$problem, $option_num, $options, $answers, $language, $classification, $pro_type, $proSource, $hint};

        //把数组json化
        $problem_info['options_json'] = json_encode($problem_info['options']);
        $problem_info['answers_json'] = json_encode($problem_info['answers']);

        //dao
        $pid = $this->pro->insert($problem_info,true);

        $retdata = (object)['pid'=>$pid];
        $this->json->setRetdata($retdata);

        return $this->json;
    }


    /** 编辑题目信息 hint和problem分别update
     * @param array $problem_info
     * @return Json
     * @throws \Exception
     */
    public function edit(Array $problem_info){
//   这个有pid
//   problem_info = {'pid','problem',  'options', 'answers', 'language', 'classification', 'pro_type', 'pro_source', 'hint'};

        //把数组json化
        $problem_info['options_json'] = json_encode($problem_info['options']);
        $problem_info['answers_json'] = json_encode($problem_info['answers']);

        //处理option_num
        $problem_info['option_num'] = sizeof($problem_info['options']);

        //先插入提示
        if(!empty($problem_info['hint'])){
            $hint = new Hint();
            $hint->update($problem_info['pid'],$problem_info['hint']);
        }
        //再插入题目主体
        $this->pro->update($problem_info);
        return $this->json;
    }

    public function getOne($pid)
    {
        $data = $this->pro->selectOne($pid);
//  todo 明确题目里每个属性的类型 有图有文字  属性是item对象  string，pic数组
// todo 根据题目属性 去改数据库
//        $pro_mod =
    }
}