<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\admin\controller;


use app\BaseController;
use app\common\service\system\RoleService;
use app\common\middleware\AdminMiddleware;
use think\App;

class Base extends BaseController
{

    protected $middleware = [AdminMiddleware::class];

    public function __construct(App $app)
    {
        parent::__construct($app);
//        $this->request->role_id = 1;
//        $menu_list  = RoleService::instance()->adminAuth($this->request->role_id);
    }
}