<?php

namespace app\home\controller;

use app\common\model\Personnel;
use app\common\model\Sector;
use think\Controller;
use think\Request;

class AddressBookController extends Controller
{
    /**
     * 显示组织架构页面
     *
     * @return mixed
     */
    public function index()
    {
//        return $this->fetch();
        $sectors = Sector::where(['level' => 0])->select();
        return $this->fetch('', compact('sectors'));
    }

    /**
     * 获取部门，主要用与获取二级部门
     *
     * @param Request $request
     */
    public function getSeSector(Request $request)
    {
        $parent_id = $request->only('sector_id');
        $se_sectors = Sector::where(['parent_id' => $parent_id])->select();
        $this->result($se_sectors);
    }

    /**
     * 通过姓名或电话号码查询用户
     * 如果$keyword值不为空，通过值判断查询类型，如果满足11位数字，则判定为电话查询，否则判定为名字查询
     *
     * @param Request $request
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function query(Request $request)
    {
        /*
         * keyword sector_id se_sector_id
         */
        $type = '';//查询模式
        $data = $request->param();
        $personnels = [];
        //判定查询类型
        if (!empty($data['keyword'])) {
            //keyword不为空，判定name还是电话查询
            if (preg_match('/\d{11}/', $data['keyword'])) {
                $type = 'tel';
            } elseif (!empty($data['keyword'])) {
                $type = 'name';
            }
        }

        //组装查询条件
        $where = [];

        if ($type == 'name' && $data['sector_id'][0] == 0) {
            $where['name'] = ['like', '%'.$data['keyword'].'%'];
        } elseif ($type == 'tel') {
            $where['tel'] = ['eq', $data['keyword']];
        }

        if (!empty($where)) {
            $personnels = Personnel::where($where)->select();
            return $personnels;
        }

        $length = count($data['sector_id']);

        if ($data['sector_id'][$length-1] != 0) {
            $_where['id'] = ['eq', $data['sector_id'][$length - 1]];
        } else {
            $_where['id'] = ['eq', $data['sector_id'][$length - 2]];
        }

        $sector = Sector::relation('personnels')->where($_where)->find();
        if ($type == 'name') {
//            halt($data['keyword']);
            $personnels = $sector->personnels()->where('name', 'like', '%'.$data['keyword'].'%')->select();
//            halt($personnels);
        }

        if ($type == '') {
            $personnels = $sector->personnels;
        }

        return $personnels;
    }

    public function aaa(Request $request)
    {
        $personnels = $this->query($request);
        return $this->fetch('result', compact('personnels'));
    }

    /**
     * 通过部门查询用户
     *
     * @param Request $request
     */
    public function queryBySector(Request $request)
    {
        $data = $request->param();

        if (!$this->validate($data, 'Home.queryBySector')) {
            $this->error();
        }

        $sector_id = $data['sector_id'].",".$data['se_sector_id'];
        $sector_personnels = Personnel::where(['sector_id' => $sector_id])->select();
        $this->result($sector_personnels);
    }
}
