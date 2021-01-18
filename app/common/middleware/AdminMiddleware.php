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
use think\exception\HttpResponseException;
use think\Response;
use app\common\service\utils\TokenService;
use app\common\service\user\UserService;

class AdminMiddleware
{
    public function before(Request $request)
    {
        $token = session('user_token');

        if (!$token) {
            throw new HttpResponseException(redirect('admin/auth/login'));
        }

        if (!$uid = TokenService::instance()->verify($token)) {
            throw new HttpResponseException(redirect('admin/auth/login'));
        }

        $user = UserService::instance()->userIdByUser($uid);

        if ($user->isEmpty()) {
            app('response')->fail('用户不存在', [], 40003);
        }

        $request->user_id = $uid;

        $request->role_id = $user['role_id'];
    }

    public function handle(Request $request , \Closure $next)
    {
        $this->before($request);
        $response = $next($request);
        $this->after($response);
        return $response;
    }

    public function after(Response $response)
    {
        // TODO: Implement after() method.
    }
}