<?php
/**
 * 微信设置
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;
use EasyWeChat\Foundation\Application;

class WeChatController extends Controller
{
    private $options = [
        'debug' => true,
        'app_id' => '',
        'secret' => '',
        'token' => '',
        // 'aes_key' => null, // 可选
        'log' => [
            'level' => 'debug',
            'file' => '/Users/tangsanquan/work/webroot/qzwechat/tmp/easywechat.log', // XXX: 绝对路径！！！！
        ],
    ];

    public function _initialize()
    {
        $this->options['app_id'] = config('wechat.app_id');
        $this->options['secret'] = config('wechat.secret');
        $this->options['token'] = config('wechat.token');
    }

    public function server()
    {
        $app = new Application($this->options);
        $server = $app->server;

        $server->setMessageHandler(function ($message) {
            return "您好！欢迎关注我!";
        });

        $response = $app->server->serve();
        // 将响应输出
        $response->send();
    }

    public function editButton()
    {
        $app = new Application($this->options);
        $menu = $app->menu;

        $buttons = [
            [
                "type" => "view",
                "name" => "小城实事",
                "url"  => "http://tangsanquan.ngrok.cc/qzwechat/public/index.php/home/cityThing/index"
            ],
            [
                "type" => "view",
                "name" => "智慧党建",
                "url"  => "http://tangsanquan.ngrok.cc/qzwechat/public/index.php/home/governmentChannel/index"
            ],
        ];

        $menu->add($buttons);
    }
}
