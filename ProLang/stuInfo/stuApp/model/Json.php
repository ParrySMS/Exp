<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2017-11-6
 * Time: 13:35
 */

namespace stuApp\model;


class Json
{
    public $dbtime;
    public $exctime;
    public $retcode;
    public $retmsg;
    public $retdata;

    /**
     * Json constructor.
     * @param $stime
     * @param $dbtime
     * @param $retdata
     * @param null $retmsg
     * @param int $retcode
     */
    public function __construct($stime,$dbtime,$retdata,  $retmsg = null,$retcode = 200200)
    {
        $this->retdata = $retdata;
        $this->retmsg = $retmsg;
        $this->retcode = $retcode;
        $this->dbtime = 1000*$dbtime;
        $this->exctime = 1000*(microtime(true)-$stime);
    }


}