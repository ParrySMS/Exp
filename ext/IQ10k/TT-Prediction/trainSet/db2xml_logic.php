<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-4-23
 * Time: 18:09
 */

require '../Http.php';
require '../config/database_info.php';
require '../config/params.php';
require '../config/Medoo.php';
require './BaseDao.php';


set_time_limit(0);

try {
    $pro_source =

} catch (Exception $e) {
    echo $e->getMessage();
}


function getDatas($pro_source)
{
    $dao = new BaseDao();
    $database = $dao->getDatabase();

    $datas = $database->select($dao::$T_PROBLEM . '(p)', [
        "[>]" . $dao::$T_HINT . "(h)" => ['p.id' => 'pid']
    ], [
        'p.id',
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
    ], [
        'AND' => [
//            'p.id'=>[4572,4665,4734,4006,3197,3198,3199], //for test
            'p.pro_source' => $pro_source,
            'p.visible' => VISIBLE_NORMAL,
            'p.language'=>
        ],
//        "LIMIT" => 10
    ]);

    foreach ($datas as & $pro_data) {
        //先获取在主体题目信息（可能有hint）

        $pro_data['answers'] = json_decode($pro_data['answers']);
        //然后获取选项信息
        $oids = json_decode($pro_data['option_ids']);
        //对象数组
        $pro_data['options'] = [];

//        var_dump($pro_data);

        if (is_array($oids) && sizeof($oids) != 0) {
            $pro_data['options'] = getOptions($oids, $database, $dao::$T_OPTION);
        }

        //clear
        unset($pro_data['option_ids']);

        $pro_data['title_content'] = getTitleContent($pro_data['title']);

    }

    return $datas;
}
