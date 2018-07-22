<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2018-6-24
 * Time: 1:45
 */

namespace tlApp\model;


class Json
{
    public $retmsg ;
    public $retdata;
    public $retcode = 200200;

    /**
     * Json constructor.
     * @param $retdata
     * @param $retmsg
     * @param int $retcode
     */
    public function __construct( $retmsg = null, $retdata = null,$retcode = 200200)
    {
        $this->retmsg = $retmsg;
        $this->retdata = $retdata;
        $this->retcode = $retcode;
    }


}