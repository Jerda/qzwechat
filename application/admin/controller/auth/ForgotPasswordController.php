<?php

namespace app\admin\controller\auth;

use app\common\model\Admin;
use app\common\model\AdminPasswordReset;
use app\common\traits\AuthForgot;
use think\Controller;

class ForgotPasswordController extends Controller
{
    use AuthForgot;
    //下面三步申明，就可以使用AuthForgot了
    //定义用户模型
    protected $model;
    //定义密码重置表模型
    protected $password_reset_table;

    public function _initialize()
    {
        $this->model = new Admin();
        $this->password_reset_table = new AdminPasswordReset();
    }

    /**
     * 显示忘记密码页面
     *
     * @return mixed
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 发送重置密码连接给用户
     * @param \Email $email
     * @return \think\response\Json
     */
    public function send(\Email $email)
    {
        return $this->doSend($email);
    }

    /**
     * 显示重置密码页面/重置密码
     * @return mixed|\think\response\Json
     */
    public function reset()
    {
        return $this->doReset();
    }
}
