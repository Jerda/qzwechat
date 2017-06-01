<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class BaseController extends Controller
{
    protected $name = '';
    protected $type = '';
    protected $type_name = '';
    protected $data = [];
    /**
     * 验证数据
     * @return array|string|true
     */
    protected function _validate()
    {
        return $this->validate($this->data, 'Admin.'.$this->name.'_'.$this->type);
    }

    /**
     * 判定添加还是编辑模式
     */
    protected function setType()
    {
        if (isset($this->data['id'])) {
            $this->type = 'edit';
            $this->type_name = '编辑';
        } else {
            $this->type = 'add';
            $this->type_name = '添加';
        }
    }

    /**
     * 初始化数据
     */
    protected function init()
    {
        $this->data = request()->param();
        $this->setType();
    }
}
