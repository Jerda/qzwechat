<?php
/**
 * 后台首页控制器
 */
namespace app\admin\controller;

use think\Request;

class IndexController extends BaseController
{
    public function index()
    {
        $user = session('admin_user', '', 'admin');

        if (! $user) {
            $this->redirect(url('auth.login/index'));
        }

        return $this->fetch('',[
            'user' => $user,
        ]);
    }
}
