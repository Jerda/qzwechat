<?php

namespace app\admin\controller\setting;

use think\Request;

class WechatController extends BaseSettingController
{
    protected $preg_rule = [
        'app_id' => "/('app_id'\s*=>\s*')(\s*\w*)(')/",
        'secret' => "/('secret'\s*=>\s*')(\s*\w*)'/",
        'token' => "/('token'\s*=>\s*')(\s*\w*)'/",
        'aes_key' => "/('aes_key'\s*=>\s*')(\s*\w*)'/"
    ];

    public function _initialize()
    {
        parent::_initialize();
        $this->wechat_path = $this->extra_path."/wechat.php";
    }

    public function index()
    {
        $config = config('wechat');
        return $this->fetch('wechat', compact('config'));
    }

    /**
     * 微信配置
     *
     * @param Request $request
     * @return \think\response\Json
     */
    public function weChatSetting(Request $request)
    {
        $data = $request->param();
        //封装到common.php
        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }

        if ($this->writeFile($data, $this->wechat_path)) {
            return back(1, '修改成功');
        } else {
            return back(0, '修改失败');
        }
    }
}
