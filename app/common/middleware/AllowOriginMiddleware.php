<?php
// +----------------------------------------------------------------------
// | CRMEB [ CRMEB赋能开发者，助力企业发展 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2020 https://www.crmeb.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed CRMEB并不是自由软件，未经许可不能去掉CRMEB相关版权
// +----------------------------------------------------------------------
// | Author: CRMEB Team <admin@crmeb.com>
// +----------------------------------------------------------------------



namespace app\common\middleware;


use app\Request;
use think\exception\HttpResponseException;
use think\facade\Config;
use think\Response;

/**
 * 跨域中间件
 * Class AllowOriginMiddleware
 * @package app\http\middleware
 */
class AllowOriginMiddleware extends BaseMiddleware
{
    /**
     * header头
     * @var array
     */
    protected $header = [
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Headers' => 'token,Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With',
        'Access-Control-Allow-Methods' => 'GET,POST,PATCH,PUT,DELETE,OPTIONS,DELETE',
        'Access-Control-Max-Age' => '1728000',
    ];

    public function before(Request $request)
    {
        $origin = $request->header('origin');
        $this->header['Access-Control-Allow-Origin'] = $origin;
        p($request->param());

        if ($request->method(true) === 'OPTIONS') {
            throw new HttpResponseException(Response::create()->code(200)->header($this->header));
        }
    }

    public function after(Response $response)
    {
        $response->header($this->header);
    }
}
