<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-8-22
 * Time: 1:08
 */

namespace tlApp\dao;


class Comment extends BaseDao
{
    protected $table = DB_PREFIX . "_comment_test";

    /** todo 查入数据 visible用常量 time也用常量 插入之后要检查 异常直接throw Exception里的内容参考其他 500报错都是一样的
     * @param $pid
     * @param $comment
     * @return int
     * @throws Exception
     */
    public function insert($pid, $comment)
    {
        //todo 写一个插入
        //id主键自增  uid pid comment time visible
    }

}