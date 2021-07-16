<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\admin\service\user;

use app\common\model\user\RoleModel;
use app\common\service\BaseService;
use app\common\service\utils\TreeService;
use app\common\validate\RoleValidate;
use app\admin\service\system\MenuService;

class RoleService extends BaseService
{
    /**
     * @var RoleModel
     */
    protected $model;

    public function __construct(RoleModel $model, RoleValidate $validate)
    {
        $this->model = $model;
        $this->validate = $validate;
    }

    /**
     * 获取权限菜单
     * @param RoleModel $role
     * @return array
     */
    public function getAuthMenuList(RoleModel $role): array
    {
        $menuService = app()->make(MenuService::class);

        $menu_list = cache('system.auth_menu_'.$role['role_id'].is_debug() ? '12345':'');

        if (!$menu_list)
        {
            $menu_list = $menuService->getNavMenuList(explode(',',$role['menu']));

            $menu_list = TreeService::instance()->init($menu_list,'menu_id')->toTreeList();

            cache('system.auth_menu_'.$role['role_id'],$menu_list,7200);
        }

        return $menu_list;
    }

    /**
     * @param RoleModel $role
     * @param $menu_path
     * @return void
     * @throws \app\common\exception\ServiceException
     */
    public function authMenu(RoleModel $role , $menu_path):void
    {
        $menu_id_list = explode(',',$role['menu']);

        $menuService = app()->make(MenuService::class);

        $except = ['/admin/index/index','/admin/config/adminconfig','/admin/menu/getauthmenu','/admin/api/uploadimage','/admin/user/person'];
        
        if ($menu_id_list[0] !== '*' && !in_array($menu_path,$except))
        {
            $menu = $menuService->pathByMenu($menu_path);

            if (!$menu || $menu['status'] !== 1) $this->error('菜单不存在');

            if (!in_array($menu['menu_id'],$menu_id_list)) $this->error('非法访问',[],40003);
        }
    }
}