<?php
/**
 * 部门职员控制器
 */
namespace app\admin\controller;

use app\common\model\Sector;
use app\common\model\Personnel;
use think\Exception;
use think\Request;

class PersonnelController extends BaseController
{
    protected $name = 'personnel';

    /**
     * 显示部门职员列表
     *
     * @param $request
     * @return mixed
     */
    public function index(Request $request)
    {
        //查询显示职员列表
        if ($request->isPost()) {
            $personnels = $this->queryPersonnel($request->param());
//            $personnels = $personnels->paginate(5);
        } else {
            $personnels = Personnel::paginate(5);
        }


        $sectors = Sector::where(['level' => 0])->select();

        return $this->fetch('', compact('personnels', 'sectors'));
    }

    /**
     * 显示修改页面/修改职员信息
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->init();

        if (!$request->isPost()) {
            $personnel = '';
            $sectors = Sector::where(['level' => 0])->select();

            if ($this->type == 'edit') {
                $personnel = Personnel::get($this->data['id']);
            }
            return $this->fetch($this->type, compact('sectors', 'personnel'));
        }

        $res = $this->_validate();

        if ($res !== true) {
            return back(0, '数据有误:'.$res);
        }

        if ($this->type == 'add') {
            $res = $this->add();
        } else {
            $res = $this->edit();
        }

        if ($res !== true) {
            return back(0, $this->type.'失败'.$res);
        }
        return back(1, $this->type.'成功');
    }

    /**
     * //todo-me重构
     * @return bool|string
     */
    public function add()
    {
        $sector_ids = [$this->data['sector_id'], $this->data['se_sector_id']];
        $sector = Sector::where(['id' => $this->data['sector_id']])->find();
        $se_sector = Sector::where(['id' => $this->data['se_sector_id']])->find();
        $this->data['sector'] = $sector->name."---".$se_sector->name;
        unset($this->data['sector_id']);
        unset($this->data['se_sector_id']);

        try {
            $personnel = Personnel::create($this->data);
            $personnel->sectors()->attach($sector_ids);
            $sector->save(['personnel_count' => $sector->personnel_count + 1]);
            $se_sector->save(['personnel_count' => $se_sector->personnel_count + 1]);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return true;
    }

    /**
     * 显示修改页面/修改职员信息
     *
     * @return mixed
     */
    public function edit()
    {
        try {
            Personnel::update($this->data, ['id' => $this->data['id']]);
        } catch (Exception $e) {
            return back(0, '修改失败');
        }
        return back(1, '修改成功');
    }

    /**
     * 通过查询条件查询用户
     *
     * @param $data
     * @return array
     */
    private function queryPersonnel($data)
    {
        $where = [];

        if ($data['sector_id'][0] == 0 && !empty($data['keyword'])) {
            return Personnel::where('name', 'like', '%'.$data['keyword'].'%')->paginate(5);
        }

        $length = count($data['sector_id']);

        if ($data['sector_id'][$length-1] != 0) {
            $_where['id'] = ['eq', $data['sector_id'][$length - 1]];
        } else {
            $_where['id'] = ['eq', $data['sector_id'][$length - 2]];
        }

        $sector = Sector::relation('personnels')->where($_where)->find();

        if (!empty($data['keyword'])) {
            $personnels = $sector->personnels()->where('name', 'like', '%'.$data['keyword'].'%')->paginate(5);
        }

        if ($data['keyword'] == '') {
            $personnels = $sector->personnels()->paginate(5);
        }

        return $personnels;

    }
}
