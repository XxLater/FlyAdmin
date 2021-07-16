<?php 

namespace app\backup\controller;

use app\BaseController;

class Index extends BaseController
{
    public function index()
    {
       $this->fetch();
    }
}