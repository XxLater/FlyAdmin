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
use think\exception\HttpResponseException;
class AllowOriginMiddleware extends BaseMiddleware
{
    protected $header = [
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Headers' => 'Token, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since',
        'Access-Control-Allow-Methods' => 'GET,POST,PATCH,PUT,DELETE,OPTIONS,DELETE',
        'Access-Control-Max-Age' => '1728000'
    ];


    public function before(Request $request):void
    {
        $origin = $request->header('origin');
        if ($origin)
            $this->header['Access-Control-Allow-Origin'] = $origin;
        if ($request->method(true) === 'OPTIONS') {
            throw new HttpResponseException(Response::create()->code(200)->header($this->header));
        }
    }

    public function after(Response $response):void
    {
        $response->header($this->header);
    }
}