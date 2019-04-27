<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-4-26
 * Time: 13:10
 */


//无限时
set_time_limit(0);

//预定义的类目常量
const TYPE_ARR = ['logic', 'diagram', 'verbal', 'seq'];
//TranSet-<typename>.json
const FILENAME_TEST_SET = 'TestSet';
const FILENAME_TEST_SET_IDS ='TestSetIds';

try {
    if (empty(TYPE_ARR)) {
        throw new Exception("const TYPE_ARR need array", 500);
    }

    //读入文件 转为json 去除答案 写出文件

    foreach (TYPE_ARR as $param_t) {//针对每个类别

        $file_suffix = "-$param_t.json";

        $file = './' . FILENAME_TEST_SET . $file_suffix;

        $file_steam = fopen($file, "r") or die("Unable to open file:" .$file);
        $file_datas =json_decode(fread($file_steam,filesize($file)));
        fclose($file_steam);

        //清除数据
        $test_ids = [];
        foreach ($file_datas as & $pro){

            if(!isset($pro->answers)){
                echo $pro->id.' no answers'.PHP_EOL;
                continue;
            }

            unset($pro->answers);
            unset($pro->hint);
            $test_ids[] = $pro->id;
        }

        //当前目录下的文件
        $newfile ='./clear-'.FILENAME_TEST_SET . $file_suffix;

        $file_steam = fopen($newfile, "w") or die("Unable to open file:" .$newfile);
        fwrite($file_steam,json_encode($file_datas));
        fclose($file_steam);

        echo $file.' -- clear --> '.$newfile.PHP_EOL;

        $idsfile ='./'.FILENAME_TEST_SET_IDS . $file_suffix;
        $file_steam = fopen($idsfile, "w") or die("Unable to open file:" .$idsfile);
        fwrite($file_steam,json_encode($test_ids));
        fclose($file_steam);

        echo $file.' -- ids --> '.$idsfile.PHP_EOL;
    }

} catch (Exception $e) {
    echo $e->getMessage();
}
