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
use think\exception\RouteNotFoundException;
use think\exception\ValidateException;
use think\Response;
use Throwable;
use think\exception\ErrorException;
use think\db\exception\PDOException;

class Http extends Handle
{
    public function render($request, Throwable $e): Response
    {
        if ($e instanceof ServiceException || $e instanceof ErrorException)
        {
            app('response')->fail(is_debug() ? $e->getMessage() : '服务器错误', is_debug() ? $e->getData() : [] , $e->getCode());
        } else if ($e instanceof DataNotFoundException)
        {
            app('response')->fail(is_debug() ? $e->getMessage() :'数据不存在' , $e->getCode());
        }
        else if($e instanceof RouteNotFoundException)
        {
            app('response')->code(404)->fail(is_debug() ? $e->getMessage() : '抱歉，网页丢失',[]);
        }
        else if($e instanceof ValidateException)
        {
            app('response')->fail(is_debug() ? $e->getError() : '服务器错误',[],40002);
        }
        else if($e instanceof PDOException)
        {
            app('response')->fail('服务器错误，操作失败',is_debug() ? $e->getData() : [],40001);
        }
        return parent::render($request, $e); 
    }
}