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

    /**
     * @return null
     */
    public function getRetmsg()
    {
        return $this->retmsg;
    }

    /**
     * @param null $retmsg
     */
    public function setRetmsg($retmsg)
    {
        $this->retmsg = $retmsg;
    }

    /**
     * @return null
     */
    public function getRetdata()
    {
        return $this->retdata;
    }

    /**
     * @param null $retdata
     */
    public function setRetdata($retdata)
    {
        $this->retdata = $retdata;
    }

    /**
     * @return int
     */
    public function getRetcode()
    {
        return $this->retcode;
    }

    /**
     * @param int $retcode
     */
    public function setRetcode($retcode)
    {
        $this->retcode = $retcode;
    }




}