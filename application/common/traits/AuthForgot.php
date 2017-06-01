<?php

namespace app\common\traits;

use think\Exception;

trait AuthForgot
{
    public function doSend($email)
    {
        $data = request()->param();
        $model_name = $this->model->attr('name');
        $res = $this->validate($data, $model_name.'.forgot_password');

        if ($res !== true) {
            return back(0, $res);
        }

        $user = $this->model::where('email', $data['email'])->find();
        if (empty($user)) {
            return back(0, '该邮箱不存在');
        }

        $token = $this->storeInfo($user->email);

        if (!$token) {
            return back(0, '系统错误');
        }

        $res = $this->sendEmail($user->email, $token, $email);

        if ($res === true) {
            return back(1, '邮件发送成功，查看邮件重置密码');
        } else {
            return back(0, '邮件发送失败<br>'.$res);
        }
    }

    public function doReset()
    {
        $model_name = $this->model->attr('name');

        if (request()->isPost()) {
            $data = request()->param();
            return request()->controller()->fetch('reset', compact('data'));
        }

        $data = request()->param();
        $res = $this->validate($data, $model_name.'.reset_password');

        if ($res !== true) {
            return back(0, '提交的数据有误');
        }

        $where = [
            'token' => ['eq', $data['token']],
            'create_time' => ['<', time()+60*60*24]
        ];
        $reset = $this->password_reset_table::where($where)->find();

        if (!$reset) {
            return back(0, 'token值可能已过期，请重新发送重置邮件');
        }

        $user = $this->model::where('email', $reset->email)->find();
        $newPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        Db::startTrans();
        try {
            $user->save(['password' => $newPassword]);
            $reset->save(['token' => request()->token()]);
            Db::commit();
        } catch (Exception $e) {
            Db::rollback();
            return back(0, '系统错误');
        }

        return back(1, '重置成功');
    }

    /**
     * 发送找回密码邮件
     *
     * @param $user_email  string  用户邮箱
     * @param $token             string  token值
     * @param \Email $email              发送邮件类
     * @return mixed                     发送成功返回true，否则返回错误信息
     */
    public function sendEmail($user_email, $token, $email)
    {
        $subject = '密码找回';
        $url = url(request()->controller().'/forgotPassword/reset', ['token' => $token], '', 'true');

        $body = '点击重置密码'.$url;

        return $email->sendMail($user_email, $subject, $body);
    }

    /**
     * 将数据写入数据库，成功返回token值
     *
     * @param $email    string  用户邮箱
     * @return bool|string
     */
    public function storeInfo($email)
    {
        $res = $this->password_reset_table::where('email', $email)->find();
        $token = request()->token();

        try {
            if (!empty($res)) {
                $res->save(['token' => $token]);
            } else {
                $this->password_reset_table::create([
                    'email' => $email,
                    'token' => $token
                ]);
            }
        } catch (Exception $e) {
            return false;
        }

        return $token;
    }
}

