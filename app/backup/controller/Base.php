<?php

namespace app\backup\controller;

use app\common\controller\Base as BaseController;
use app\backup\middleware\TokenMiddleware;

class Base extends BaseController
{
    protected $middleware = [TokenMiddleware::class];
}