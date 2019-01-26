<?php

/**
 * 输入三个整数 输出他们的平均值 保留3位小数
 * @param  int    $x 
 * @param  int    $y 
 * @param  int    $z 
 * @return [float]   
 */
function average(int $x,int $y,int $z):float
{
	$num = ($x+$y+$z)/3.0;


	return round($num,3); //法1
	// return number_format($num, 3); //法 2
	// return sprintf("%.3f",$num);  //法3
}

function temperature(int $f):float
{
	$c = 5*($f-32)/9.0;

	return round($c,3); //法1
	// return number_format$$c, 3); //法 2
	// return sprintf("%.3f",$c);  //法3
}


function sumN(int $n):int
{
	return (1+$n)*$n/2; //求和公式
}


function sincos（int $angle,bool $return_array = false)
{
	$sin = sin($angle);
	$cos = cos($angle);

	echo "sin:$sin".PHP_EOL;
	echo "cos:$cos".PHP_EOL;

	if($return_array){
		return [$sin,$cos];
	}
}


function distance(double $x1,double $y1,double $x2, double $y2):float
{
	return sqrt(pow($x1-$x2, 2) + pow($y1-$y2, 2));
}


function odd1(int $num,bool $return_bool = false)
{
	$res = $num%2==0 ? 'yes' : 'no';
	
	echo $res.PHP_EOL;

	if($return_bool){
		return $num%2==0;
	}

}


function odd2(int $num,bool $return_bool = false)
{
	$last_num = substr((string)$num, -1);

	switch ($last_num) {
		case '1':
		case '3':
		case '5':
		case '7':
		case '9':
			echo 'yes'.PHP_EOL;
			if($return_bool){
				return true;
			}
			break;
		
		case '0':
		case '2':
		case '4':
		case '6':
		case '8':
			echo 'no'.PHP_EOL;
			if($return_bool){
				return false;
			}
			break;
	}

}


function discount(int $num,float $price_per_unit = 95,float $price_get_discount = 300,float $discount = 0.85):float
{
	$sum = $num*$price_per_unit;

	return $sum<300 ? round($sum,2) : round(0.85*$sum,2); 

}

function absNum(float $num):float
{
	return $num<0 ? -1*round($num,2) : round($num,2); 
}

function triangle(int $a,int $b,int $c,$return_bool = false)
{	
	//先找斜边--最长边
	//然后 勾股定理
	

}