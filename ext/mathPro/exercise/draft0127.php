<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-1-27
 * Time: 9:35
 */

$ter = fopen('php://stdin','r');

/**
//--------- R-S-P GAME
echo '1:rock, 2:sci, 3:paper'.PHP_EOL;

echo 'A player input:'.PHP_EOL;
$a = (int)fgets($ter);

echo 'B player input:'.PHP_EOL;
$b = (int)fgets($ter);
$b = -1*$b;
//params check

if($a + $b == 0) {
    echo 'draw'.PHP_EOL;

}else if($a%3+$b == -1) {
    echo 'A win'.PHP_EOL;

}else {
    echo 'B win'.PHP_EOL;
}

echo 'finish'.PHP_EOL;
 **/


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

fclose($ter);
