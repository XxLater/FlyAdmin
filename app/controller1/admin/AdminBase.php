<?php

declare(strict_types=1);

/**
 * @class
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\controller1\admin;


use app\BaseController;
use app\common\middleware\AdminMiddleware;
use app\common\service\system\RoleService;
use think\App;

class AdminBase extends BaseController
{
    protected $middleware = [AdminMiddleware::class];

    public function __construct(App $app)
    {
        parent::__construct($app);

        $menu_list  = RoleService::instance()->adminAuth($this->request->role_id);

        $this->assign('menu_list',$menu_list);
    }


}