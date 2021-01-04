<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\exception;


use think\db\exception\DataNotFoundException;
use think\exception\Handle;
use think\Response;
use Throwable;

class Http extends Handle
{
    public function render($request, Throwable $e): Response
    {
        if ($e instanceof ServiceException)
        {
            app('response')->fail(is_debug() ? $e->getMessage() : '服务器错误', is_debug() ? $e->getData() : []);
        } else if ($e instanceof DataNotFoundException)
        {
            app('response')->fail(is_debug() ? $e->getMessage() :'数据不存在');
        }
        return parent::render($request, $e); // TODO: Change the autogenerated stub
    }
}