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
use app\admin\service\user\UserService;

/**
  * @title 仪表盘
  * @auth
  * @menu true
  * @icon layui-icon-console
 */
class Index extends Base
{
    /**
      * @title 后台首页容器
      * @auth
      * @menu
     */
    public function index()
    {
        $this->assign('user',UserService::instance()->find(is_login()));
        $this->fetch();
    }

    /**
      * @title 控制台
      * @auth  true
      * @menu  true
     */
    public function console()
    {
        $this->fetch();
    }

    /**
      * @title 数据分析
      * @auth  true
      * @menu  true
     */
    public function analysis()
    {
        $this->fetch();
    }
}