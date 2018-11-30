<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-11-30
 * Time: 21:42
 */

class Seq
{

    protected $database;

    static $T_ACTION = DB_PREFIX . '_action';
//    static $T_COMMENT = DB_PREFIX . "_comment_test";
    static $T_COMMENT = DB_PREFIX . "_comment_adddiagramspecial";
//    static $T_HINT = DB_PREFIX . "_hint_test";
    static $T_HINT = DB_PREFIX . "_hint_adddiagramspecial";
    static $T_OPTION = DB_PREFIX . "_option_adddiagramspecial";
    static $T_PROBLEM = DB_PREFIX . "_problem_adddiagramspecial";

    //trans
    static $T_TRANS_PROBLEM = DB_PREFIX . "_problem_cetrans_not_en";
    static $T_TRANS_OPTION = DB_PREFIX . "_option_cetrans";
    static $T_TRANS_HINT = DB_PREFIX . "_hint_cetrans";

    /**
     * @return \Medoo\Medoo
     */
    public function getDatabase()
    {
        return $this->database;
    }


    /**
     * BaseDao constructor.
     */
    public function __construct()
    {
        $this->database = new  Medoo\Medoo([
            'database_type' => DATABASE_TYPE,
            'database_name' => DATABASE_NAME,
            'server' => SERVER,
            'username' => USERNAME,
            'password' => PASSWORD,
            'charset' => CHARSET,
            'port' => PORT,
            'check_interval' => CHECK_INTERVAL
        ]);
    }


    //todo 获取有效的id集合 用于抽取固定的题目数量
    public function getVaildId(){

    }
    /** 获取db里的某些固定id的seq数据
     * @param array $ids  选取这个id集合里面的数据
     * @return array|bool
     * @throws Exception
     */
    public function getDatasInSet(array $ids)
    {

        $datas = $this->database->select($this::$T_PROBLEM . '(p)', [
            "[>]" . $this::$T_HINT . "(h)" => ['p.id' => 'pid']
        ], [
            'p.id',
            'p.title',
            'p.title_pic',
            'p.option_ids',
//            'p.answers',//这个是json
//        'p.language',
            'p.classification(subtype)',
            'p.pro_type',
            'p.pro_source(type)',
//        'p.time',
//        'p.edit_time',
//        'p.total_edit',
//            'p.comment_num',
//            'h.hint',
        ], [
            'AND' => [
                'p.id'=>$ids, //for test
                'p.pro_source' => 'new-test-seq',
                'p.visible[!]' => VISIBLE_DELETE
            ],
//        "LIMIT" => 10
        ]);

        foreach ($datas as & $pro_data) {
            //先获取在主体题目信息（可能有hint）

//            $pro_data['answers'] = json_decode($pro_data['answers']);
            //然后获取选项信息
            $oids = json_decode($pro_data['option_ids']);
            //对象数组
            $pro_data['options'] = [];

//        var_dump($pro_data);

            if (is_array($oids) && sizeof($oids) != 0) {
                $pro_data['options'] = getOptions($oids, $this->database, $this::$T_OPTION);
            }

            //clear
            unset($pro_data['option_ids']);

            $pro_data['title_content'] = getTitleContent($pro_data['title']);

        }

        return $datas;
    }


    /** 包装选项数组
     * @param $oids
     * @param \Medoo\Medoo $database
     * @param $table
     * @return array
     * @throws Exception
     */
    public function getOptions($oids,\Medoo\Medoo & $database, $table)
    {


        $datas = selectGroup($oids, $database, $table);

        unset($options);
        $options = [];

        foreach ($datas as $d) {
            $options[] = (object)$d;
        }

        return $options;
    }


    /** 获取选项
     * @param array $option_ids
     * @param \Medoo\Medoo $database
     * @param $table
     * @return array|bool
     * @throws Exception
     */
    public function selectGroup(array $option_ids, \Medoo\Medoo & $database, $table)
    {
        $data = $database->select($table, [
//        'id',
            'key',
            'content',
            'is_pic'
        ], [
            'AND' => [
                'id' => $option_ids,
                'visible[!]' => VISIBLE_DELETE
            ]
        ]);

        //多条
        if (!is_array($data) || sizeof($data) == 0) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '(): error', 500);
        }

        return $data;

    }


}