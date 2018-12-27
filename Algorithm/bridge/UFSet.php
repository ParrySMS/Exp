<?php

class UFSet
{
    public $UFSTree = [];


    public function __construct(int $n)
    {

        for ($i = 1; $i <= $n; $i++) {
            //set data and parent as itself
            $UFSTree[$i]['data'] = $i;
            $UFSTree[$i]['parent'] = $i;
            $UFSTree[$i]['rank'] = 0;
        }

        $this->UFSTree = $UFSTree;
    }

    public function find($x)
    {

        if ($x != $this->UFSTree[$x]['parent']) {
            return $this->find($this->UFSTree[$x]['parent']);
        }
        //else
        return $x;
    }

    public function union($x, $y)
    {
        $x = $this->find($x);
        $y = $this->find($y);

        if ($this->UFSTree[$x]['rank'] > $this->UFSTree[$y]['rank']) {
            $this->UFSTree[$y]['parent'] = $x;
        } else {
            $this->UFSTree[$x]['parent'] = $y;

            if ($this->UFSTree[$x]['rank'] == $this->UFSTree[$y]['rank']) {
                $this->UFSTree[$y]['rank']++;
            }
        }
    }


}
