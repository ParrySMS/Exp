<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-12-5
 * Time: 19:33
 */

class File
{

    public $path;
    public $io;
    public $rows = [];//用行的形式保存文件

    /**
     * File constructor.
     * @param $path
     */
    public function __construct($path)
    {
        $this->path = $path;
        $this->io = fopen($path, 'r');
        $this->readFileInRows();

    }


    public function __destruct()
    {
        fclose($this->io);
    }


    /**
     * 将文件内容逐行读入变量里
     */
    private function readFileInRows()
    {
        while (!feof($this->io)) { //文件1和文件2的逐行比较
            $regex = '/ *|\s*|\r*|\n*|\t*/';
            $t = (string)preg_replace($regex, "", trim(fgets($this->io)));;
            echo 'read:line '.$t.PHP_EOL;
            $this->rows[] = $t;
        }
    }


    /** 计算两个行的相似度
     * 使用LCS算法
     * @param $row1 string
     * @param $row2 string
     */
    public function checkSimi($row1, $row2)
    {
//        $row1 = (string)$row1;
//        $row2 = (string)$row2;

        $mx_num = [];//记录最长相同数目 0表示边界 从1开始
        $mx_step = [];//记录步骤方法 标记子问题方向
        //-1表示空 左上斜:0 , 左:1 ,上:2, 左或上:3

        //初始化
        $len1 = strlen($row1);
        $len2 = strlen($row2);
        for ($i = 0; $i < $len1 + 1; $i++) {
            $mx_num = [];
            $mx_step = [];
        }

        //计算两个行里的逐个字符
        for ($i = 0; $i < $len1 + 1; $i++) {
            for ($j = 0; $j < $len2 + 1; $j++) {

//                echo "char1:".substr($row1,$i - 1,1).PHP_EOL;
//                echo "char2:".substr($row2,$j - 1,1).PHP_EOL;

                if ($i==0 || $j==0) { //i j其中一个是0 边界
                    $mx_num[$i][$j] = 0;
                    $mx_step[$i][$j] = -1;

                    //字符串从1开始
                } elseif (substr($row1,$i - 1,1)
                    == substr($row2,$j - 1,1) ){//字符相等


                    $mx_num[$i][$j] = $mx_num[$i - 1][$j - 1] + 1;
                    $mx_step[$i][$j] = 0; // 指向上一个子问题 左上斜

                } else {//字符不相等
                    //取max{[i-1,j], [i,j-1]}

                    if ($mx_num[$i - 1][$j] == $mx_num[$i][$j - 1]) {
                        //切除row1和row2都可以
                        $mx_num[$i][$j] = $mx_num[$i - 1][$j];
                        $mx_step[$i][$j] = 3; // 左或上

                    } else if ($mx_num[$i - 1][$j] > $mx_num[$i][$j - 1]) {
                        //切row1
                        $mx_num[$i][$j] = $mx_num[$i - 1][$j];
                        $mx_step[$i][$j] = 1; // 左

                    } else { //$mx_num[i-1,j] < $mx_num[i,j-1]
                        //切row2
                        $mx_num[$i][$j] = $mx_num[$i][$j - 1];
                        $mx_step[$i][$j] = 2; // 上
                    }

                }//字符不相等

            }//j

        }//for

        $min_len = $len1 > $len2 ? $len2 : $len1;

        if ($min_len>0) { //计算LCS的相似度
            return ((float)$mx_num[$len1][$len2]) / $min_len;
        } else {//分母0
            return 0;
        }

    }

}

<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-12-5
 * Time: 19:44
 */
require 'File.php';

$path1 = 'check.cpp';
$path2 = 'test3.md';
//相似度
define('SIMILARITY',0.75);
define('ECHO_DIJ',true);


$file1 = new File($path1);
$file2 = new File($path2);

$mx_d = [];//Dij的二维数组
$line_num1 = sizeof($file1->rows); //标记的行数
$line_num2 = sizeof($file2->rows);

//LCS 拿到Dij
for ($i = 0; $i < $line_num1; $i++) {
    for ($j = 0; $j < $line_num2; $j++) {

        $row1 = $file1->rows[$i];
        $row2 = $file2->rows[$j];
        $simi = $file1->checkSimi($row1, $row2);
        //拿到Dij矩阵
        $mx_d[$i][$j] = $simi > SIMILARITY ? 1 : 0;


    }
}

if (ECHO_DIJ) {
    echo 'Dij:' . PHP_EOL;
    for ($i = 0; $i < $line_num1; $i++) {
        for ($j = 0; $j < $line_num2; $j++) {
            echo json_encode($mx_d[$i][$j]);
        }
        echo PHP_EOL;
    }
}

$repeated = repeatedLine($mx_d,$file1,$file2);

echo 'file1 Rows:'.$line_num1.PHP_EOL;
echo 'file2 Rows:'.$line_num2.PHP_EOL;
echo 'repeated:'.$repeated.PHP_EOL;




/** 计算两个文件的相似行数
 * @param array $d 之前得到相似行矩阵 Dij
 * @param File $f1
 * @param File $f2
 */
function repeatedLine(array $d,File $f1,File $f2){
    $file_rows1 = $f1->rows;
    $file_rows2 = $f2->rows;

    //同理 把文件看做是行的连串 每个行看做一个单元字符

    $mx_num = [];//记录最长相同数目 0表示边界 从1开始
    $mx_step = [];//记录步骤方法 标记子问题方向
    //-1表示空 左上斜:0 , 左:1 ,上:2, 左或上:3

    //初始化
    $len1 = sizeof($file_rows1);
    $len2 = sizeof($file_rows2);
    for ($i = 0; $i < $len1 + 1; $i++) {
        $mx_num = [];
        $mx_step = [];
    }

    //计算两个文件里的逐个行
    for ($i = 0; $i < $len1 + 1; $i++) {
        for ($j = 0; $j < $len2 + 1; $j++) {

            if (!$i || !$j) { //i j其中一个是0 边界
                $mx_num[$i][$j] = 0;
                $mx_step[$i][$j] = -1;

                //字符串从1开始
            } elseif ($d[$i - 1][$j - 1] == 1) {//行相等 Dij = 1
                $mx_num[$i][$j] = $mx_num[$i - 1][$j - 1] + 1;
                $mx_step[$i][$j] = 0; // 指向上一个子问题 左上斜

            } else {//行不相等
                //取max{[i-1,j], [i,j-1]}

                if ($mx_num[$i - 1][$j] == $mx_num[$i][$j - 1]) {
                    //切除row1和row2都可以
                    $mx_num[$i][$j] = $mx_num[$i - 1][$j];
                    $mx_step[$i][$j] = 3; // 左或上

                } else if ($mx_num[$i - 1][$j] > $mx_num[$i][$j - 1]) {
                    //切row1
                    $mx_num[$i][$j] = $mx_num[$i - 1][$j];
                    $mx_step[$i][$j] = 1; // 左

                } else { //$mx_num[i-1,j] < $mx_num[i,j-1]
                    //切row2
                    $mx_num[$i][$j] = $mx_num[$i][$j - 1];
                    $mx_step[$i][$j] = 2; // 上
                }

            }//行不相等

        }//j

    }//for

    //返回右下角的最大重复行数
    return $mx_num[$len1][$len2];
}