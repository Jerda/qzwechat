<?php

namespace app\common\model;

use think\Model;

class Sector extends Model
{
//    protected $resultSetType = 'collection';
    public function personnels()
    {
        return $this->belongsToMany('Personnel', 'sector_personnel', 'personnel_id', 'sector_id');
    }

    public function getSectors()
    {
        $rules = collection($this->all())->toArray();
        return $this->treeSort($rules);
    }

    /*public function getSectorPersonnelsBySector($sector_id)
    {
        $sector = $this->where(['sector' => $sector_id])->select();
    }*/

    private function treeSort($data, $pid = 0)
    {
        static $arr = [];
        foreach ($data as $value) {

            if ($value['parent_id'] == $pid) {
                $arr[] = $value;
                $this->treeSort($data, $value['id']);
            }
        }
        return $arr;
    }
}
