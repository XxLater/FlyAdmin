<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\service\system;


use app\common\model\system\RoleModel;
use app\common\service\BaseService;
use app\common\service\utils\TreeService;

class RoleService extends BaseService
{
    /**
     * @var RoleModel
     */
    protected $model;

    public function __construct(RoleModel $model)
    {
        $this->model = $model;
    }

    public function adminAuth($role_id)
    {
        $role = $this->model->where('role_id',$role_id)->where('status',1)->find();

        if (!$role) $this->error('角色已被禁用',[],40003);

        $menuService = app()->make(MenuService::class);

        $menu_list = $menuService->getNavMenuList(explode(',',$role['menu']));

        $menu_id_list = array_column($menu_list,'menu_id');

        $path = '/admin/'.get_path();

        $menu = $menuService->pathByMenu($path);

        if ($path !== '/admin/index/index')
        {
            if (!$menu || $menu['status'] !== 1) $this->error('菜单不存在');

            if (!in_array($menu['menu_id'],$menu_id_list)) $this->error('非法访问',[],403);
        }

        return TreeService::instance()->init($menu_list,'menu_id')->toTreeList();
    }
}