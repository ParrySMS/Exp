<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-7-23
 * Time: 13:24
 */
namespace tlApp\service;
use tlApp\dao\Hint;
use tlApp\dao\Pic;
use tlApp\dao\Text;
use tlApp\model\Option;
use tlApp\model\Json;
use \Exception;
use tlApp\model\Title;

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
        //todo 当前临时方法 先获取在主体题目信息
        $pro_data = $this->pro->selectOne($pid);

        $title = getTitle($pid);





//  todo 明确题目里每个属性的类型 有图有文字  属性是item对象  string，pic数组
// todo 根据题目属性 去改数据库
//        $pro_mod =
    }

    /** todo 先睡觉 明天继续写这里
     * @param $pid
     * @return Title
     * @throws Exception
     */
    protected function getTitle($pid){
        //todo 确认类型 这个函数还没写
        $title_type = $this->pro->getTitleType();
        $suffix = 'title';
        switch ($title_type){

            case TITLE_TYPE_PIC: //todo 配合getTitleType 把常量定义好
                //查找图片 先查题图
                $pic = new Pic($suffix);
                $data = $pic->selectOne($pid);

                unset($title_pics);
                $title_pics = [];

                if (sizeof($data) == 1) {
                    $title_pic = $data[0]['url'];
                    $title_pics =[$title_pic];
                }else{
                    foreach ($data as $d){
                        $title_pics[] = $d['url'];
                    }
                }

            //然后继续查文本
            case TITLE_TYPE_TEXT:

                $text = new Text($suffix);
                $title_text_data = $text->selectOne($pid);
                $title_text = $title_text_data[0]['text'];

                $title_pics = isset($title_pics)?$title_pics:[];

                $title = new Title($title_text,$title_pics);
                return $title;


            default:
                throw new \Exception("title type invaild: $title_type",500);
                break;
        }

    }
}