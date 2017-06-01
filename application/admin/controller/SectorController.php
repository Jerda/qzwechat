<?php
/**
 * 部门控制器
 */

namespace app\admin\controller;

use app\common\model\Sector;
use think\Controller;
use think\Exception;
use think\Request;

class SectorController extends BaseController
{
    protected $name = 'sector';

    /**
     * 部门列表
     *
     * @param $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $this->data = $request->param();
        $parent_name = '';

        if (isset($this->data['sector_id'])) {
            $sectors = Sector::where(['parent_id' => $this->data['sector_id']])->paginate();
            $parent_name = Sector::where(['id' => $this->data['sector_id']])->value('name');
        } else {
            //获取顶级部门
            $sectors = Sector::where(['level' => 0])->paginate();
        }

        return $this->fetch('', compact('sectors', 'parent_name'));
    }

    /**
     * Get请求：显示添加页面     Post请求：添加部门
     *
     * @param Request $request
     * @param Sector $sector
     * @return mixed
     */
    public function add(Request $request, Sector $sector)
    {
        $this->init();
        //显示添加/编辑页面
        if (!$request->isPost()) {
            $sectors = $sector->getSectors();

            if ($this->type == 'edit') {
                $current_sector = Sector::get($this->data['id']);
                return $this->fetch($this->type, compact('sectors', 'current_sector'));
            } else {
                return $this->fetch($this->type, compact('sectors'));
            }
        }

        //添加/编辑数据模式
        $res = $this->_validate();
        if ($res !== true) {
            return back(0, '数据有误:'.$res);
        }
        // 检查是否有当前申请部门是否存在
        $res = Sector::where(['parent_id' => $this->data['parent_id'], 'name' => $this->data['name']])->find();

        if ($res && $this->type == 'add') {
            return back(0, '当前部门已存在');
        }

        //设置部门等级
        //父ID为0，表示添加一级部门，level=0；父ID不等于0，表示下属部门，level+1
        if ($this->data['parent_id'] == 0) {
            $this->data['level'] = 0;
        } else {
            $parent_level = Sector::where('id', $this->data['parent_id'])->value('level');
            $data['level'] = $parent_level + 1;
        }

//        halt($data);
        try {
            if ($this->type == 'add') {
                Sector::create($this->data);
            } else {
                Sector::where('id', $this->data['id'])->update($this->data);
            }
        } catch (Exception $e) {
            return back(0, $this->type_name.'失败'.$e->getMessage());
        }

        return back(1, $this->type_name.'成功');
    }
    
    /**
     * 获取子部门
     *
     * @param Request $request
     */
    public function getSeSector(Request $request)
    {
        $parent_id = $request->param('sector_id');
        $se_sectors = Sector::where(['parent_id' => $parent_id])->select();
        $this->result($se_sectors);
    }
}
