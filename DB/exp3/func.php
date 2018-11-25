<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-11-23
 * Time: 9:21
 */


function showTable(&$database)
{
    $columns = $database->query("SHOW TABLES")->fetchAll();

    foreach ($columns as $col) {
        echo '<a href="./table.php?name=' . $col[0] . '" >';
        echo "$col[0] </a> <br/>";
    }


}


/** 展示表全部数据
 * @param $database
 * @param $table
 */
function showData(&$database, $table)
{

    $columns = $database->query("SHOW COLUMNS FROM $table")->fetchAll();
//$columns里有全部的数据信息

    unset($field_list);
    $field_list = [];

    foreach ($columns as $col) {
        //var_dump（$col）;
        /** col是一个数组 里面包含表内一个字段列的信息
         * 可以用数字或字符索引
         * array(12) {
         * ["Field"]=> string(2) "id"
         * [0]=> string(2) "id"
         * ["Type"]=> string(7) "int(11)"
         * [1]=> string(7) "int(11)"
         * ["Null"]=> string(2) "NO"
         * [2]=> string(2) "NO"
         * ["Key"]=> string(3) "PRI"
         * [3]=> string(3) "PRI"
         * ["Default"]=> NULL
         * [4]=> NULL
         * ["Extra"]=> string(0) ""
         * [5]=> string(0) ""
         * }
         **/

        $field_list[] = $col['Field'];
    }

//    var_dump($field_list);

    echo '<table border="1">';
    echo '<tr>';
    foreach ($field_list as $fie) {
        echo "<th>$fie</th>";
    }

    echo '</tr>';
    getData($database, $table);
    echo '</table>';

}


/** 展示列
 * @param $database
 * @param $table
 */
function showAddTable(&$database, $table)
{

    $columns = $database->query("SHOW COLUMNS FROM $table")->fetchAll();
//$columns里有全部的数据信息

    unset($field_list);
    $field_list = [];

    foreach ($columns as $col) {
        $field_list[] = $col['Field'];
    }

    echo '<form action="./insert.php?name='.$table.'" method="post">';

    echo '<table border="1">';
    echo '<tr>';
    foreach ($field_list as $fie) {
        if($fie == 'id' || $fie == 'visible' || $fie == 'time'){
            continue;
        }
        echo "<th>$fie</th>";
    }
    echo '</tr>';

    foreach ($field_list as  $fie) {
        if($fie == 'id' ||$fie == 'visible'|| $fie == 'time'){
            continue;
        }
        echo "<td>";
        echo ' <input type="text" name="' .$fie.'" /> </td>';
    }

    echo '</table>';
    echo '<input type="submit" value="确认添加" />';
    echo '</form>';
}


/** 展示修改的表格
 * @param $database
 * @param $table
 */
function showEditTable(&$database, $table,$id)
{
    $datas =  $database->query("SELECT *  FROM $table WHERE id = $id")->fetchAll();
    $columns = $database->query("SHOW COLUMNS FROM $table")->fetchAll();
//$columns里有全部的数据信息

    unset($field_list);
    unset($data_list);
    $field_list = [];

    foreach ($columns as $col) {
        $field_list[] = $col['Field'];
    }



    echo '<form action="./update.php?name='.$table.'&id='.$id.'" method="post">';

    echo '<table border="1">';
    echo '<tr>';
    foreach ($field_list as $fie) {
//        if($fie == 'id' || $fie == 'visible' || $fie == 'time'){
//            continue;
//        }
        echo "<th>$fie</th>";
    }
    echo '</tr>';

    $len = sizeof($field_list);
    for($i=0;$i<$len;$i++){

        echo "<td>";
        echo ' <input type="text" name="' .$field_list[$i].'" placeholder = "'.$datas[0][$i].'"/>'
            .'</td>';
    }

    echo '</table>';
    echo '<input type="submit" value="确认修改" />';
    echo '</form>';
}



/** 获取数据
 * @param $database
 * @param $table
 */
function getData(&$database, $table)
{
    $row = $database->query("SELECT * FROM $table WHERE visible > 0")->fetchAll();


    foreach ($row as $r) {
        $len = sizeof($r) / 2;
        echo '<tr>';
        for ($i = 0; $i < $len; $i++) {
            echo "<td>";
            echo '<a href="./detail.php?name=' . $table . '&id=' . $r[0] . '" >';
            echo "{$r[$i]}</a></td>";
        }
        echo "<td>";
        echo '<a href="./edit.php?name=' . $table . '&id=' . $r[0] . '" >';
        echo "修改</td>";

        echo "<td>";
        echo '<a href="./delete.php?name=' . $table . '&id=' . $r[0] . '" >';
        echo "删除</td>";

        echo '</tr>';
    }

}

function jump2UrlInTime($url,$time=0){
    print <<< to
    <head><meta http-equiv="refresh" content=$time;url="$url"></head>
to
    ;
}