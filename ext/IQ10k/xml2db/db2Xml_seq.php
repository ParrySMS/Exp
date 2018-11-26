<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-11-4
 * Time: 19:30
 */

require './Http.php';
require './config/database_info.php';
require './config/params.php';
require './config/Medoo.php';


set_time_limit(0);

try {
//    $datas = getDatas();
    newSeq1(400, true);
    newSeq2(400, true);
    newSeq3(400, true);
    newSeq4(300, true);
    newSeq5(300, true);
    newSeq6(300, true);
    newSeq7(200, true);
    newSeq8(200, true);
    newSeq9(250, true);
    newSeq10(250, true);

//    var_dump($datas);
//    $json = json_encode($datas);

//    $myfile = fopen("./testSeq6k.json", "w") or die("Unable to open file!");
//    $myfile = fopen("./trainSeq3k.json", "w") or die("Unable to open file!");

//    fwrite($myfile, $json);
//    fclose($myfile);
//    echo "done";

} catch (Exception $e) {
    echo $e->getMessage();
}


/** 获取db里的seq数据
 * @return array|bool
 * @throws Exception
 */
function getDatas()
{
    $dao = new BaseDao();
    $database = $dao->getDatabase();

    $datas = $database->select($dao::$T_PROBLEM . '(p)', [
        "[>]" . $dao::$T_HINT . "(h)" => ['p.id' => 'pid']
    ], [
        'p.id',
        'p.title',
        'p.title_pic',
        'p.option_ids',
        'p.answers',//这个是json
//        'p.language',
        'p.classification(subtype)',
        'p.pro_type',
        'p.pro_source(type)',
//        'p.time',
//        'p.edit_time',
//        'p.total_edit',
//            'p.comment_num',
        'h.hint',
    ], [
        'AND' => [
//            'p.id'=>[4572,4665,4734,4006,3197,3198,3199], //for test
            'p.pro_source' => 'new-test-seq',
            'p.visible[!]' => VISIBLE_DELETE
        ],
//        "LIMIT" => 10
    ]);

    foreach ($datas as & $pro_data) {
        //先获取在主体题目信息（可能有hint）

        $pro_data['answers'] = json_decode($pro_data['answers']);
        //然后获取选项信息
        $oids = json_decode($pro_data['option_ids']);
        //对象数组
        $pro_data['options'] = [];

//        var_dump($pro_data);

        if (is_array($oids) && sizeof($oids) != 0) {
            $pro_data['options'] = getOptions($oids, $database, $dao::$T_OPTION);
        }

        //clear
        unset($pro_data['option_ids']);

        $pro_data['title_content'] = getTitleContent($pro_data['title']);

    }

    return $datas;
}


/**
 * @param $title
 * @return string
 * @throws Exception
 */
function getTitleContent($title)
{

    if (!is_string($title) || empty($title)) {
        throw new Exception("title not string");
    }


    //get string after digit
//    for ($i = 0; $i < strlen($title); $i++) {
//        $char = substr($title, $i, 1);
//        if (ctype_digit($char)) {
//            $title_content = trim(substr($title,$i));
//        }
//    }


    $title_content = trim(str_replace("\n", "", preg_replace('/([A-Za-z\x80-\xff]*)/i', '', $title)));

    return $title_content;


}

/** 包装选项数组
 * @param $oids
 * @return array
 * @throws Exception
 */
function getOptions($oids, & $database, $table)
{


    $datas = selectGroup($oids, $database, $table);

    unset($options);
    $options = [];

    foreach ($datas as $d) {
        $options[] = (object)$d;
    }

    return $options;
}


/** 获取选项
 * @param array $option_ids
 * @return mixed
 * @throws Exception
 */
function selectGroup(array $option_ids, \Medoo\Medoo & $database, $table)
{
    $data = $database->select($table, [
//        'id',
        'key',
        'content',
        'is_pic'
    ], [
        'AND' => [
            'id' => $option_ids,
            'visible[!]' => VISIBLE_DELETE
        ]
    ]);

    //多条
    if (!is_array($data) || sizeof($data) == 0) {
        throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '(): error', 500);
    }

    return $data;

}


