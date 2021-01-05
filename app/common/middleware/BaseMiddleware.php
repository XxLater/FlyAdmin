<?php

declare(strict_types=1);

/**
 * @class
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\middleware;


use app\Request;
use think\Response;

abstract class BaseMiddleware
{
    /**
     * @var Request
     */
    protected $request;
    abstract public function before(Request $request);

    abstract public function after(Response $response);

    final public function handle(Request $request , \Closure $next)
    {
        $this->request = $request;
        $this->before($request);
        $response = $next($request);
        $this->after($response);
        return $response;
    }
}