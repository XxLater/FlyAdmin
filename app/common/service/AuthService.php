<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\service;


class AuthService extends BaseService
{
    /**
     * 验证token
     * @return mixed
     */
    public function check()
    {
        $token = request()->header('token');

        return TokenService::instance()->verify($token);
    }

    /**
     * 微信小程序登录
     * @param null|string $code
     */
    public function weChatAppLogin($code = null):void
    {
//        return WeChatService::instance()->
    }
}