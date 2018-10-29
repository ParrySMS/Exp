<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-10-28
 * Time: 23:09
 */

require "./BaseController.php";
require "./SingleDB.php";


//环境角色
class RecentCtrl extends BaseController
{

    public function getData()
    {

        try {
            //日志记录
            $this->actionLog();
            //连接数据库
            $this->getRecent();

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

    /** 查出过去三个月上市并且今天股价下跌的股票；
     * @throws \Exception
     */
    private function getRecent()
    {
        $db = SingleDB::getinstance()->getDB();
        //查出过去三个月上市并且今天股价下跌的股票；

        $month = 30 * 24 * 3600;

        //过去三个月上市
        $cids = $db->select('ms_company',
            "id"
            , [
                'AND' => [
                    'ipo_date[<>]' => [
                        date('Y-m-01', time() - (2 * $month)),
                        date('Y-m-d')],
                    "validity" => 1
                ]
            ]);

        //0-n条
        if (!is_array($cids)) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '(): cids error', 500);
        }

//        var_dump($cids);

        //今天股价下跌的股票
        $stock = $db->select('ms_stock', [
            "name",
            "code",
            "now_100times(now)",
            "open_100times(open)",
            "high_100times(high)",
            "low_100times(low)",
            "close_100times(close)",
            "vol",
            "date"
        ], [
            'AND' => [
                'c_id' => $cids,
                "validity" => 1,
                "now_100times[>]" => 'open'
            ]
        ]);

//        var_dump($stock);
        if (!is_array($stock)) {
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '():  stock error', 500);
        }


        //turn int to float
        foreach ($stock as & $st) {
            $st["now"] = round($st["now"] / 100, 2);
            $st["open"] = round($st["open"] / 100, 2);
            $st["high"] = round($st["high"] / 100, 2);
            $st["low"] = round($st["low"] / 100, 2);
            $st["close"] = is_null($st["close"]) ? null : round($st["close"] / 100, 2);
        }


        echo json_encode($stock);


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
$data->call(new RecentCtrl());




