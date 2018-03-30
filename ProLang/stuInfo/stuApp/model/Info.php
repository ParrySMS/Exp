<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-3-20
 * Time: 10:33
 */

namespace stuApp\model;
class Info
{
    private $id;
    public $stuno; //学号
    public $name;
    public $age;
    public $sex;
    public $score;
    public $grade;

    /**
     * @return mixed|null
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * stuInfo constructor.
     */
    public function __construct(array $option)
    {
        $this->id = empty($option['id']) ? null : $option['id'];
        $this->stuno = empty($option['stuno']) ? null : $option['stuno'];
        $this->name = empty($option['name']) ? null : $option['name'];
        $this->age = empty($option['age']) ? null : $option['age'];
        $this->sex = empty($option['sex']) ? null : $option['sex'];
        $this->score = empty($option['score']) ? null : $option['score'];
        $this->grade = empty($option['grade']) ? null : $option['grade'];

    }


}