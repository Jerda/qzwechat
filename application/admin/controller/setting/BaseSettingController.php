<?php

namespace app\admin\controller\setting;

use think\Controller;
use think\Request;

class BaseSettingController extends Controller
{
    protected $extra_path;

    protected $wechat_path;

    protected $preg_rule = [];

    public function _initialize()
    {
        $this->extra_path = dirname(__FILE__).'/../../../extra';
    }

    /**
     * 将配置的信息写入文件
     *
     * @param $data         array    配置数据
     * @param $file_path    string   文件路径
     * @return bool
     */
    protected function writeFile(array $data, $file_path)
    {
        $file = fopen($file_path, 'r+');
        $content = file_get_contents($file_path, false, null, 0);

        foreach ($data as $key => $value) {
            $pattern = $this->preg_rule[$key];
            //由于函数原因，替换后会将替换的字段后面的分号替换掉（暂时没解决）,所以再后面加了一个分号
            $content = preg_replace($pattern, '${1}'.$value."'", $content);
        }

        $res = fwrite($file, $content);
        fclose($file);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }
}
