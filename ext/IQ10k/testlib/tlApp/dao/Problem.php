<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-7-23
 * Time: 13:34
 */

namespace tlApp\dao;

use \Exception;

//use Medoo\Medoo;
//
//require '../../config/database_info.php';
//require '../../Medoo/Medoo.php';
//$p = new Problem();
//$d = $p->selectOne(17);
//var_dump($d);

class Problem extends BaseDao
{

    protected $table ;
//    protected $table = DB_PREFIX . "_problem_test";
//    protected $table = DB_PREFIX . "_problem_adddigramspecial";
    public function __construct()
    {
        parent::__construct();
        $this->table = $this::$T_PROBLEM;
    }
    /** 插入除选项往的题目信息主体 不含图片 不含option
     * @param array $problem_info
     * @param bool $ret_id
     * @return int
     * @throws Exception
     */
    public function insert(Array $problem_info)
    {

//        problem_info = compact($title, $options(这个单独插),$answers,$language, $classification, $pro_type, $pro_source, $hint);
//        problem_info 加多了  $problem_info['answers_json'],
        //插入 问题主体
        $pdo = $this->database->insert($this->table, [
            'title' => $problem_info['title'],
            'answers' => $problem_info['answers_json'],
            'language' => $problem_info['language'],
            'classification' => $problem_info['classification'],
            'pro_type' => $problem_info['pro_type'],
            'pro_source' => $problem_info['pro_source'],
            'time' => date(DB_TIME_FORMAT),
            'edit_time' => date(DB_TIME_FORMAT),
            'total_edit' => 0,
            'visible' => VISIBLE_NORMAL,
            'comment_num' => 0

        ]);

        $pid = $this->database->id();
        if (!is_numeric($pid) || $pid < 1) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():  pid error', 500);

        }

        //弄个新的dao 插入 问题提示
//        if (!empty($problem_info['hint'])) {
//
//            $table_hint = DB_PREFIX . '_hint_test';
//            $pdo = $this->database->insert($table_hint, [
//                'pid' => $pid,
//                'hint' => $problem_info['hint'],
//                'time' => date(DB_TIME_FORMAT),
//                'visible' => VISIBLE_NORMAL
//
//            ]);
//
//            $hid = $this->database->id();
//            if (!is_numeric($hid) || $hid < 1) {
//                throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():  hid error', 500);
//            }
//        }
        //问题选项放到选项表里单独插

