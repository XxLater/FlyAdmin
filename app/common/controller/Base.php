<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\controller;


use app\BaseController;
use think\App;

class Base extends BaseController
{
    /**
     * 服务类
     * @var [type]
     */
    protected $service;

    public function __construct(App $app)
    {
        parent::__construct($app);
    }
}