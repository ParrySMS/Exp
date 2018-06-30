<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-5-28
 * Time: 16:58
 */
require "./Func.php";
require "./Count.php";

//$funcStr = $_POST['func'];
$funcStrArray = [
    '(sub 1 0)',
    '(sub 1 (mul 0 2))',
    '(or (add 1 2) 1)',
    '(sub 2 (mul 4 (add (div 1 2) (add 3 4))))',
    '(div 6 0)',
    '(add 2 (div 6 0))',
    '(not 5)',
    '(not F)',
    //  '(or (add 5 3) T)',
    '(and T F)',
    '(gt (add 5 3) (sub 5 3))',
    '(gt (add 5 3) (lt 5 3))'

];

try {
    foreach ($funcStrArray as $funcStr) {
        echo $funcStr;
        echo " ----> ";
//move ( and )
        $funcStr = str_ireplace('(', '', $funcStr);
        $funcStr = str_ireplace(')', '', $funcStr);
//new func
        unset($func);
        $func = new Func();
        $func->name = strtok($funcStr, " ");

        $cfunc = getFunc($func);
//        var_dump($func);

        func2C($cfunc);
        //echo "<br/>";
        //echo "<br/>";
        echo ' = ';
        //输出类型结果
        $res = countFunc($cfunc);
        if ($res == 'e') {
           $out = 'error';
        }elseif (is_numeric($res)){
            $out = 'int';
        }elseif (in_array($res,['T','F'])){
            $out = 'bool';
        }
        echo $out;


        echo "<br/>";
        echo "<br/>";
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
/**
 * @param Func $func
 * @return Func
 */
function getFunc(Func $func)
{

    //param1
    $p1 = strtok(" ");
//    echo "p1 = $p1<br/>";
    if (is_numeric($p1) || in_array($p1, ['T', 'F'])) {//如果是参数 则存入
        $func->params1 = $p1;
    } else {//不是参数，则作为一个树的子叶节点进行遍历
        $func->params1 = new Func();
        $func->params1->name = $p1;
        $func->params1 = getFunc($func->params1);
    }

    if ($func->name == 'not') {
        $func->params2 = null;
    } else {
        //param2
        $p2 = strtok(" ");
        if (is_numeric($p2) || in_array($p1, ['T', 'F'])) {
//        echo "p2 = $p2<br/>";
            $func->params2 = $p2;
        } else {
            $func->params2 = new Func();
            $func->params2->name = $p2;
            $func->params2 = getFunc($func->params2);
        }
    }
    return $func;
}


function func2C(Func $func)
{
    echo $func->name;
    echo '(';
    //param1
    $p1 = $func->params1;
    if (is_numeric($p1) || in_array($p1, ['T', 'F'])) {//如果是第一个参数，则直接输出
        echo $p1;
    } else {
        func2C($p1);//如果不是参数，则将节点遍历

    }
    if ($func->name == 'not') {
        echo ')';
    } else {
        echo ',';
        //param2
        $p2 = $func->params2;
        if (is_numeric($p2) || in_array($p1, ['T', 'F'])) {//如果是第二个参数，则直接输出
            echo $p2;
            echo ')';
        } else {
            func2C($p2);//如果不是参数，则将节点遍历
            echo ')';
        }
    }

}

function countFunc(Func $func)
{
    $name = $func->name;

    switch ($name) {
        case 'and' :
            $funcName = 'FunAnd';
            break;
        case 'or' :
            $funcName = 'FunOr';
            break;
        case 'not' :
            $funcName = 'FunNot';
            break;
        default:
            $funcName = $name;

    }

    $p1 = $func->params1;
    if ($p1 != 'e' && !is_numeric($p1) && !in_array($p1, ['T', 'F'])) {
        $p1 = countFunc($p1);
//        echo "p1->";
//        var_dump($p1);
    }

    if ($funcName == 'FunNot') {
        $p2 = 'T';
    } else {
        $p2 = $func->params2;
        if ($p2 != 'e' && !is_numeric($p2) && !in_array($p1, ['T', 'F'])) {
            $p2 = countFunc($p2);
//        echo "p2->";
//        var_dump($p2);
        }
        //p1 p2 is params
    }
    unset($count);
    $count = new Count($funcName, $p1, $p2);
//    echo "<br/> $funcName:$p1 $p2 = $count->res <br/><br/>";
    return $count->res;
}