function addSeqProComma()
{
    $dao = new BaseDao();
    $database = $dao->getDatabase();
    $datas = $database->select($dao::$T_PROBLEM . '(p)', [
        "[>]" . $dao::$T_HINT . "(h)" => ['p.id' => 'pid']
    ], [
        'p.id',
        'p.title',
//        'p.title_pic',
        'p.option_ids',
        'p.answers',//这个是json
//        'p.language',
        'p.classification(subtype)',
        'p.pro_type',
        'p.pro_source(type)',
//        'p.time',
//        'p.edit_time',
//        'p.total_edit',
//            'p.comment_num',
        'h.hint',
    ], [
        'AND' => [
//            'p.id'=>[4572,4665,4734,4006,3197,3198,3199], //for test
            'p.pro_source' => 'seq',
            'p.visible[!]' => VISIBLE_DELETE,
            'p.pro_type[~]' => 'choice',
//            'p.language' => 'en',
            'OR' => [
                'p.title[!~]' => '，',
                'p.title[!~]' => ',',
            ]

        ],
//        "LIMIT" => 10
    ]);

    foreach ($datas as &$p) {
        $p['title'] = trim($p['title']);
        $t = str_replace("？", "?", $p['title']);//全角空格 半角空格
        $t = str_replace("，", ",", $t);

        if ($p['title'][0] == '?' //add sign
            || $p['title'][0] == '？'
            || ($p['title'][0] == '-' && is_numeric($p['title'][1]))
            || ($p['title'][0] == '√' && is_numeric($p['title'][1]))
            || is_numeric($p['title'][0])) {

            if (strpos($t, ',') == false) {
                echo '<br/>【】' . $p['id'] . ":  " . $t . '<br/>';
                $t = str_replace(" ", ",", $t);


            }

        }

//       todo 临时关闭
//        $database->update($dao::$T_PROBLEM, [
//            'title' => $t,
//            'edit_time'=>date('Y-m-d H:i:s')
//        ], [
//            'id' => $p['id']
//        ]);
    }
}


// 根据公式生成 seq题

//An = Rn+B
function newSeq1($num, $post = false)
{
    $hp = new Http();

    for ($t_num = 0; $t_num < $num; $t_num++) {


        $r = intval(rand(-100, 100));
        while ($r == 0) {
            $r = intval(rand(-100, 100));
        }

        $b = $r < 0 ?
            intval(rand(80, 150))
            : intval(rand(-150, -80));


        $m = intval(rand(1, 5));

        $title = '';
        for ($i = 0; $i < 7; $i++) {
            //An = Rn+B, 填中间
//            if ($i == $m) {
//                $title = $title . ",?";
//                continue;
//            }

            $data = $r * $i + $b;

            if ($i == 0) {
                $title = $title . "$data";
            } else {
                $title = $title . ",$data";
            }
        }

        //An = Rn+B, 填末尾
        $title = $title . ",?";
        $res = $r * 7 + $b;
        //An = Rn+B, 填中间
//        $res = $r * $m + $b;

        $ar = [$res, $res + intval(rand(-5, -3)), $res + intval(rand(-2, -1)), $res + intval(rand(1, 4))];
        shuffle($ar);
        $optionAr = [
            'a' => $ar[0],
            'b' => $ar[1],
            'c' => $ar[2],
            'd' => $ar[3],
        ];
        //find correct answer
        for ($i = 0; $i < 4; $i++) {
            if ($ar[$i] == $res) {
                break;
            }
        }

        $ks = ['a', 'b', 'c', 'd'];
        $answers = [$ks[$i]];
        $language = 'en';
        $classification = 'sequence';
        $pro_type = 'exclusive choice';
        $pro_source = 'new-test-seq';
        if ($b == 0) {
            $hint = "A[n]=$r*n";
        } else if ($b > 0) {
            $hint = "A[n]=$r*n+$b";
        } else {
            $hint = "A[n]=$r*n$b";

        }
        $problem_info = compact('title', 'optionAr', 'answers', 'language', 'classification', 'pro_type', 'pro_source', 'hint');

        echo $t_num;
        echo PHP_EOL;
        echo json_encode($problem_info);//insert
        echo PHP_EOL;

        if ($post) {
            $hp->post('http://exp.szer.me/parry/testlib/problem', $problem_info, false);
        } else {
            echo "no post";
            echo PHP_EOL;
        }
    }

    curl_close($hp->ch);


}

