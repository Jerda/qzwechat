<?php

namespace app\common\traits;

use think\Exception;
trait AuthRegister
{
    public function reg()
    {
        $data = request()->param();
        $model_name = $this->model->attr('name');
        $res = $this->validate($data, $model_name.'.register');

        if ($res === true) {
            unset($data['password_confirm']);
        } else {
            return back(0, $res);
        }

        if ($this->model::where('username' , $data['username'])->find()) {
            return back(0, '该用户名已注册');
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        try {
            $user = $this->model::create($data);
        } catch (Exception $e) {
            return back(0, '系统错误！'.$e->getMessage());
        }

        session(lcfirst($model_name).'_user', $user, lcfirst($model_name));
        return back(1, '注册成功');
    }
}

