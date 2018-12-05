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
//            echo 'read:line '.$t.PHP_EOL;
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