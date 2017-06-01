<?php
/**
 * 后台注册控制器
 */
namespace app\admin\controller\auth;

use app\common\controller\AuthController;
use app\common\model\Admin;
use app\common\traits\AuthRegister;
class RegisterController extends AuthController
{
    use AuthRegister;
    //定义模型类就可以使用AuthRegister了
    protected $model;

    public function _initialize()
    {
        $this->model = new Admin();
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
