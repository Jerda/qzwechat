<?php
/**
 * 后台验证器
 */
namespace app\common\validate;

use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        'username' => 'require|min:5|max:16',
        'password' => 'require|confirm',
        'email' => 'require|email',
        'token' => 'require',
//        'captcha|验证码'=>'require|captcha'
        'name' => 'require',
        'address' => 'require',
        'parent_id' => 'require',

        'position' => 'require',
        'tel' => 'require',
        'sector_id' => 'require',
        'se_sector_id' => 'require',
        'id' => 'require',
        'title' => 'require',
        'content' => 'require',
        'author' => 'require',
    ];

    protected $scene = [
        'register' => ['username', 'password', 'email'],
        'login' => ['username', ['password' => 'require']],
        'forgot_password' => ['email'],
        'reset_password' => ['password', 'token'],
        'sector_add' => ['name', 'parent_id'],
        'sector_edit' => ['name', 'parent_id', 'id'],
        'personnel_add' => ['name', 'position', 'tel', 'sector_id', 'se_sector_id'],
        'article_add' => ['title', 'content', 'author'],
        'article_edit' => ['title', 'content', 'author', 'id']
    ];

    protected $message = [

    ];


}