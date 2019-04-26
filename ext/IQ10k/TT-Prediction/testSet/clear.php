<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-4-26
 * Time: 13:10
 */


set_time_limit(0);

//预定义的类目常量
const TYPE_ARR = ['logic', 'diagram', 'verbal', 'seq'];
//TranSet-<typename>.json
const FILENAME_TRAIN_SET = 'TranSet';
const FILENAME_NON_TRAIN_SET = 'NonTranSet';
const FILENAME_TEST_SET = 'TestSet';
const FILE_PATH = '../trainSet/';
try {
    if (empty(TYPE_ARR)) {
        throw new Exception("const TYPE_ARR need array", 500);
    }

    foreach (TYPE_ARR as $param_t) {

        $file_suffix = "-$param_t.json";
        //todo: 读入文件 转为json 去除答案 写出文件
        $file_datas = fopen(FILE_PATH . FILENAME_TRAIN_SET . $file_suffix, "r")
        or die("Unable to open file:" . FILE_PATH . FILENAME_TRAIN_SET . $file_suffix);


    }

} catch (Exception $e) {
    echo $e->getMessage();
}
