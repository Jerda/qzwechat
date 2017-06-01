<?php

namespace app\home\controller;

use think\Controller;
use think\Request;

class GovernmentChannelController extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}