//An = Rn^p + B,
function newSeq2($num, $post = false)
{
    $hp = new Http();


    for ($t_num = 0; $t_num < $num; $t_num++) {
        $r = intval(rand(-80, 80));
        while ($r == 0) {
            $r = intval(rand(-80, 80));
        }

        $b = $r < 0 ?
            intval(rand(80, 150))
            : intval(rand(-150, -80));

        $p = intval(rand(1, 3));

        $m = intval(rand(1, 5));

        $title = '';
        for ($i = 0; $i < 7; $i++) {
            //An = Rn^p + B, 填中间
//            if($i == $m){
//                $title = $title . ",?";
//                continue;
//            }

            $data = $r * pow($i, $p) + $b;
            if ($i == 0) {
                $title = $title . "$data";
            } else {
                $title = $title . ",$data";
            }
        }

//        An = Rn^p + B, 填末尾
        $title = $title . ",?";
        $res = $r * pow(7, $p) + $b;
        //An = Rn^p + B, 填中间
//        $res = $r* pow($m,$p) + $b;

        $ar = [$res, $res + intval(rand(-5, -3)), $res + intval(rand(-2, -1)), $res + intval(rand(1, 4))];
        shuffle($ar);
        $optionAr = [
            'a' => $ar[0],
            'b' => $ar[1],
            'c' => $ar[2],
            'd' => $ar[3],
        ];
        //find correct answer
        for ($i = 0; $i < 4; $i++) {
            if ($ar[$i] == $res) {
                break;
            }
        }

        $ks = ['a', 'b', 'c', 'd'];
        $answers = [$ks[$i]];
        $language = 'en';
        $classification = 'sequence';
        $pro_type = 'exclusive choice';
        $pro_source = 'new-test-seq';
        if ($b == 0) {
            $hint = "A[n]=$r*n^$p";
        } else if ($b > 0) {
            $hint = "A[n]=$r*n^$p+$b";
        } else {
            $hint = "A[n]=$r*n^$p$b";

        }
        $problem_info = compact('title', 'optionAr', 'answers', 'language', 'classification', 'pro_type', 'pro_source', 'hint');

        echo $t_num;
        echo PHP_EOL;
        echo json_encode($problem_info);//insert
        echo PHP_EOL;

        if ($post) {
            $hp->post('http://exp.szer.me/parry/testlib/problem', $problem_info, false);
        } else {
            echo "no post";
            echo PHP_EOL;
        }
    }

    curl_close($hp->ch);


}

//An = Rn^p + B,
function editSeq2($num, $post = false)
{
    $hp = new Http();


    for ($id = 10417; $id <= 10616; $id++) {

        $r = intval(rand(-80, 80));
        while ($r == 0) {
            $r = intval(rand(-80, 80));
        }
        $b = intval(rand(-80, 80));
        $p = intval(rand(1, 4));

        $m = intval(rand(1, 5));

        $title = '';
        for ($i = 0; $i < 7; $i++) {
            //An = Rn^p + B, 填中间
//            if($i == $m){
//                $title = $title . ",?";
//                continue;
//            }

            $data = $r * pow($i, $p) + $b;
            if ($i == 0) {
                $title = $title . "$data";
            } else {
                $title = $title . ",$data";
            }
        }

//        An = Rn^p + B, 填末尾
        $title = $title . ",?";
        $res = $r * pow(7, $p) + $b;
        //An = Rn^p + B, 填中间
//        $res = $r* pow($m,$p) + $b;

        $ar = [$res, $res + intval(rand(-5, -3)), $res + intval(rand(-2, -1)), $res + intval(rand(1, 4))];
        shuffle($ar);
        $optionAr = [
            'a' => $ar[0],
            'b' => $ar[1],
            'c' => $ar[2],
            'd' => $ar[3],
        ];
        //find correct answer
        for ($i = 0; $i < 4; $i++) {
            if ($ar[$i] == $res) {
                break;
            }
        }

        $ks = ['a', 'b', 'c', 'd'];
        $answers = [$ks[$i]];
        $language = 'en';
        $classification = 'sequence';
        $pro_type = 'exclusive choice';
        $pro_source = 'new-train-seq';
        if ($b == 0) {
            $hint = "A[n]=$r*n^$p";
        } else if ($b > 0) {
            $hint = "A[n]=$r*n^$p+$b";
        } else {
            $hint = "A[n]=$r*n^$p$b";

        }
        $problem_info = compact('title', 'optionAr', 'answers', 'language', 'classification', 'pro_type', 'pro_source', 'hint');

        echo 'id' . $id;
        echo PHP_EOL;
        echo json_encode($problem_info);//insert
        echo PHP_EOL;

        if ($post) {
            $hp->post('http://exp.szer.me/parry/testlib/problem/' . $id, $problem_info, false);
        } else {
            echo "no post";
            echo PHP_EOL;
        }
    }

    curl_close($hp->ch);


}


