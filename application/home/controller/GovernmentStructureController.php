<?php
/**
 * 政府架构控制器
 */
namespace app\home\controller;

use app\common\model\Sector;
use app\common\model\Personnel;
use think\Controller;
use think\Request;

class GovernmentStructureController extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}
