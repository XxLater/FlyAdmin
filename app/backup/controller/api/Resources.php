<?php

declare(strict_types=1);

/**
 * @class
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\controller1\api;


use app\BaseController;
use app\common\service\utils\TokenService;
use app\common\service\wechat\WeChatService;

class Resources extends BaseController
{
    public function WeChatJsSdkConfig():void
    {
        $url = $this->request->param('url');

        app('response')->success(WeChatService::instance()->jsSdk($url));
    }

    /**
     * @param $user_id
     */
    public function getToken($user_id=null): void
    {
        app('response')->success(['token'=>TokenService::instance()->create($user_id)]);
    }
}