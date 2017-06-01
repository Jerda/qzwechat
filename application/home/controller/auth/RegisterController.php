<?php

namespace app\home\controller\auth;

use app\common\model\User;
use app\common\traits\AuthRegister;
use think\Controller;
class RegisterController extends Controller
{
    use AuthRegister;
    //定义模型类就可以使用AuthRegister了
    protected $model;

    public function _initialize()
    {
        $this->model = new User();
    }
    /**
     * 注册页面
     *
     * @return mixed
     */
    public function index()
    {
        return $this->fetch('index');
    }

    public function check()
    {
        return $this->reg();
    }

}