//An = Rn^p + Bn +C,
function newSeq3($num, $post = false)
{
    $hp = new Http();


    for ($t_num = 0; $t_num < $num; $t_num++) {


        $r = intval(rand(-80, 80));
        while ($r == 0) {
            $r = intval(rand(-80, 80));
        }

        $b = $r < 0 ?
            intval(rand(80, 150))
            : intval(rand(-150, -80));


        $c = $r < 0 ?
            intval(rand(80, 150))
            : intval(rand(-150, -80));

        $p = intval(rand(1, 3));
        $m = intval(rand(1, 5));
        $title = '';
        for ($i = 0; $i < 7; $i++) {
            //An = Rn^p + Bn +C,, 填中间
//            if ($i == $m) {
//                $title = $title . ",?";
//                continue;
//            }

            $data = $r * pow($i, $p) + $b * $i + $c;

            if ($i == 0) {
                $title = $title . "$data";
            } else {
                $title = $title . ",$data";
            }
        }

        //An = Rn^p + Bn +C,, 填末尾
        $title = $title . ",?";
        $res = $r * pow(7, $p) + $b * 7 + $c;
        //An = Rn^p + Bn +C,, 填中间
//        $res = $r * pow($m, $p) + $b * $m + $c;

        $ar = [$res, $res + intval(rand(-5, -3)), $res + intval(rand(-2, -1)), $res + intval(rand(1, 4))];
        shuffle($ar);
        $optionAr = [
            'a' => $ar[0],
            'b' => $ar[1],
            'c' => $ar[2],
            'd' => $ar[3],
        ];
        //find correct answer
        for ($i = 0; $i < 4; $i++) {
            if ($ar[$i] == $res) {
                break;
            }
        }

        $ks = ['a', 'b', 'c', 'd'];
        $answers = [$ks[$i]];
        $language = 'en';
        $classification = 'sequence';
        $pro_type = 'exclusive choice';
        $pro_source = 'new-test-seq';

        $hint = "A[n]=$r*n^$p";

        if ($b > 0) {
            $hint = $hint . "+$b*n";
        } else {
            $hint = $hint . "$b*n";
        }


        if ($c > 0) {
            $hint = $hint . "+$c";
        } else {
            $hint = $hint . "$c";
        }

        $problem_info = compact('title', 'optionAr', 'answers', 'language', 'classification', 'pro_type', 'pro_source', 'hint');

        echo $t_num;
        echo PHP_EOL;
        echo json_encode($problem_info);//insert
        echo PHP_EOL;

        if ($post) {
            $hp->post('http://exp.szer.me/parry/testlib/problem', $problem_info, false);
        } else {
            echo "no post";
            echo PHP_EOL;
        }
    }

    curl_close($hp->ch);


}

//An = (An-1 + An-2) *R
function newSeq4($num, $post = false)
{
    $hp = new Http();


    for ($t_num = 0; $t_num < $num; $t_num++) {


        $a0 = intval(rand(50, 150));
        while ($a0 == 0) {
            $a0 = intval(rand(50, 150));
        }

        $a1 = intval(rand(-150, -50));
        while ($a1 == 0) {
            $a1 = intval(rand(-150, -50));
        }

        $r = intval(rand(-6, 6));

        while ($r == 0) {
            $r = intval(rand(-6, 6));
        }

        $m = intval(rand(2, 4));
        $a = [$a0, $a1];
        //An = (An-1 + An-2) *R
        for ($i = 2; $i <= 6; $i++) {
            $a[] = $r * ($a[$i - 2] + $a[$i - 1]);
        }

        $title = '';
        //An = (An-1 + An-2) *R
        for ($i = 0; $i < 6; $i++) {//miss 7
            if ($i == 0) {
                $title = "$a[$i]";
                continue;
            }
            // 填中间
//            if ($i == $m) {
//                $title = $title . ",?";
//                continue;
//            }

            $title = $title . ",$a[$i]";

        }

//        填末尾
        $title = $title . ",?";
        $res = $a[6];
        //An = (An-1 + An-2) *R, 填中间
        $res = $a[$m];

        $ar = [$res, $res + intval(rand(-5, -3)), $res + intval(rand(-2, -1)), $res + intval(rand(1, 4))];
        shuffle($ar);
        $optionAr = [
            'a' => $ar[0],
            'b' => $ar[1],
            'c' => $ar[2],
            'd' => $ar[3],
        ];
        //find correct answer
        for ($i = 0; $i < 4; $i++) {
            if ($ar[$i] == $res) {
                break;
            }
        }

        $ks = ['a', 'b', 'c', 'd'];
        $answers = [$ks[$i]];
        $language = 'en';
        $classification = 'sequence';
        $pro_type = 'exclusive choice';
        $pro_source = 'new-test-seq';

        // hint An = R*(An-1 + An-2)

        if ($r > 0) {
            $hint = "A[n]=$r*(A[n-1] + A[n-2])";
        } else {
            $hint = "A[n]=($r)*(A[n-1] + A[n-2])";
        }


        $problem_info = compact('title', 'optionAr', 'answers', 'language', 'classification', 'pro_type', 'pro_source', 'hint');

        echo $t_num;
        echo PHP_EOL;
        echo json_encode($problem_info);//insert
        echo PHP_EOL;
        if ($post) {
            $hp->post('http://exp.szer.me/parry/testlib/problem', $problem_info, false);
        } else {
            echo "no post";
            echo PHP_EOL;
        }
    }
    unset($a);
    curl_close($hp->ch);


}

