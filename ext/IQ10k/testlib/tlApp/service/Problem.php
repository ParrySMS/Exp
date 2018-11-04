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
use tlApp\dao\Trans;
use tlApp\model\Json;
use \Exception;
use tlApp\model\Page;


class Problem extends BaseService
{
    private $pro;

    private $limit = 10000;//全部题目的限制数

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

        //插入提示
        if (!empty($problem_info['hint'])) {
            $hint = new Hint();
            $hint->insert($pid, $problem_info['hint']);
        }

        //插入题目选项内容
        $options = isset($problem_info['options'])?$problem_info['options']:null;

        if (is_array($options) && !empty($options) //如果有选项
        && $this->isChoice($problem_info['pro_type'])) { //并且是选择题
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

    /** 判断题型是否是选择题
     * @param $pro_type
     * @return bool
     */
    private function isChoice($pro_type){
        return ($pro_type == json_decode(PM_REGION_PROTYPE_JSON)[0]||$pro_type == json_decode(PM_REGION_PROTYPE_JSON)[1]);
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


        //先处理提示
        $this->editHint($pid, $problem_info['hint']);


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
            if (is_array($option_ids) && sizeof($option_ids) != 0) {//原有的选项不为空 有旧选选
                //获取原有选项数据
                $db_options_data = $op->selectGroup($pid, $option_ids);

                foreach ($db_options_data as $k => $d) {
                    //取交集
                    //删除 无用key的旧选项数据 引用传递
                    if (!array_key_exists($d['key'], $new_options)) {
                        $op->delete($d['id']);
                        unset($db_options_data[$k]);
                    }
                }
            }


            //每个新数据去遍历匹配 旧数据库原有的选项
            foreach ($new_options as $key => $value) {
                $update = 0;//默认无更新

                if (isset($db_options_data) && sizeof($db_options_data) != 0) {//找旧数据里存在的已有的
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

                //如果这个选项没有匹配到已有数据 无更新行为 把它看做新数据
                if ($update == 0) {
                    $new_oids[] = $op->insert($pid, $key, $value);
                }
            }

        }//新选项是空的 不管

        $problem_info['option_ids'] = json_encode($new_oids);

        //最后再插入题目主体 因为要记录时间
        $this->pro->update($problem_info);

        $retdata = (object)['pid' => $pid];
        $this->json->setRetdata($retdata);
        return $this->json;
    }


    /** 处理提示的编辑更新
     * @param $pid
     * @param $hint_string
     * @throws Exception
     */
    public function editHint($pid, $hint_string)
    {
        $hint = new Hint();
        $has_hint = $hint->has($pid);

        if (empty($hint_string) && $has_hint) { //空提示 原本有 相当于删除
            $hint->setVisible($pid);

        } else if (empty($hint_string) && !$has_hint) {//空提示 原本无 不管
            return;

        } else if (!empty($hint_string) && $has_hint) {//有提示 原本有 更新
            $hint->update($pid, $hint_string);

        } else if (!empty($hint_string) && !$has_hint) {//有提示 原本无 插入
            $hint->insert($pid, $hint_string);
        }
    }


    /** 获取流式页面数据 分为三类
     * 全来源普通题目
     * 条件来源普通题目
     * 全来源评论题目
     * @param $last_id
     * @param $source
     * @return Json
     * @throws Exception
     */
    public function getFlow($last_id, $source = 'all', $has_comment = false)
    {


        //分类讨论
        if ($has_comment) {//筛选有评论的题目 默认全部分类
            $pro_data = $this->pro->selectFlowComment($last_id);

        } else if ($source === 'all') {//普通题目 获取全部分类
            //todo 看起来这里获取全部和获取某个是可以通过参数调整来合并的，比如把'all'的情况，转为参数全部source的数组，时间有点久了不太记得为什么是两个分开的
            $pro_data = $this->pro->selectFlowAll($last_id);
        } else {//获取某个分类
            $pro_data = $this->pro->selectFlow($last_id, $source);
        }

        //拿出数据 算next id
        if (sizeof($pro_data) == 0) {
            $next_id = null;
        } else {//有数据
            $end = $pro_data[sizeof($pro_data) - 1];
            $next_id = isset($end['pid']) ? $end['pid'] : null;
        }


        //页面数据
        if ($has_comment) {//comment 评论题目
            $pageObj = $this->getCommentPageUri($next_id);
        } else {//source 普通题目
            $pageObj = $this->getSourcePageUri($source, $next_id);
        }

        $retdata = ['page' => $pageObj,
            'brief_problems' => $pro_data];

        $this->json->setRetdata($retdata);

        return $this->json;

    }

    /** 获取非英文的题目
     * @param $last_id
     * @param string $source
     * @return Json
     * @throws Exception
     */
    public function getTransFlow($last_id, $source = 'all')
    {
        $not_lang = json_decode(PM_REGION_LANG_JSON)[0]; //en
        //todo 看起来这里获取全部和获取某个是可以通过参数调整来合并的，同上getflow
        if ($source === 'all') {//普通题目 获取全部分类
            $pro_data = $this->pro->selectFlowAll($last_id,$not_lang);
        } else {//获取某个分类
            $pro_data = $this->pro->selectFlow($last_id, $source,$not_lang);
        }

        //拿出数据 算next id
        if (sizeof($pro_data) == 0) {
            $next_id = null;
        } else {//有数据
            $end = $pro_data[sizeof($pro_data) - 1];
            $next_id = isset($end['pid']) ? $end['pid'] : null;
        }

        $pageObj = $this->getSourcePageUri($source, $next_id);

        $retdata = ['page' => $pageObj,
            'brief_problems' => $pro_data];

        $this->json->setRetdata($retdata);

        return $this->json;
    }

    /** 获取分类全部题目
     * @param string $source
     * @param bool $has_comment
     * @return Json
     * @throws Exception
     */
    public function getAll($source = 'all', $has_comment = false)
    {
        //分类讨论
        if ($has_comment) {//筛选有评论的题目 默认全部分类
            $pro_data = $this->pro->selectFlowComment(null, $this->limit);

        } else if ($source === 'all') {//普通题目 获取全部分类
            $pro_data = $this->pro->selectFlowAll(null, $this->limit);
        } else {//获取某个分类
            $pro_data = $this->pro->selectFlow(null, $source);
        }

//        //拿出数据 算next id
//        if (sizeof($pro_data) == 0) {
//            $next_id = null;
//        } else {//有数据
//            $end = $pro_data[sizeof($pro_data) - 1];
//            $next_id = isset($end['pid']) ? $end['pid'] : null;
//        }

//        //页面数据
//        if ($has_comment) {//comment 评论题目
//            $pageObj = $this->getCommentPageUri($next_id);
//        }else {//source 普通题目
//            $pageObj = $this->getSourcePageUri($source, $next_id);
//        }

        $retdata = [
//            'page' => $pageObj,
            'brief_problems' => $pro_data
        ];

        $this->json->setRetdata($retdata);

        return $this->json;

    }


    /** 获取一条完整的题目数据
     * @param $pid
     * @return Json
     * @throws Exception
     */
    public
    function getOne($pid)
    {
        //先获取在主体题目信息（可能有hint）
        $pro_data = $this->pro->selectOne($pid);
        $pro_data['answers'] = json_decode($pro_data['answers']);
        //然后获取选项信息
        $oids = json_decode($pro_data['option_ids']);
        //对象数组
        $pro_data['options'] = [];

//        var_dump($pro_data);

        if (is_array($oids) && sizeof($oids) != 0) {
            $pro_data['options'] = $this->getOptions($pid, $oids);
        }

        //评论可能0-n条
        $com = new Comment();
        $pro_data['comments'] = $com->getComments($pid);

        $pro = new \tlApp\model\Problem($pro_data);
        $retdata = (object)['problem' => $pro];
        $this->json->setRetdata($retdata);

        return $this->json;
    }


    /** 获取一条带翻译数据的完整的题目数据
     * @param $pid
     * @return Json
     * @throws Exception
     */
    public
    function getTrans($pid)
    {
        $retdata = $this->getOne($pid)->getRetdata();

        $trans = new Trans();

        $trans_title = $trans->selectTitle($pid);

        $option_datas = $trans->selectOptionsGroup($pid);
        unset($trans_options);
        $trans_options = [];

        foreach ($option_datas as $d) {
            $trans_options[] = (object)$d;
        }

        $trans_hint = $trans->selectHint($pid);


        $retdata = (object)[
            'problem' => $retdata->problem,
            'trans'=> (object)[
                'title'=> $trans_title,
                'optionAr'=>$trans_options,
                'hint'=>$trans_hint
            ]
        ];

        $this->json->setRetdata($retdata);
        return $this->json;

    }

    /** 软删除
     * @param $pid
     * @param int $visible
     * @return Json
     * @throws Exception
     */
    public
    function delete($pid, $visible = VISIBLE_DELETE)
    {
        $this->pro->setVisible($pid, $visible);
        $retdata = (object)['pid' => $pid];
        $this->json->setRetdata($retdata);
        return $this->json;
    }

    /**评论数加1 用于给别的service调用的
     * @throws Exception
     */
    public
    function addCommentNum($pid)
    {
        $this->pro->addCommentNum($pid);
    }

    /** 返回全部的检索数据
     * @param $word
     * @return Json
     * @throws Exception
     */
    public function search($word)
    {
        $pro_data = $this->pro->selectPageLike($word);
        $retdata = ['brief_problems' => $pro_data];

        $this->json->setRetdata($retdata);

        return $this->json;
    }

    /** 获取有效的id数组
     * @param $last_id
     * @param $source
     * @return Json
     * @throws Exception
     */
    public function getVaildIds($last_id, $source)
    {
        if ($source === 'all') {//获取全部分类
            $data = $this->pro->selectIdsAll($last_id);
        } else {//获取某个分类
            $data = $this->pro->selectIds($last_id, $source);
        }

        unset($pids);
        $pids = [];

        foreach ($data as $d) {
            $pids[] = $d['id'];
        }

        $retdata = ['pids' => $pids];

        $this->json->setRetdata($retdata);

        return $this->json;
    }

    /**获取选项的对象数组 key取小写
     * @param $pid
     * @return array
     * @throws Exception
     */
    protected
    function getOptions($pid, $oids)
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


    /** 获取uri 返回一个page对象
     * @param $source
     * @param $next_id
     * @return Page
     */
    protected
    function getSourcePageUri($source, $next_id)
    {
        $pre = null;//下滑加载暂时不需要上一页
        $self = $_SERVER['REQUEST_URI'];
        $source = urlencode($source);
        if ($next_id === null) {
            $next = null;
        } else {
            $next = GET_PRO_API . "?source=$source&last_id=$next_id";
        }

        $page = new Page($pre, $self, $next);
        return $page;
    }

    /** 获取带评论的题目page对象
     * @param $next_id
     * @return Page
     */
    protected
    function getCommentPageUri($next_id)
    {
        $pre = null;//下滑加载暂时不需要上一页
        $self = $_SERVER['REQUEST_URI'];
        if ($next_id === null) {
            $next = null;
        } else {
            $next = GET_PRO_API . "/comment?last_id=$next_id";
        }

        $page = new Page($pre, $self, $next);
        return $page;
    }


}