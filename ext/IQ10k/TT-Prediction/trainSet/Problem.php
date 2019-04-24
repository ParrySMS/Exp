<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-4-24
 * Time: 17:23
 */


class Problem extends BaseDao
{
    const CH_PATTERN = '/[\x{4e00}-\x{9fa5}]/u';
    /** 根据类型抽取有效的全部数据出来
     * @param $pro_source
     * @return array|bool
     * @throws \Exception
     */
    public function getDatas($pro_source): array
    {
        //先获取在主体题目信息（可能有hint）
        $datas = $this->database->select($this::$T_PROBLEM . '(p)', [
            "[>]" . $this::$T_HINT . "(h)" => ['p.id' => 'pid']
        ], [
//            'p.id',
            'p.title',
            'p.title_pic',
            'p.option_ids',
            'p.answers',//这个是json
//        'p.language',
            'p.classification(subtype)',
            'p.pro_type',
            'p.pro_source(type)',
//        'p.time',
//        'p.edit_time',
//        'p.total_edit',
//            'p.comment_num',
            'h.hint',
            'h.pid',
            'h.visible'
        ], [
            'AND' => [
                'p.pro_source' => $pro_source,
                'p.visible' => VISIBLE_NORMAL,
                'p.language' => "en",
            ]
//        "LIMIT" => 10
        ]);

        if (empty($datas)) {
            throw new Exception('$datas empty. line:' . __LINE__ . '---' . __CLASS__ . '->' . __FUNCTION__ . '(): error', 500);
        }

        foreach ($datas as & $pro_data) {//引用传递改值

            //然后获取选项信息
            $oids = json_decode($pro_data['option_ids']);
            //对象数组
            $pro_data['options'] = [];
            if (is_array($oids) && sizeof($oids) != 0) {
                $pro_data['options'] = $this->getOptions($oids);
            }

            //clear
            unset($pro_data['option_ids']);

            //clear char
            $pro_data['title'] = trim($pro_data['title']);
            $pro_data['title'] = str_replace("\u3000", " ",$pro_data['title']);
            $pro_data['title'] = str_replace("\\&quot", '\"',$pro_data['title']);
            //中文检查
//            $pattern = '/[\x{4e00}-\x{9fa5}]/u';
            if(preg_match($this::CH_PATTERN,$pro_data['title'], $match)){
               throw new Exception('$pro_data[\'title\'] '.$pro_data['title'].' has CH char,pid ='.$pro_data['pid'].
                   ' line:' . __LINE__ . '---' . __CLASS__ . '->' . __FUNCTION__ . '(): error', 500);
           }

            if(!empty($pro_data['hint'] && $pro_data['visible']==VISIBLE_NORMAL)){
//                \\&quot;
//                \u3000
                $pro_data['hint'] = trim( $pro_data['hint']);
                $pro_data['hint'] = str_replace("\u3000", " ",$pro_data['hint']);
                $pro_data['hint'] = str_replace("\\&quot", '\"',$pro_data['hint']);
                //中文检查
                if(preg_match($this::CH_PATTERN,$pro_data['hint'], $match)){
                    throw new Exception('$pro_data[\'hint\'] '. $pro_data['hint'] .' has CH char. hid-->pid ='.$pro_data['pid'].' line:' . __LINE__ . '---' . __CLASS__ . '->' . __FUNCTION__ . '(): error', 500);
                }
            }

        }

        return $datas;
    }


    /** 根据oid数组拿到option数据 并且封装变成指定格式的 options 数组
     * @param array $option_ids
     * @throws \Exception
     */
    public function getOptions(array $option_ids): array
    {
        $datas = $this->database->select($this::$T_OPTION, [
            'id',
            'key',
            'content',
            'is_pic'
        ], [
            'AND' => [
                'id' => $option_ids,
                'visible' => VISIBLE_NORMAL
            ]
        ]);

        //多条
        if (!is_array($datas) || sizeof($datas) == 0) {
            throw new Exception('line:' . __LINE__ . '---' . __CLASS__ . '->' . __FUNCTION__ . '(): error', 500);
        }

        unset($options);
        $options = [];

        foreach ($datas as &$d) {
            $d['content'] = trim($d['content']);
            $d['content'] = str_replace("\u3000", " ",$d['content']);
            $d['content'] = str_replace('\\&quot', '\"',$d['content']);
            //中文检查
            if(preg_match($this::CH_PATTERN,$d['content'], $match)){
                throw new Exception('$d[\'content\'] '.$d['content'].' has CH char,oid = '.$d['id'].'. line:' . __LINE__ . '---' . __CLASS__ . '->' . __FUNCTION__ . '(): error', 500);
            }
        }
        return $options;

    }

}