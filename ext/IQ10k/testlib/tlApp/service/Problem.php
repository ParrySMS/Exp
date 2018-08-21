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

        //dao 先插入题目主干 因为选项需要pid绑定
        $pid = $this->pro->insert($problem_info);

        //插入题目选项内容
        $options = $problem_info['options'];
        if (is_array($options)) {//如果有选项
            $op = new Option();

            unset($oid);
            $oids = [];

            foreach ($options as $key => $value) {
                $oids[] = $op->insert($pid, $key, $value);
            }

            //然后更新选项id
            $option_ids = json_encode($oids);
            $this->pro->setOids($pid, $option_ids);
        }


        $retdata = (object)['pid' => $pid];
        $this->json->setRetdata($retdata);

        return $this->json;
    }


    /** 实现选项的更新 todo 感觉这个函数得优化 能拆一些出来 两个不同数据结构的集合交叉匹配 很烦
     * @param array $problem_info
     * @return Json
     * @throws Exception
     */
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

        //方便最后更新题目主体索引
        //新选项参数默认空
        unset($new_oids);
        $new_oids = [];
        //准备更新的选项参数
        $new_options = $problem_info['options'];
        //拿到已有选项的集合
        $op = new Option();
        $option_ids = $this->pro->getOids($pid);

        if (sizeof($new_options) != 0) {//新选项不为空 有新参数

            //如果是选项减少 要删除原选项
            if (is_array($option_ids) && sizeof($option_ids) != 0) {//存在原有的选项
                //获取原有选项数据
                $db_options_data = $op->selectGroup($pid, $option_ids);
                //删除不添加的数据 引用传递
                foreach ($db_options_data as $k =>$d) {
                    //取交集
                    if (!array_key_exists($d['key'], $new_options)) {
                        $op->delete($d['id']);
                        unset($db_options_data[$k]);
                    }
                }
            }


            //每个新数据去遍历匹配 旧数据库原有的选项
            foreach ($new_options as $key => $value) {
                $update = 0;//默认无更新

                if (sizeof($db_options_data) != 0) {//找旧数据里存在的已有的
                    foreach ($db_options_data as $d) {
                        if ($key == $d['key']) { //匹配到
                            $update++;//发生了一次更新
                            $new_oids[] = $d['id'];//加入新的选项id序列

                            if ($value != $d['content']) { //  匹配到并且值不同 那么就真更新
                                $op->update($d['id'], $pid, $key, $value);
                                break;//检验到 之后就可以跳出 进行下一个新数据了
                            }//否则假更新
                        }
                    }
                }//旧数据里没选项了

                //如果这个选项没有匹配到已有数据 把它看做新数据
                if ($update == 0) {
                    $new_oids[] = $op->insert($pid, $key, $value);
                }
            }

        }//新选项是空的

        $problem_info['option_ids'] = json_encode($new_oids);

        //最后再插入题目主体 因为要记录时间
        $this->pro->update($problem_info);

        $retdata = (object)['pid' => $pid];
        $this->json->setRetdata($retdata);
        return $this->json;
    }


    /** 获取一条完整的题目数据 //todo 得加个评论内容 model可能得调
     * @param $pid
     * @return Json
     * @throws Exception
     */
    public function getOne($pid)
    {
        //先获取在主体题目信息（可能有hint）
        $pro_data = $this->pro->selectOne($pid);
        $pro_data['answers'] = json_decode($pro_data['answers']);
        //然后获取选项信息
        $oids = json_decode($pro_data['option_ids']);
        //对象数组
        $pro_data['options'] = [];

        if (is_array($oids) && sizeof($oids) != 0) {
            $pro_data['options'] = $this->getOptions($pid, $oids);
        }

        $pro = new \tlApp\model\Problem($pro_data);
        $retdata = (object)['problem' => $pro];
        $this->json->setRetdata($retdata);

        return $this->json;
    }

    /** 软删除
     * @param $pid
     * @param int $visible
     * @return Json
     * @throws Exception
     */
    public function delete($pid, $visible = VISIBLE_DELETE)
    {
        $this->pro->setVisible($pid,$visible);
        $retdata = (object)['pid' => $pid];
        $this->json->setRetdata($retdata);
        return $this->json;
    }

    /**获取选项的对象数组 key取小写
     * @param $pid
     * @return array
     * @throws Exception
     */
    protected function getOptions($pid, $oids)
    {
        $op = new \tlApp\dao\Option();
        $datas = $op->selectGroup($pid, $oids);

        unset($options);
        $options = [];

        foreach ($datas as $d) {
            $options[] = new \tlApp\model\Option($d);
        }

        return $options;
    }


}