<?php
/**
 * 后台登录控制器
 */

namespace app\admin\controller\auth;

use app\common\model\Admin;
use app\common\model\User;
use app\common\traits\AuthLogin;
use think\Controller;
use think\Request;

class LoginController extends Controller
{
    use AuthLogin;
    //定义用户模型并初始化就可以是用AuthLogin了
    protected $model;

    public function _initialize()
    {
        $this->model = new Admin();
    }
    /**
     * 登录页面
     * @return mixed
     */
    public function index()
    {
        $user = session('admin_user', '', 'admin');

        if ($user) {
            $this->redirect(url('index/index'));
        }

        return $this->fetch();
    }

    /**
     * 登录
     * @return \think\response\Json
     */
    public function check()
    {
        return $this->login();
    }

    /**
     * 用户登出
     * //todo-me 考虑该方法是否加入AuthLogin中
     */
    public function loginOut()
    {
        session(null, 'admin');
        $this->redirect(url('auth.login/index'));
    }
}
