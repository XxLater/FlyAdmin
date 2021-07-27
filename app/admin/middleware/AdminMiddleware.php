<?php

declare(strict_types=1);

/**
 * @class
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\admin\middleware;

use app\common\service\system\LogService;
use app\Request;
use app\admin\service\user\RoleService;
use think\exception\HttpResponseException;
use think\Response;
use app\common\service\utils\TokenService;
use app\common\service\user\UserService;

class AdminMiddleware
{
    /**
     * @var app\Request
     */
    protected $request;

    public function before(Request $request)
    {
        $token = session('user_token');

        if (!$uid = TokenService::instance()->verify($token)) {
            if($request->isAjax())
            {
                app('response')->fail('用户不存在',[],40001);
            }else {
                throw new HttpResponseException(redirect('/admin/auth/login'));
            }
        }
        
        $user = UserService::instance()->findOrEmpty($uid);

        if ($user->isEmpty()){
            app('response')->fail('用户不存在', [], 40003);
        }

        $request->user_id = $uid;

        $request->role_id = $user->getData('role_id');

        $roleService = app()->make(RoleService::class);

        $role = $roleService->find($user->getData('role_id'));

        if (!$role or $role['status'] != 1) app('response')->fail('角色不存在',[],40001);

        $roleService->getAuthMenuList($role);

        $menu_path = get_path();
        
        $roleService->authMenu($role,$menu_path);
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
        LogService::instance()->create($this->request,$response);
    }
}