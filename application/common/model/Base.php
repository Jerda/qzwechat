<?php

namespace app\common\model;

use think\Model;
class Base extends Model
{
    protected $autoWriteTimestamp = true;

    public function attr($name)
    {
        return $this->$name;
    }
}
