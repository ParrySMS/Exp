<?php

function stu_autoload($class){
    if(file_exists($class.".php")){
        require ($class.".php");
    }else{
        die("unable to autoload Class $class");
    }
}

//手动引入框架与配置
require "./Medoo/Medoo.php";
require "./config/params.php";
require "./config/database_info.php";

//手动引入报错
require "./http.php";
//将加载函数注册到PHP中
spl_autoload_register("stu_autoload");