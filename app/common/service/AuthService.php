<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/
namespace app\common\service;
use app\common\exception\ServiceException;

class AuthService extends BaseService
{
    /**
     * 验证token
     * @param string
     * @return mixed
     */
    public function check(string $token)
    {
        return TokenService::instance()->verify($token);
    }
}