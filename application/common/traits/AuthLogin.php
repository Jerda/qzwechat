<?php

namespace app\common\traits;

trait AuthLogin
{
    public function login()
    {
        //todo-me 封装
        $data = request()->param();
        $model_name = $this->model->attr('name');
        $res = $this->validate($data, $model_name.'.login');

        if($res !== true) {
            return back(0, '数据不正确'.$res);
        }

        $user = $this->model::get(['username' => $data['username']]);

        if(!$user) {
            return back(0, '用户不存在');
        }

        if (! password_verify($data['password'], $user->password)) {
            return back(0, '密码错误');
        }

        /*if (!$admin_user->status) {
            $this->error('该管理员还没有通过超级管理审核');
        }*/

        session(lcfirst($model_name).'_user', $user, lcfirst($model_name));
        return back(1, '登录成功');
    }
}

