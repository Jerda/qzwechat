<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class SystemController extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}
