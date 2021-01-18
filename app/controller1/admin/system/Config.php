<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\controller1\admin\system;


use app\common\service\AuthService;
use app\common\service\system\RoleService;
use app\controller1\admin\AdminBase;

class Config extends AdminBase
{
    public function adminConfig()
    {

    }
    public function site()
    {
        $this->fetch();
    }

    public function email()
    {
        $this->fetch();
    }

    public function sms()
    {
        $this->fetch();
    }

    public function upload()
    {
        $this->fetch();
    }

    public function wechat()
    {
        $this->fetch();
    }

    public function wechatApp()
    {
        $this->fetch();
    }

    public function wechatPay()
    {
        $this->fetch();
    }
}