//An = (An-1 + An-2 +An-3) *R
function newSeq5($num, $post = false)
{
    $hp = new Http();


    for ($t_num = 0; $t_num < $num; $t_num++) {


        $a0 = intval(rand(-30, -20));
        while ($a0 == 0) {
            $a0 = intval(rand(-30, -20));
        }

        $a1 = intval(rand(20, 30));
        while ($a1 == 0) {
            $a1 = intval(rand(20, 30));
        }

        $a2 = intval(rand(-30, 30));
        while ($a2 == 0) {
            $a2 = intval(rand(-30, 30));
        }

        $r = intval(rand(-5, 5));
        while ($r == 0) {
            $r = intval(rand(-5, 5));
        }

        $m = intval(rand(2, 4));
        $a = [$a0, $a1, $a2];
        //An = (An-1 + An-2) *R
        for ($i = 3; $i <= 6; $i++) {
            $a[] = $r * ($a[$i - 3] + $a[$i - 2] + $a[$i - 1]);
        }

        $title = '';
        //An = (An-1 + An-2) *R
        for ($i = 0; $i < 6; $i++) {//miss 7
            if ($i == 0) {
                $title = "$a[$i]";
                continue;
            }
            // 填中间
//            if ($i == $m) {
//                $title = $title . ",?";
//                continue;
//            }

            $title = $title . ",$a[$i]";

        }

//        填末尾
        $title = $title . ",?";
        $res = $a[6];
//        An = (An-1 + An-2 +An-3) *R, 填中间
//        $res = $a[$m];

        $ar = [$res, $res + intval(rand(-5, -3)), $res + intval(rand(-2, -1)), $res + intval(rand(1, 4))];
        shuffle($ar);
        $optionAr = [
            'a' => $ar[0],
            'b' => $ar[1],
            'c' => $ar[2],
            'd' => $ar[3],
        ];
        //find correct answer
        for ($i = 0; $i < 4; $i++) {
            if ($ar[$i] == $res) {
                break;
            }
        }

        $ks = ['a', 'b', 'c', 'd'];
        $answers = [$ks[$i]];
        $language = 'en';
        $classification = 'sequence';
        $pro_type = 'exclusive choice';
        $pro_source = 'new-test-seq';


        if ($r > 0) {
            $hint = "A[n]=$r*(A[n-1] + A[n-2] + A[n-3])";
        } else {
            $hint = "A[n]=($r)*(A[n-1] + A[n-2] + A[n-3])";
        }


        $problem_info = compact('title', 'optionAr', 'answers', 'language', 'classification', 'pro_type', 'pro_source', 'hint');

        echo $t_num;
        echo PHP_EOL;
        echo json_encode($problem_info);//insert
        echo PHP_EOL;

        if ($post) {
            $hp->post('http://exp.szer.me/parry/testlib/problem', $problem_info, false);
        } else {
            echo "no post";
            echo PHP_EOL;
        }
    }
    unset($a);
    curl_close($hp->ch);


}

