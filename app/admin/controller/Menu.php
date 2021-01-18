<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\admin\controller;

use think\facade\Config;
use app\common\service\system\AnnotationService;

class Menu extends Base
{
    /**
      * @title 获取权限菜单
      * @auth
      * @menu
     */
    public function getAuthMenu()
    {
        $menuService = AnnotationService::create(app()->getAppPath().Config::get('route.controller_layer'));

        $menuService->getMethod();

        app('response')->success($menuService->getMenu());
    }
}