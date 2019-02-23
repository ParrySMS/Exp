<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-23
 * Time: 16:23
 */

class Refer extends Db
{
    protected $table = 'ma_refer';

    /** 根据rid 找对应的推荐内容
     * @param int $rid
     * @return array
     * @throws Exception
     */
    public function getNameContent(int $rid):array
    {
        $datas = $this->getDatabase()->select($this->table,[
            'name',//类别名
            'content'
        ],[
            'rid'=>$rid,
            'visible[!]'=>REFER_INVALID
        ]);

        if(!is_array($datas) || sizeof($datas)!=1){
            throw new Exception(__FUNCTION__ . '():error');

        }

        return $datas[0];
    }

}