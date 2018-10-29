<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-10-29
 * Time: 20:38
 */

require "./BaseController.php";
require "./SingleDB.php";


//环境角色
class Top10Ctrl extends BaseController
{

    public function getData()
    {

        try {
            //日志记录
            $this->actionLog();
            //连接数据库
            $this->getTop();

        } catch
        (\Exception $e) {
            $this->error($e);
        }
    }



    /**
     * 用户日志记录
     */
    public function actionLog()
    {
        //todo 进行用户记录

    }


    /** 计算今天总市值排名前十的股票，今天市盈率最高的十支股票
     * @throws \Exception
     */
    private function getTop()
    {
        $db = SingleDB::getinstance()->getDB();


//        var_dump($cids);


        $stock = $db->select('ms_stock(s)', [
            '[>]ms_company(c)' => [
                's.c_id' => 'id'
            ]
        ], [
            "s.name",
            "s.code",
            "s.now_100times(now)",
            "s.benefit_100times(benefit)",
            "s.vol",
            "c.issued_shares",
        ], [
            'AND' => [
                "s.validity" => 1,
                "c.validity" => 1
            ],
            'ORDER' => [
                'c.issued_shares' => 'DESC'
            ]
        ]);

//        var_dump($stock);

        if (!is_array($stock)) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():  stock error', 500);
        }


        //turn int to float
        echo "<br/>";
        echo "<br/>总市值排名前十<br/>";

        foreach ($stock as & $st) {
            $st["now"] = round($st["now"] / 100, 2);
            $st["benefit"] = round($st["benefit"] / 100, 2);
            $st["total_value"] =  $st["now"]*$st["issued_shares"];
            $st["price_earning_ratio"] = round($st["now"] /$st["benefit"],2);
        }

        $this->qsort($stock,'total_value');

        $len = sizeof($stock);
        $len = $len>10?10:$len;

        $tv10 = array_slice($stock, 0,$len);

        echo json_encode($tv10);


        echo "<br/>";
        echo "<br/>市盈率最高<br/>";

        $this->qsort($stock,'price_earning_ratio');
        $len = sizeof($stock);
        $len = $len>10?10:$len;
        $per10 = array_slice($stock, 0,$len);

        echo json_encode($per10);




    }


    /** 根据对象里的某个值进行排序
     * @param $key_string
     * @param array $ar
     * @param int $left
     * @param null $right
     */
    public function qsort(array & $ar, $key_string, $left = 0, $right = null)
    {
//        print_r($ar);

        //default left = 0 ,right = len-1
        if ($right === null) {
            $right = sizeof($ar) - 1;
        }

        if ($left >= $right || $left<0) {//not need to sort
            return;
        }

        //mark the default value
        $first_index = $left;
        $last_index = $right;

        $key = $ar[$left];//default key as first element

//        print_r(json_encode($key));


        while ($left != $right) {//find 2 swap element to sort into 2 parts

//            var_dump($ar);

            while ($ar[$right][$key_string] <= $key[$key_string] && $left < $right) { // [l--r] is [small--big]
                $right--;
            }//until a[r] < key

            while ($ar[$left][$key_string] >= $key[$key_string] && $left < $right) {
                $left++;
            }//until a[l] > key

            if ($left < $right) { //swap
//                echo "<br/> swap ar[$left] = $ar[$left] <-->ar[$right] = $ar[$right] <br/>";
                $t = $ar[$left];
                $ar[$left] = $ar[$right];
                $ar[$right] = $t;
            }

        }//finish 2 sorted parts.

        //left == right == mid

        if ($first_index != $left) {//first_index == mid_index not need to swap, just len = 1
//            echo "put key  ar[$first_index] = $key  <--> ar[$left] =$ar[$left] <br/>";

            //put mid to first(location of key)
            $ar[$first_index] = $ar[$left];
            //put key into mid
            $ar [$left] = $key;
        }

        //continue cut and sort
        //left == right == mid
//        echo " <br/> cut into:  $first_index ---- | $left |---- $last_index  <br/>";
        $this->qsort($ar, $key_string,$first_index, $left - 1);
        $this->qsort($ar, $key_string,$left + 1, $last_index);


    }


}


class Data
{ //具体策略角色
    public function call(BaseController $object)
    {
        return $object->getData();
    }
}


$data = new Data;
$data->call(new Top10Ctrl());




