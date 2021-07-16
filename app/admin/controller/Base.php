<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\admin\controller;

use app\admin\middleware\AdminCheckMiddleware;
use app\admin\middleware\AdminMiddleware;
use think\App;
use app\common\controller\Base as BaseController;
class Base extends BaseController
{
    protected $middleware = [AdminMiddleware::class];

    protected $service;

    //v2 删除
    // use ConstructorTrait;

    public function __construct(App $app)
    {
        parent::__construct($app);
    }
}