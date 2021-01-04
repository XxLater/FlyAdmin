<?php

declare(strict_types=1);

/**
 * @class 用户服务类
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\service;


class UserService extends BaseService
{
    protected $model;

    /**
     * 小程序用户登陆
     * @param string 微信小程序登陆码
     */
    public function weChatAppLogin(string $code)
    {
        $login = WeChatMiniProgramService::instance()->login($code);


    }
}