<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-3-20
 * Time: 17:08
 */

namespace stuApp\common;


class paramsCheckDI
{

    private $id;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * paramsCheckPI constructor.
     */
    public function __construct($id)
    {
        $safe = new Safe();
        $this->id = $safe->int_check($id);
    }
}