<?php

namespace app\login\controller;

use think\Controller;

class loginController extends Controller
{
    public function _initialize()
    {
        if(!session('?admin.user')){
            $this->redirect(url('index/Index'));
        }
    }
}
