<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-4-27
 * Time: 21:14
 */

//todo: 根据类型生成对应的100题

require '../Http.php';
require '../config/database_info.php';
require '../config/params.php';
require '../config/msg.php';
require '../config/Medoo.php';

require './dao/BaseDao.php';
require './dao/User.php';
require './dao/Action.php';

require './func/check.php';

const DATAS_NUM = 100;//一次请求拿到的题目数量

$http = new Http();

//记录
action();
$app = isset($_GET['appKey']) ? $_GET['appKey'] : null;
$account = isset($_GET['account']) ? $_GET['account'] : null;
$sign = isset($_GET['sign']) ? $_GET['sign'] : null;
$type = isset($_GET['type']) ? $_GET['type'] : null;

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
    if (!isEmail($account)) {
        throw new Exception('account params error', 400);
    }

    //查type
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
    if ($sign === TEST_SIGN) {
        //TODO:拿1个题重复100次组成返回--写func里
    } else {//正式申请
        //todo 查sign有效---用account用户visible和有效时间--写user里
        //todo 读对应json 取前N题 打乱返回---写func里
    }


} catch (Exception $e) {
    action($account, $e->getCode());
    $http->status($e->getCode());
    echo $e->getMessage();
}