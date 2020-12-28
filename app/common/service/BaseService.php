<?php

declare(strict_types=1);

/**
 * @class 基础服务类
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/

namespace app\common\service;
use think\Container;

class BaseService
{

    /**
     * 静态调用
     * @param mixed ...$args
     * @return BaseService
     */
    public static function instance(...$args):BaseService
    {
        return Container::getInstance()->invokeClass(static::class, $args);
    }
}