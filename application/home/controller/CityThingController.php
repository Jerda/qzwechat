<?php
/**
 * 小城实事
 */
namespace app\home\controller;

use think\Controller;
use think\Request;

class CityThingController extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}
