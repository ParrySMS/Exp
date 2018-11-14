<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-11-11
 * Time: 23:47
 *
 * From：https://www.jb51.net/article/125610.htm
 *
 */


//所有图形初始化数据，key代表位置，value代表颜色
$xxl = array(
    array('', '', '', '', '', '', '', ''),
    array('', '', '', '', '', '', '', ''),
    array('', '', '', '', '', '', '', ''),
    array('', '', '', '', '', '', '', ''),
    array('', '', '', '', '', '', '', ''),
    array('', '', '', '', '', '', '', ''),
    array('', '', '', '', '', '', '', ''),
    array('', '', '', '', '', '', '', ''),
);

$point = play($xxl, $point);//开始游戏
echo "\n共获得积分数量：{$point}";

/*开始消除
 *$xxl  array 所有图形集合
 *$point int  获得积分数量
*/
$bu = 0;

function play($xxl, $point)
{
    global $bu;
    $bu++;
    echo '=================================开始第' . $bu . '步==================================';
    $color = array(1 => 'red', 2 => 'green', 3 => 'yellow', 4 => 'blue', 5 => 'black');//代表5种颜色
    $samCol = array();//列上相连色块集合
    $nowCol = array();//列上相连色块指针
    $samArr = array();//相连色块总集合
    $group = 1;//组指针

    //随机填充颜色，并获得行上相连色块start
    foreach ($xxl as $line_key => $line) {
        $sam = array();//行上相连色块集合
        $now = 1;//行上相连色块指针
        foreach ($line as $col_key => $data) {
            if (empty($data) || $data == ' ') {
                $data = $xxl[$line_key][$col_key] = array_rand($color);//随机填充颜色
            }

            if (!isset($nowCol[$col_key])) { //未记录
                $nowCol[$col_key] = 1;  //此列有一个x颜色
            }

            if ($line_key === 0) { //第0行
                $samCol[$col_key][$nowCol[$col_key]][$line_key . '-' . $col_key] = array($line_key, $col_key, $data, $line_key . '-' . $col_key . '-' . $data);
                //$samCol[列][ 是否已记录 ][行-列] = [行，列，值，行-列-值]
            } else {
                //非首行
                if ($data != $xxl[$line_key - 1][$col_key]) {//同一列上和前一个颜色不一样
                    $nowCol[$col_key]++; //此列又多一个x颜色 断色了 表示换编号
                }

                $samCol[$col_key][$nowCol[$col_key]][$line_key . '-' . $col_key] = array($line_key, $col_key, $data, $line_key . '-' . $col_key . '-' . $data);
                //$samCol[列][ 是否相连编号 ][行-列] = [行，列，值，行-列-值]
            }


            //同理 第0列
            if ($col_key === 0) {
                $sam[$now][$line_key . '-' . $col_key] = array($line_key, $col_key, $data, $line_key . '-' . $col_key . '-' . $data);
//              $sam[1][行-列] = [行，列，值，行-列-值]

            } else {
                if ($data != $xxl[$line_key][$col_key - 1]) {//同一行上和前一个颜色不一样
                    $now++; //列遍历 断色了 表示换编号
                }

                $sam[$now][$line_key . '-' . $col_key] = array($line_key, $col_key, $data, $line_key . '-' . $col_key . '-' . $data);
//                $sam[相连编号][行-列] = [行，列，值，行-列-值]
            }
        }//  end foreach ($line as $col_key => $data) {

        //获得行上相连色块start
        foreach ($sam as $x => $y) {
            if (count($y) > 2) {//某个相编号下的数据 超过2个 3个以上可消去
                $key = 'R-' . $group; //y[行-列] = [行，列，值，行-列-值]
                foreach ($y as $x2 => $y2) {
                    //x2 = '行-列'
                    //y2 = [行，列，值，行-列-值]
                    $y[$x2]['group']['r'] = $key;
                    // y[行-列]['group']['r'] = 'R-' . $group;
                }
                $samArr += $y;
                $group++;
            }
        }
        //获得行上相连色块end
    }//   foreach ($xxl as $line_key => $line) {

    //随机填充颜色，并获得行上相连色块end

    //获得列上相连色块start
    $group = 1;
    foreach ($samCol as $k => $v) {
        foreach ($v as $x => $y) {
            if (count($y) > 2) {
                $key = 'L-' . $group;
                foreach ($y as $x2 => $y2) {
                    $y[$x2]['group']['l'] = $key;
                    if (isset($samArr[$x2]['group']['r'])) {//判断本点是否已出现在横向组里
                        $samArr[$x2]['group']['l'] = $key;
                    }
                }
                $samArr += $y;
                $group++;
            }
        }
    }
    //获得列上相连色块end

    //查找相连色块start
    $res = array();//相连色块集合
    $hasRes = array();
    foreach ($samArr as $k => $v) {
        if (isset($hasRes[$k])) {
            continue;
        }
        $arr = array();
        seek($samArr, $v, $arr);
        $res[] = array_keys($arr);
        $hasRes += $arr;
    }
    //查找相连色块end
    show($xxl);//打印消除前的图形
    if (empty($res)) {//如果没有相连色块则退出递归
        echo '=================================消除完毕！==================================';
        return $point;
    }
    $thisPoint = countPoint($res);//计算本次消除获得积分
    $point += $thisPoint;//累计到总积分

    //消除相连色块start
    $next = $xxl;
    foreach ($res as $k => $v) {
        foreach ($v as $col_key => $data) {
            $y = $samArr[$data][0];
            $x = $samArr[$data][1];
            $xxl[$y][$x] = '*';
            unset($next[$y][$x]);
        }
    }
    //消除相连色块end

    show($xxl);//打印消除时的图形
    $next = step($next);
    show($next);//打印消除后的图形
    echo "本次消除获得积分数量：{$thisPoint}\n";
    return play($next, $point);
}