//An = (An-1 +,An-2) *R + B
function newSeq6($num, $post = false)
{
    $hp = new Http();


    for ($t_num = 0; $t_num < $num; $t_num++) {


        $a0 = intval(rand(-30, -20));
        while ($a0 == 0) {
            $a0 = intval(rand(-30, -20));
        }

        $a1 = intval(rand(20, 30));
        while ($a1 == 0) {
            $a1 = intval(rand(20, 30));
        }


        $r = intval(rand(-5, 5));
        while ($r == 0) {
            $r = intval(rand(-5, 5));
        }

        $b = $r > 0 ?
            intval(rand(-40, -20))
            : intval(rand(20, 40));


        $m = intval(rand(2, 4));
        $a = [$a0, $a1];
        //An = (An-1 + An-2) *R
        for ($i = 2; $i <= 6; $i++) {
            $a[] = $r * ($a[$i - 2] + $a[$i - 1]) + $b;
        }

        $title = '';
        //An = (An-1 + An-2) *R +b
        for ($i = 0; $i < 6; $i++) {//miss 7
            if ($i == 0) {
                $title = "$a[$i]";
                continue;
            }
            // 填中间
//            if ($i == $m) {
//                $title = $title . ",?";
//                continue;
//            }

            $title = $title . ",$a[$i]";

        }

//        填末尾
        $title = $title . ",?";
        $res = $a[6];
//        An = (An-1 + An-2) *R + b, 填中间
//        $res = $a[$m];

        $ar = [$res, $res + intval(rand(-5, -3)), $res + intval(rand(-2, -1)), $res + intval(rand(1, 4))];
        shuffle($ar);
        $optionAr = [
            'a' => $ar[0],
            'b' => $ar[1],
            'c' => $ar[2],
            'd' => $ar[3],
        ];
        //find correct answer
        for ($i = 0; $i < 4; $i++) {
            if ($ar[$i] == $res) {
                break;
            }
        }

        $ks = ['a', 'b', 'c', 'd'];
        $answers = [$ks[$i]];
        $language = 'en';
        $classification = 'sequence';
        $pro_type = 'exclusive choice';
        $pro_source = 'new-test-seq';

        // hint An = R*(An-1 + An-2)

        if ($r > 0) {
            $hint = "A[n]=$r*(A[n-1] + A[n-2])";
        } else {
            $hint = "A[n]=($r)*(A[n-1] + A[n-2])";
        }

        if ($b > 0) {
            $hint = $hint . "+$b";
        } else {
            $hint = $hint . "$b";
        }


        $problem_info = compact('title', 'optionAr', 'answers', 'language', 'classification', 'pro_type', 'pro_source', 'hint');

        echo $t_num;
        echo PHP_EOL;
        echo json_encode($problem_info);//insert
        echo PHP_EOL;

        if ($post) {
            $hp->post('http://exp.szer.me/parry/testlib/problem', $problem_info, false);
        } else {
            echo "no post";
            echo PHP_EOL;
        }
    }
    unset($a);
    curl_close($hp->ch);


}

//An = (An-1)^p  + B
function newSeq7($num, $post = false)
{

    $hp = new Http();


    for ($t_num = 0; $t_num < $num; $t_num++) {
        $a0 = intval(rand(-8, 8));
        while ($a0 == 0) {
            $a0 = intval(rand(-8, 8));
        }

        $b = $a0 > 0 ? intval(rand(-50, -30))
            : intval(rand(1, 60));


        $p = intval(rand(1, 2));

        $m = intval(rand(1, 2));

        $a = [$a0];

        for ($i = 1; $i <= 3; $i++) {
            $a[] = pow($a[$i - 1], $p) + $b;
        }

        $title = '';
        //An = (An-1)^p  + B
        for ($i = 0; $i < 3; $i++) {//miss 7
            if ($i == 0) {
                $title = "$a[$i]";
                continue;
            }
//             填中间
//            if ($i == $m) {
//                $title = $title . ",?";
//                continue;
//            }

            $title = $title . ",$a[$i]";

        }

//        填末尾
        $title = $title . ",?";
        $res = $a[3];
//  An = (An-1)^p  + B 填中间
//        $res = $a[$m];

        $ar = [$res, $res + intval(rand(-5, -3)), $res + intval(rand(-2, -1)), $res + intval(rand(1, 4))];
        shuffle($ar);
        $optionAr = [
            'a' => $ar[0],
            'b' => $ar[1],
            'c' => $ar[2],
            'd' => $ar[3],
        ];
        //find correct answer
        for ($i = 0; $i < 4; $i++) {
            if ($ar[$i] == $res) {
                break;
            }
        }

        $ks = ['a', 'b', 'c', 'd'];
        $answers = [$ks[$i]];
        $language = 'en';
        $classification = 'sequence';
        $pro_type = 'exclusive choice';
        $pro_source = 'new-test-seq';

        //An = (An-1)^p  + B

        $hint = "A[n]=A[n-1]^$p";

        if ($b > 0) {
            $hint = $hint . "+$b";
        } else {
            $hint = $hint . "$b";
        }


        $problem_info = compact('title', 'optionAr', 'answers', 'language', 'classification', 'pro_type', 'pro_source', 'hint');

        echo $t_num;
        echo PHP_EOL;
        echo json_encode($problem_info);//insert
        echo PHP_EOL;

        if ($post) {
            $hp->post('http://exp.szer.me/parry/testlib/problem', $problem_info, false);
        } else {
            echo "no post";
            echo PHP_EOL;
        }
    }
    unset($a);
    curl_close($hp->ch);


}

