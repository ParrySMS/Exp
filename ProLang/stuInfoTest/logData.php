<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-4-6
 * Time: 15:37
 */

require "Medoo.php";
require "database_info.php";
$table = DB_PREFIX . "_stuInfo_testlog";

$database = new \Medoo\Medoo([
    'database_type' => DATABASE_TYPE,
    'database_name' => DATABASE_NAME,
    'server' => SERVER,
    'username' => USERNAME,
    'password' => PASSWORD,
    'charset' => CHARSET,
    'port' => PORT,
    'check_interval' => CHECK_INTERVAL
]);

$type ='stuInfoFunc/sortInfo.php/score/100';

unset($data);
$data = $database->select($table,[
    "id",
    "type",
    "dbtime",
    "exctime"
],[
    "AND"=>[
        "type"=>$type,
        "visible"=>1
    ]
]);


function table($id,$type,$dbtime,$exctime){
 print <<<TAB
  <tr>
    <td>$id</td>
    <td>$type</td>
      <td>$dbtime </td>
     <td>$exctime </td>
  </tr>

TAB;

}
?>
<table border="1">
  <tr>
    <th>id</th>
     <th>type</th>
    <th>dbtime/ms </th>
     <th>exctime/ms </th>
  </tr>
    <?php
    foreach ($data as $d){
      table($d['id'],$d['type'],$d['dbtime'],$d['exctime']);
    }
    ?>
</table>