/*计算获得积分数量
 *$xxl  array 相连色块集合
 */
function countPoint($xxl)
{
    //初始化积分配置start
    $config = array(3 => 10, 4 => 15, 5 => 20, 6 => 30, 7 => 40, 8 => 70, 9 => 100);
    for ($i = 10; $i <= 64; $i++) {
        $config[$i] = 100 + ($i - 9) * 50;
    }
    //初始化积分配置end
    $point = 0;
    foreach ($xxl as $v) {
        $key = count($v);
        $point += $config[$key];
    }
    return $point;
}

/*消掉并左移
 *$xxl  array 所有图形集合
 */
function step($xxl)
{
    foreach ($xxl as $k => $v) {
        $temp = array_merge($v);
        $count = count($temp);
        if ($count == 8) {
            continue;
        }
        for ($i = $count; $i <= 7; $i++) {
            $temp[$i] = ' ';
        }
        $xxl[$k] = $temp;
    }
    return $xxl;
}

/*找相邻点
 *$xxl  array 相连图形集合
 *$one   array 某一个点
 *$arr   array 图形集合里的相邻的点
*/
function seek($xxl, $one, &$arr)
{
// global $i;
    $near = array();
    $near['up'] = ($one[0] - 1) . '-' . $one[1];//上面的点
    $near['down'] = ($one[0] + 1) . '-' . $one[1];//下面的点
    $near['left'] = $one[0] . '-' . ($one[1] - 1);//左面的点
    $near['right'] = $one[0] . '-' . ($one[1] + 1);//右面的点
    foreach ($near as $v) {
        if (isset($xxl[$v]) && $xxl[$v][2] == $one[2]) {//找到相邻点
            $xj = array_intersect($one['group'], $xxl[$v]['group']);
            if (empty($xj)) {//如果相邻的点不是本组的就跳过
                continue;
            }
            if (isset($arr[$v])) {//如果该点已被遍历过则跳过
                continue;
            }
            $arr[$v] = $xxl[$v];
            seek($xxl, $xxl[$v], $arr);//继续找相邻的点
        }
    }
}

/*打印图形
 *$xxl  array 所有图形集合
 */
function show($xxl)
{
    //顺时针旋转矩阵start
    $arr = array();
    foreach ($xxl as $k => $v) {
        foreach ($v as $k2 => $v2) {
            $arr[7 - $k2][$k] = $v2;
        }
    }
    ksort($arr);
    //顺时针旋转矩阵end
    $str = '';
    foreach ($arr as $v) {
        foreach ($v as $v2) {
            $str .= ' ' . $v2;
        }
        $str .= "\n";
    }
    echo "\n" . $str;
}