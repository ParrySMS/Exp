<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-4-27
 * Time: 21:14
 */

// 根据类型生成对应的100题

require '../Http.php';
require '../config/database_info.php';
require '../config/params.php';
require '../config/msg.php';
require '../config/Medoo.php';

require './dao/BaseDao.php';
require './dao/User.php';
require './dao/Action.php';
require './dao/Problem.php';

require './func/check.php';

const DATAS_NUM = 100;//一次请求拿到的题目数量
const FILENAME_TEST_SET_IDS = 'TestSetIds';
//无限时
set_time_limit(0);


//记录
$app = isset($_GET['appKey']) ? $_GET['appKey'] : null;
$account = isset($_GET['account']) ? $_GET['account'] : null;
$sign = isset($_GET['sign']) ? $_GET['sign'] : null;
$type = isset($_GET['type']) ? $_GET['type'] : null;

action($account);
$http = new Http();

try {

    //参数检查
    if (empty($app) || empty($sign) || empty($type)) {
        throw new Exception('params empty', 400);
    }

    //查appkey
    if ($app !== APPKEY_TU) {
        throw new Exception('appKey params error', 400);
    }

    //查accout
    strCheck($account);
    if (!isEmail($account)) {
        throw new Exception('account params error', 400);
    }


    //查type
    strCheck($type);
    if (!is_numeric($type)) {
        throw new Exception('type params error', 400);
    }

    switch ($type) {
        case 1 :
            $typename = 'logic';
            break;
        case 2 :
            $typename = 'diagram';
            break;
        case 3 :
            $typename = 'verbal';
            break;
        case 4 :
            $typename = 'seq';
            break;
        default :
            throw new Exception('type params invalid', 400);
    }

    //查sign
    if ($sign == TEST_SIGN) {
        //拿1个题重复100次组成返回--写func里
//        $file = './'.FILENAME_DEMO_OBJ;  文件流太慢了 超出响应时间
//        getDemoDatas();//默认直接输出
        //不用函数 可能是栈空间问题

        //手动拼凑json 纯字符操作
        $json = trim(DEMO_PRO_JSON);
        $demo_obj = json_decode($json);
        $json = json_encode($demo_obj); //消除换行符等无关字符
        echo '[';
        for ($i = 0; $i < DATAS_NUM - 1; $i++) {
            echo $json . ',';
        }
        echo $json . ']';


    } else {//正式申请

        //查sign有效
        signValidCheck($account, $sign);

        //查每天限制次数 对应urilog 进入次数 非错误情况
        if(isLimited($account)){
            throw new Exception('Access has been restricted', 403);
        }

        //读对应json 用ids 取打乱返回
        $file_suffix = "-$typename.json";
        $ids_file = './' . FILENAME_TEST_SET_IDS . $file_suffix;
        //todo: 文件流读ids 再去数据库取太慢了 要考虑一个保密性好的又快的方案（新建临时表? 还没想好）
        $ids = getIdsByFile($ids_file);
        getTestDatas($ids, $typename);
    }

} catch (Exception $e) {
    action($account, $e->getCode(),$e->getMessage());
    $http->status($e->getCode());
    echo $e->getMessage();
}