<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-2
 * Time: 14:07
 */


$cmd=fopen("php://stdin", "r");//打开命令行的输入文件流 用于读入输入的参数


echo 'choose menu: 1 --> rps, 2 -->numgame, e of q  -->exit';

$menu_var = fgets($cmd);

if($menu_var == 'e' || $menu_var == 'q'){
    echo 'exit'.PHP_EOL;

}else if ((int)$menu_var == 1 ){

//fscanf(STDIN,"%d %d",$a,$b); //此代码表示，按照指定格式 整数 空格 整数 读取两个整数变量到a和b里，不再需要用fget逐行读取

    echo 'A player:'.PHP_EOL; //输出字符串 并且换行
    echo '1 mean rock, 2 mean paper, 3 mean scissors'.PHP_EOL;
    $a = fgets($cmd);//获取A输入的参数

    echo 'B player:'.PHP_EOL; // 输出字符串并且换行
    echo '1 mean rock, 2 mean paper, 3 mean scissors'.PHP_EOL;
    $b = fgets($cmd);//获取B输入的参数
    $b = -1*$b; //取反

    echo "A is $a and B is $b".PHP_EOL;

    if($a + $b == 0){
        echo 'draw';
    }else if($a%3 + $b== -1){
        echo 'A win';
    }else{
        echo 'B win';
    }

    echo PHP_EOL.'Game Over'.PHP_EOL;


}

else{

//--------- GUESS GAME -------------

//-----------A
    echo 'A:choose a num from [1-6]'.PHP_EOL;
    $a_self_value = (int)fgets($ter);

    echo 'guess B num from [1-6]:'.PHP_EOL;
    $a_guess_value = (int)fgets($ter);

    echo 'guess B is odd (1:yes,0:no)'.PHP_EOL;
    $a_guess_odd = (int)fgets($ter);

//----------B
    echo 'B:choose a num from [1-6]'.PHP_EOL;
    $b_self_value = (int)fgets($ter);

    echo 'guess A num from [1-6]:'.PHP_EOL;
    $b_guess_value = (int)fgets($ter);

    echo 'guess A is odd (1:yes,0:no)'.PHP_EOL;
    $b_guess_odd = (int)fgets($ter);


//--------input--------

    $a_point = 0;
    $b_point = 0;
//check b guess value
    if($a_self_value == $b_guess_value){// b guess a
        $b_guess_value_res = true;
        echo 'B guess value true'.PHP_EOL;
        $b_point += 3;
    }else{
        $b_guess_value_res = false;
        echo 'B guess value false'.PHP_EOL;
    }

//check a odd
    if($a_self_value%2 == 0){
        //a is even
        $a_odd = 0;
    }else{
        $a_odd = 1;
    }

//check b guess odd
    if($a_odd == $b_guess_odd){
        $b_guess_odd_res = true;
        echo 'B guess odd true'.PHP_EOL;
//    $b_point += 1;
        $b_point ++;
    }else{
        $b_guess_odd_res = false;
        echo 'B guess odd false'.PHP_EOL;
    }

//check B point
    if($b_guess_value_res && $b_guess_odd_res){
        $b_point ++;
    }

//------------------------



//check a guess value
    if($b_self_value == $a_guess_value){// a guess b
        $a_guess_value_res = true;
        echo 'A guess value true'.PHP_EOL;
        $a_point += 3;
    }else{
        $a_guess_value_res = false;
        echo 'A guess value false'.PHP_EOL;
    }

//check b odd
    if($b_self_value%2 == 0){
        //b is even
        $b_odd = 0;
    }else{
        $b_odd = 1;
    }

//check a guess odd
    if($b_odd == $a_guess_odd){
        $a_guess_odd_res = true;
        echo 'A guess odd true'.PHP_EOL;
        $a_point ++;
    }else{
        $a_guess_odd_res = false;
        echo 'A guess odd false'.PHP_EOL;
    }

//check A point
    if($a_guess_value_res && $a_guess_odd_res){
        $a_point ++;
    }


    echo "A point:$a_point".PHP_EOL;
    echo "B point:$b_point".PHP_EOL;

    echo 'finish'.PHP_EOL;
}


fclose($cmd);//关闭命令行的输入流
