<?php
/**
 * 前台验证器
 */
namespace app\common\validate;

use think\Validate;

class Home extends Validate
{
    protected $rule = [
        'query_criteria' => 'require',
        'keyword' => 'require'
    ];

    protected $scene = [
        'gs_query' => ['query_criteria', 'keyword']  //政府架构->查询
    ];


}