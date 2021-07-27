<?php

/**
 * @class  登陆中心
 * @author echo
 * @email  945462788@qq.com
 * @github https://github.com/945462788
 */
namespace app\backup\controller;

use app\common\service\utils\TokenService;
use app\backup\model\user\UserModel;
use app\common\controller\Base;
use app\common\service\wechat\WeChatMiniProgramService;

class Auth extends Base
{
    /**
     * 微信小程序登陆
     */
    public function weChatAppLogin():void
    {
        [$code] = param_list(['code',null]);

        $miniProgramService = app()->make(WeChatMiniProgramService::class);

        $sessionKey = cache('wx_app_user_session_'.md5($code));

        if (!$code) app('response')->fail('缺少code参数',[],40002);

        if ($code && !$sessionKey)
        {
            $userInfo = $miniProgramService->login($code);
            $sessionKey = $userInfo['session_key'];

            cache('wx_app_user_session_'.$code,$sessionKey,86400);
        }

        // [$iv,$encryptedData] = param_list(['iv',''],['encryptedData','']);

        // $userInfo = $miniProgramService->decryptData($sessionKey,$iv,$encryptedData);

        $userModel = app()->make(UserModel::class);

        if ($uid = $userModel->saveWeChatAppUser($userInfo))
        {
            $token = TokenService::instance()->create($uid);

            app('response')->success(compact('token'));
        }

        app('response')->fail('微信小程序登录失败，请稍后重试');
    }
}