<?php
namespace app\common;

use think\Request;
use think\Validate;

class FormRequest extends Request
{
    public function __construct()
    {
        parent::__construct();
        $this->validate();
    }


    private function validate()
    {
        $validate = new Validate([
            '__token__' => 'token'
        ]);

        if(!$validate->check($this->param)) {
            exception('token错误');
        } else {
            halt('1');
        }
    }
}