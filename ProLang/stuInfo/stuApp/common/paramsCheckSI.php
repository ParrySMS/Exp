<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-3-20
 * Time: 17:08
 */

namespace stuApp\common;


class paramsCheckSI
{

    private $last_id;
    private $offset;

    /**
     * @return mixed
     */
    public function getLastId()
    {
        return $this->last_id;
    }

    /**
     * @return mixed
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * paramsCheckPI constructor.
     */
    public function __construct($last_id,$offset)
    {
        $safe = new Safe();
        $this->last_id = $safe->int_check($last_id);
        $this->offset = $safe->int_check($offset);

    }
}