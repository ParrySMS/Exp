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
    public $retcode;
    public $retmsg;
    public $retdata;

    /**
     * Json constructor.
     * @param $retcode
     * @param $retmsg
     * @param $retdata
     */
    public function __construct($retdata,  $retmsg = null,$retcode = 200200)
    {
        $this->retdata = $retdata;
        $this->retmsg = $retmsg;
        $this->retcode = $retcode;
    }


}