//An = (An-2)^p  + B
function newSeq8($num, $post = false)
{

    $hp = new Http();


    for ($t_num = 0; $t_num < $num; $t_num++) {
        $a0 = intval(rand(-9, 9));
        while ($a0 == 0) {
            $a0 = intval(rand(-9, 9));
        }

        $a1 = intval(rand(-9, 9));
        while ($a1 == 0) {
            $a1 = intval(rand(-9, 9));
        }

        $b = $a1 > 0 ? intval(rand(-150, -50)) : intval(rand(50, 150));


        $p = intval(rand(1, 2));

        $m = intval(rand(2, 4));

        $a = [$a0, $a1];

        for ($i = 2; $i <= 5; $i++) {
            $a[] = pow($a[$i - 2], $p) + $b;
        }

        $title = '';
        //An = (An-1)^p  + B
        for ($i = 0; $i < 5; $i++) {//miss 7
            if ($i == 0) {
                $title = "$a[$i]";
                continue;
            }
//             填中间
//            if ($i == $m) {
//                $title = $title . ",?";
//                continue;
//            }

            $title = $title . ",$a[$i]";

        }

//        填末尾
        $title = $title . ",?";
        $res = $a[5];
//  An = (An-1)^p  + B 填中间
//        $res = $a[$m];

        $ar = [$res, $res + intval(rand(-5, -3)), $res + intval(rand(-2, -1)), $res + intval(rand(1, 4))];
        shuffle($ar);
        $optionAr = [
            'a' => $ar[0],
            'b' => $ar[1],
            'c' => $ar[2],
            'd' => $ar[3],
        ];
        //find correct answer
        for ($i = 0; $i < 4; $i++) {
            if ($ar[$i] == $res) {
                break;
            }
        }

        $ks = ['a', 'b', 'c', 'd'];
        $answers = [$ks[$i]];
        $language = 'en';
        $classification = 'sequence';
        $pro_type = 'exclusive choice';
        $pro_source = 'new-test-seq';

        //An = (An-1)^p  + B

        $hint = "A[n]=A[n-2]^$p";

        if ($b > 0) {
            $hint = $hint . "+$b";
        } else {
            $hint = $hint . "$b";
        }


        $problem_info = compact('title', 'optionAr', 'answers', 'language', 'classification', 'pro_type', 'pro_source', 'hint');

        echo $t_num;
        echo PHP_EOL;
        echo json_encode($problem_info);//insert
        echo PHP_EOL;

        if ($post) {
            $hp->post('http://exp.szer.me/parry/testlib/problem', $problem_info, false);
        } else {
            echo "no post";
            echo PHP_EOL;
        }
    }
    unset($a);
    curl_close($hp->ch);


}

//A2n-1 + A2n = A0
function newSeq9($num, $post = false)
{

    $hp = new Http();


    for ($t_num = 0; $t_num < $num; $t_num++) {
        $a0 = intval(rand(-150, -50));
        while ($a0 == 0) {
            $a0 = intval(rand(-150, -50));
        }

        $a1 = intval(rand(25, 125));
        while ($a1 == 0) {
            $a1 = intval(rand(25, 125));
        }


        $m = intval(rand(2, 6));

        $a = [$a0, $a1];

        for ($i = 2; $i <= 8; $i++) {
            if ($i % 2 == 1) {
                $a[] = intval(rand(-55, 55));
            } else {
                $a[] = $a0 - $a[$i - 1];
            }
        }

        $title = '';
        //A2n-1 + A2n = A0
        for ($i = 0; $i < 8; $i++) {
            if ($i == 0) {
                $title = "$a[$i]";
                continue;
            }
//             填中间
//            if ($i == $m) {
//                $title = $title . ",?";
//                continue;
//            }

            $title = $title . ",$a[$i]";

        }

//        填末尾
        $title = $title . ",?";
        $res = $a[8];
        //A2n-1 + A2n = A0 填中间
//        $res = $a[$m];

        $ar = [$res, $res + intval(rand(-5, -3)), $res + intval(rand(-2, -1)), $res + intval(rand(1, 4))];
        shuffle($ar);
        $optionAr = [
            'a' => $ar[0],
            'b' => $ar[1],
            'c' => $ar[2],
            'd' => $ar[3],
        ];
        //find correct answer
        for ($i = 0; $i < 4; $i++) {
            if ($ar[$i] == $res) {
                break;
            }
        }

        $ks = ['a', 'b', 'c', 'd'];
        $answers = [$ks[$i]];
        $language = 'en';
        $classification = 'sequence';
        $pro_type = 'exclusive choice';
        $pro_source = 'new-test-seq';

        //A2n-1 + A2n = A0

        $hint = "A[2n-1] + A[2n] = A[0], n is greater than zero";


        $problem_info = compact('title', 'optionAr', 'answers', 'language', 'classification', 'pro_type', 'pro_source', 'hint');

        echo $t_num;
        echo PHP_EOL;
        echo json_encode($problem_info);//insert
        echo PHP_EOL;

        if ($post) {
            $hp->post('http://exp.szer.me/parry/testlib/problem', $problem_info, false);
        } else {
            echo "no post";
            echo PHP_EOL;
        }
    }
    unset($a);
    curl_close($hp->ch);

}

