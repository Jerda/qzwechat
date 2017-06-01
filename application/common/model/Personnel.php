<?php

namespace app\common\model;

use think\Model;
use think\Request;

class Personnel extends Model
{
    public function sectors()
    {
        return $this->belongsToMany('Sector', 'sector_personnel', 'sector_id', 'personnel_id');
    }

    protected static function init()
    {
        //新增职员后，部门人数+1
        Personnel::afterInsert(function ($personnel) {

            /*$sectors = $personnel->sectors;
            foreach ($sectors as $sector) {
                Sector::where('id', $sector->id)->setInc();
            }*/
        });
    }
}
