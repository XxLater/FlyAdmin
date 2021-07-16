<?php

declare(strict_types=1);

/**
 * @class
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\admin\controller;

use app\admin\service\user\UserService;
use app\common\service\utils\TokenService;

/**
 * Class Auth
 * @package app\admin\controller
 * @auth false
 * @menu false
 * @title 系统登陆
 */
class Auth extends Base
{
    protected $middleware = [];

    /**
     * 系统登陆
     * @return ResponseService
     */
    public function login(): void
    {
        if ($this->request->isPost())
        {
            [$username,$password,$code] = param_list(['username',''],['password',''],['code','']);
            
            if (system_config('has_verify_code'))
            {
                if (false == captcha_check($code))
                {
                    app('response')->fail('验证码错误');
                }
            }

            $userService = UserService::instance();

            $user = $userService->userNameByUser($username);

            if (!$user) app('response')->fail('用户不存在');

            if (md5($password) !== $user->getAttr('password')) app('response')->fail('密码错误');

            $userService->userLogin($user);
            
            $token = TokenService::instance()->create($user->user_id);

            session('user_token',$token);

            app('response')->success(compact('token'));
        }

        $this->fetch();
    }

    /**
     * 注销登陆
     * @return ResponseService
     */
    public function logout()
    {
        session('user_token',null);

        app('response')->success();
    }
}