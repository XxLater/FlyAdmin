<?php

declare(strict_types=1);

/**
 * @class
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\middleware;


use app\common\service\system\TokenService;
use app\common\service\user\UserService;
use app\Request;
use think\Response;

class TokenMiddleware extends BaseMiddleware
{

    public function before(Request $request):void
    {
        $token = $this->request->header('token');

        if (!$token) app('response')->fail('缺少token参数',[],40002);

        if (!$uid = TokenService::instance()->verify($token)) app('response')->fail('token验证失败',[],40003);

        $user = UserService::instance()->userIdByUser($uid);

        if ($user->isEmpty()) app('response')->fail('用户不存在',[],40003);

        $request->user_id = $uid;
    }

    public function after(Response $response):void
    {

    }
}