//A2n-1 + A2n + A2n+1 = A0
function newSeq10($num, $post = false)
{

    $hp = new Http();


    for ($t_num = 0; $t_num < $num; $t_num++) {
        $a0 = intval(rand(-150, -50));
        while ($a0 == 0) {
            $a0 = intval(rand(-150, -50));
        }

        $a1 = intval(rand(25, 125));
        while ($a1 == 0) {
            $a1 = intval(rand(25, 125));
        }

        $a2 = intval(rand(-45, 45));
        while ($a2 == 0) {
            $a2 = intval(rand(-45, 45));
        }


        $m = intval(rand(2, 10));

        $a = [$a0, $a1, $a2];

        for ($i = 3; $i <= 12; $i++) {
            if ($i % 2 == 1) {
                $a[] = $a[0] - $a[$i - 1] - $a[$i - 2];
            } else {
                $a[] = intval(rand(-55, 55));
            }
        }

        $title = '';
        //A2n-1 + A2n + A2n+1 = A0
        for ($i = 0; $i < 12; $i++) {
            if ($i == 0) {
                $title = "$a[$i]";
                continue;
            }
//             填中间
//            if ($i == $m) {
//                $title = $title . ",?";
//                continue;
//            }

            $title = $title . ",$a[$i]";

        }

//        填末尾
        $title = $title . ",?";
        $res = $a[12];
        //A2n-1 + A2n = A0 填中间
//        $res = $a[$m];

        $ar = [$res, $res + intval(rand(-5, -3)), $res + intval(rand(-2, -1)), $res + intval(rand(1, 4))];
        shuffle($ar);
        $optionAr = [
            'a' => $ar[0],
            'b' => $ar[1],
            'c' => $ar[2],
            'd' => $ar[3],
        ];
        //find correct answer
        for ($i = 0; $i < 4; $i++) {
            if ($ar[$i] == $res) {
                break;
            }
        }

        $ks = ['a', 'b', 'c', 'd'];
        $answers = [$ks[$i]];
        $language = 'en';
        $classification = 'sequence';
        $pro_type = 'exclusive choice';
        $pro_source = 'new-test-seq';

        //A2n-1 + A2n + A2n+1 = A0

        $hint = "A[2n-1] + A[2n] + A[2n+1] = A[0], n is greater than zero";


        $problem_info = compact('title', 'optionAr', 'answers', 'language', 'classification', 'pro_type', 'pro_source', 'hint');

        echo $t_num;
        echo PHP_EOL;
        echo json_encode($problem_info);//insert
        echo PHP_EOL;

        if ($post) {
            $hp->post('http://exp.szer.me/parry/testlib/problem', $problem_info, false);
        } else {
            echo "no post";
            echo PHP_EOL;
        }
    }
    unset($a);
    curl_close($hp->ch);

}


class BaseDao
{

    protected $database;

    static $T_ACTION = DB_PREFIX . '_action';
//    static $T_COMMENT = DB_PREFIX . "_comment_test";
    static $T_COMMENT = DB_PREFIX . "_comment_adddiagramspecial";
//    static $T_HINT = DB_PREFIX . "_hint_test";
    static $T_HINT = DB_PREFIX . "_hint_adddiagramspecial";
    static $T_OPTION = DB_PREFIX . "_option_adddiagramspecial";
    static $T_PROBLEM = DB_PREFIX . "_problem_adddiagramspecial";

    //trans
    static $T_TRANS_PROBLEM = DB_PREFIX . "_problem_cetrans_not_en";
    static $T_TRANS_OPTION = DB_PREFIX . "_option_cetrans";
    static $T_TRANS_HINT = DB_PREFIX . "_hint_cetrans";

    /**
     * @return \Medoo\Medoo
     */
    public function getDatabase()
    {
        return $this->database;
    }


    /**
     * BaseDao constructor.
     */
    public function __construct()
    {
        $this->database = new  Medoo\Medoo([
            'database_type' => DATABASE_TYPE,
            'database_name' => DATABASE_NAME,
            'server' => SERVER,
            'username' => USERNAME,
            'password' => PASSWORD,
            'charset' => CHARSET,
            'port' => PORT,
            'check_interval' => CHECK_INTERVAL
        ]);
    }


}