        return $pid;
    }


    /** 更新题目主体信息 （需要先更新其他）
     * @param array $problem_info
     * @throws Exception
     */
    public function update(Array $problem_info)
    {
        $pdo = $this->database->update($this->table, [
            'title' => $problem_info['title'],
            'option_ids' => $problem_info['option_ids'],
            'answers' => $problem_info['answers_json'],
            'language' => $problem_info['language'],
            'classification' => $problem_info['classification'],
            'pro_type' => $problem_info['pro_type'],
            'pro_source' => $problem_info['pro_source'],
            'edit_time' => date(DB_TIME_FORMAT),
            'total_edit[+]' => 1
        ], [
            'AND' => [
                'id' => $problem_info['pid'],
                'visible[!]' => VISIBLE_DELETE
            ]
        ]);

        $affected = $pdo->rowCount();
        if (!is_numeric($affected) || $affected != 1) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():  error', 500);
        }
    }


    /** 获取全来源的页面 修改为不需要连表 简略信息
     * @param $last_id
     * @return array|bool
     * @throws Exception
     */
    public function selectFlowAll($last_id,$limit = PROBLEM_PAGE_LIMIT)
    {
        if ($last_id == null) {
            //请求最新的首页
            $last_id = $this->getLastId();
        }

//        $table_h = DB_PREFIX . "_hint_test";

        $data = $this->database->select($this->table . '(p)', [
//            "[>]" . "$table_h" . "(h)" => ['p.id' => 'pid'],
//        ], [
            'p.id(pid)',
            'p.title',
            'p.title_pic',
//            'p.option_ids',
//            'p.answers',//这个是json
//            'p.language',
            'p.classification',
            'p.pro_type',
            'p.pro_source',
//            'p.time',
//            'p.edit_time',
//            'p.total_edit',
            'p.comment_num',
//            'h.hint',
        ], [
            'AND' => [
                'p.id[<]' => $last_id,
                'p.visible[!]' => VISIBLE_DELETE
            ],
            "ORDER" => [
                'p.id' => 'DESC'
            ],
            "LIMIT" => $limit
        ]);

        //0-n条
        if (!is_array($data)) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():  error', 500);
        }

        return $data;
    }

    /** 挑选有评论的题目 修改为不需要连表 简略信息
     * @param $last_id
     * @return array|bool
     * @throws Exception
     */
    public function selectFlowComment($last_id,$limit = PROBLEM_PAGE_LIMIT)
    {
        if ($last_id == null) {
            //请求最新的首页
            $last_id = $this->getLastId();
        }

//        $table_h = DB_PREFIX . "_hint_test";

        $data = $this->database->select($this->table . '(p)', [
//            "[>]" . "$table_h" . "(h)" => ['p.id' => 'pid'],
//        ], [
            'p.id(pid)',
            'p.title',
            'p.title_pic',
//            'p.option_ids',
//            'p.answers',//这个是json
//            'p.language',
            'p.classification',
            'p.pro_type',
            'p.pro_source',
//            'p.time',
//            'p.edit_time',
//            'p.total_edit',
            'p.comment_num',
//            'h.hint',
        ], [
            'AND' => [
                'p.id[<]' => $last_id,
                'p.comment_num[>]' => 0,
                'p.visible[!]' => VISIBLE_DELETE
            ],
            "ORDER" => [
                'p.id' => 'DESC'
            ],
            "LIMIT" => $limit
        ]);

        //0-n条
        if (!is_array($data)) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():  error', 500);
        }

        return $data;
    }

    /** 获取某来源下的有效题目id数据
     * @param $last_id
     * @param $source
     * @return array|bool
     * @throws Exception
     */
    public function selectIds($last_id,$source)
    {
        if ($last_id == null) {
            //请求最新的首页
            $last_id = $this->getLastId();
        }

        $data = $this->database->select($this->table, [
            'id'
        ], [
            'AND'=>[
                'id[<]'=>$last_id,
                'pro_source'=>$source,
                'visible[!]'=>VISIBLE_DELETE
            ],
            "ORDER" => [
                'id' => 'DESC'
            ],
            "LIMIT" => PROBLEM_IDS_LIMIT
        ]);

        //0-n条
        if (!is_array($data)) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():  error', 500);
        }

        return $data;

    }


    /** 获取全部来源下的有效题目id数据
     * @param $last_id
     * @return array|bool
     * @throws Exception
     */
    public function selectIdsAll($last_id)
    {
        if ($last_id == null) {
            //请求最新的首页
            $last_id = $this->getLastId();
        }

        $data = $this->database->select($this->table, [
            'id'
        ], [
            'AND'=>[
                'id[<]'=>$last_id,
                'visible[!]'=>VISIBLE_DELETE
            ],
            "ORDER" => [
                'id' => 'DESC'
            ],
            "LIMIT" => PROBLEM_IDS_LIMIT
        ]);

        //0-n条
        if (!is_array($data)) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():  error', 500);
        }

        return $data;

    }

    /** 获取某个来源下的页面
     * @param $last_id
     * @param $source
     * @return array|bool
     * @throws Exception
     */
    public function selectFlow($last_id, $source,$limit = PROBLEM_PAGE_LIMIT )
    {
        if ($last_id == null) {
            //请求最新的首页
            $last_id = $this->getLastId();
        }

//        $table_h = DB_PREFIX . "_hint_test";

        $data = $this->database->select($this->table . '(p)', [
//            "[>]" . "$table_h" . "(h)" => ['p.id' => 'pid'],
//        ], [
            'p.id(pid)',
            'p.title',
            'p.title_pic',
//            'p.option_ids',
//            'p.answers',//这个是json
//            'p.language',
            'p.classification',
            'p.pro_type',
            'p.pro_source',
//            'p.time',
//            'p.edit_time',
//            'p.total_edit',
            'p.comment_num',
//            'h.hint',
        ], [
            'AND' => [
                'p.id[<]' => $last_id,
                'p.pro_source' => $source,
                'p.visible[!]' => VISIBLE_DELETE
            ],
            "ORDER" => [
                'p.id' => 'DESC'
            ],
            "LIMIT" => $limit
        ]);

        //0-n条
        if (!is_array($data)) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():  error', 500);
        }

        return $data;
    }


    /** 根据pid 返回一个题目信息 连表提示 评论单独取
     * @param $pid
     * @return array|bool
     * @throws Exception
     */
    public function selectOne($pid)
    {
        $table_h = DB_PREFIX . "_hint_test";

        $data = $this->database->select($this->table . '(p)', [
            "[>]" . "$table_h" . "(h)" => ['p.id' => 'pid']
        ], [
            'p.id',
            'p.title',
            'p.title_pic',
            'p.option_ids',
            'p.answers',//这个是json
            'p.language',
            'p.classification',
            'p.pro_type',
            'p.pro_source',
            'p.time',
            'p.edit_time',
            'p.total_edit',
//            'p.comment_num',
            'h.hint',
        ], [
            'AND' => [
                'p.id' => $pid,
                'p.visible[!]' => VISIBLE_DELETE
            ]
        ]);

        //一条
        if (!is_array($data) || sizeof($data) != 1) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():  error', 500);
        }

        return $data[0];
    }


    /** 插入题目的选项id数组json
     * @param $pid
     * @param $option_ids_json
     * @throws Exception
     */
    public function setOids($pid, $option_ids_json)
    {
        $pdo = $this->database->update($this->table, [
            'option_ids' => $option_ids_json
        ], [
            'AND' => [
                'id' => $pid,
                'visible[!]' => VISIBLE_DELETE
            ]
        ]);


        $affected = $pdo->rowCount();
        if (!is_numeric($affected) || $affected != 1) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '(): error', 500);
        }

    }

    /** 得到选项编号数组
     *  注意：非选择题不应该调用这个函数
     * @param $pid
     * @return mixed
     * @throws Exception
     */
    public function getOids($pid)
    {
        $pro_type = json_decode(PM_REGION_PROTYPE_JSON);
        //前两项 选择题
        $choice = [$pro_type[0], $pro_type[1]];
        $json = $this->database->get($this->table,
            'option_ids'
            , [
                'AND' => [
                    'id' => $pid,
                    'pro_type' => $choice,
                    'visible[!]' => VISIBLE_DELETE
                ]
            ]);

        return is_null(json_decode($json)) ? [] : json_decode($json);

    }

    /** 设置可见属性 不考虑重复删除
     * @param $pid
     * @param $visible
     * @throws Exception
     */
    public function setVisible($pid, $visible)
    {
        $pdo = $this->database->update($this->table, [
            'visible' => $visible,
            'edit_time' => date(DB_TIME_FORMAT)
        ], [
            'id' => $pid
        ]);

        $affected = $pdo->rowCount();

        if (!is_numeric($affected) || $affected != 1) {
//            var_dump($affected);
//            var_dump($this->database->error());
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():  error', 500);
        }
    }


    /** 获取最大的id值 并将其+1作为last_id
     * @return bool|int|mixed|string
     */
    public function getLastId()
    {

        $last_id = $this->database->max($this->table, 'id',
            [
                'visible' => VISIBLE_NORMAL
            ]);
        //因为last_id是不取数据的，所以+1保证第一次取到最大的id，即最新的数据
        return $last_id + 1;
    }

    /** 增加一个评论数
     * @throws Exception
     */
    public function addCommentNum($pid)
    {
        $pdo = $this->database->update($this->table, [
            'comment_num[+]' => 1
        ], [
            'AND' => [
                'id' => $pid,
                'visible[!]' => VISIBLE_DELETE
            ]
        ]);

        $affected = $pdo->rowCount();

        if (!is_numeric($affected) || $affected != 1) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():  error', 500);
        }
    }


    /** 搜索相似的页面
     * @param $word
     * @return array|bool
     * @throws Exception
     */
    public function selectPageLike($word)
    {
        $table_h = DB_PREFIX . "_hint_test";

        $data = $this->database->select($this->table . '(p)', [
            "[>]" . "$table_h" . "(h)" => ['p.id' => 'pid'],
        ], [
            'p.id(pid)',
            'p.title',
            'p.title_pic',
            'p.classification',
            'p.pro_type',
            'p.pro_source',
            'p.comment_num',
        ], [

            'AND' => [
                'OR' => [
                    'p.id[~]'=>$word,
                    'p.title[~]' => $word,
                    'p.answers[~]' => $word,
                    'p.classification[~]' => $word,
                    'h.hint[~]' => $word,
                ],
                'p.visible[!]' => VISIBLE_DELETE
            ],

            "ORDER" => [
                'p.id' => 'DESC'
            ]
        ]);

        //0-n条
        if (!is_array($data)) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():  error', 500);
        }

        return $data;
    }


}