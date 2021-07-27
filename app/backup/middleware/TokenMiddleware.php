<?php

declare(strict_types=1);

/**
 * @class
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\backup\middleware;

use app\Request;
use think\Response;
use app\common\service\utils\TokenService;
use app\common\service\user\UserService;

class TokenMiddleware
{
    /**
     * @var app\Request
     */
    protected $request;

    public function before(Request $request)
    {
        $token = $request->param('token');

        if (!$uid = TokenService::instance()->verify($token)) {
            app('response')->fail('token已经失效',[],40001);
        }
        
        $user = UserService::instance()->findOrEmpty($uid);

        if ($user->isEmpty()){
            app('response')->fail('用户不存在', [], 40001);
        }

        $request->user_id = $uid;
    }

    public function handle(Request $request , \Closure $next)
    {
        $this->before($request);
        $this->request = $request;
        $response = $next($request);
        $this->after($response);
        return $response;
    }

    public function after(Response $response)
    {
    }
}