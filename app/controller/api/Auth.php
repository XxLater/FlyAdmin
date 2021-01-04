<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\controller\api;
use app\common\service\WeChatMiniProgramService;

class Auth extends ApiBase
{

    /**
     * 微信小程序登陆
     */
    public function weChatAppLogin()
    {
        $code = $this->request->param('code',null);

        if (!$code) app('response')->fail('code不能为空');

        $userInfo = WeChatMiniProgramService::instance()->login($code);

        $open_id = $userInfo['openid'];

        $session_key = $userInfo['session_key'];

        app('response')->success(compact('open_id','session_key'));
    }
}