<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2018-6-26
 * Time: 23:36
 */

$filePath = './';
//$fileName = 'test.xml';
//$fileName = 'seq.xml';
$fileName = 'logic_C.xml';
//$fileName = 'logic-C.xml';
//$fileName = 'logic-diagram.xml';
//$fileName = 'logic-E.xml';
//$fileName = 'verbal-C.xml';
//$fileName = 'verbal-CE.xml';
//$fileName = 'verbal-E.xml';

$file = fopen($filePath.$fileName, 'r+');
$myfile = fopen($filePath.'new_'.$fileName,'w');
//读文本中所有的行，直到文件结束为止。
$itemStr1 = fgets($file); //fgets()函数从文件指针中读取第一行
$itemStr2 = fgets($file); //fgets()函数从文件指针中读取第二行

$i = 0;
while (1) {

    for ($char = 'A'; $char != 'K'; $char++) {
//        var_dump($itemStr1);
//        var_dump($itemStr2);

        //处理Q标签
        //半角
        $q_index1= strpos($itemStr1, 'Q:');
        if ($q_index1) {//有q标签 截取
            $itemStr1 = substr($itemStr1,$q_index1+2);
            $itemStr1 = '</Hint></row><row><Problem>'.$itemStr1;
        }
        //全角
        $q_index2 = strpos($itemStr1, 'Q：');
        if ($q_index2) {//有q标签 截取
            $itemStr1 = substr($itemStr1,$q_index2+2);
            $itemStr1 = '</Hint></row><row><Problem>'.$itemStr1;
        }
        //补选项标签
        if (strstr($itemStr1, '<' . $char . '>')) {//有开始标签 再读一行
            if (strstr($itemStr1, '</' . $char . '>')
                || strstr($itemStr2, '</' . $char . '>')
            ) {//如果本行或下一行有结束标签
//                var_dump($itemStr2);
                continue;
            } else {//确少标签 原有行补上
//                var_dump($itemStr1);
                $itemStr1 = $itemStr1 . '</' . $char . '>';
            }
        }

    }
    fwrite($myfile, $itemStr1);
    //之后逐行检查
    $itemStr1 = $itemStr2;
    $itemStr2 = fgets($file);
    if(feof($file)){//如果到了结尾
        //写完最后两行
        fwrite($myfile, $itemStr1);
        fwrite($myfile, $itemStr2);
        fwrite($myfile, '</Hint>');
        break;
    }

//    ++$i;
//    if (is_integer($i / 1000)) {
//        echo "$i<br/>";
//    }
}

//结束文件流
fclose($file);
fclose($myfile);
echo "done!";

