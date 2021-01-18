<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\model\system;


use app\common\model\BaseModel;

class MenuModel extends BaseModel
{
    protected $name = 'menu';

    /**
     * @return string
     */
    public function getPk():string
    {
        return 'menu_id';
    }

    /**
     * @param array|string $menu_id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getNavMenuList($menu_id):array
    {
        $where['status'] = 1;
        $where['is_hidden'] = 0;
        return $this->where($where)->when($menu_id[0] != '*',function ($query) use ($menu_id){
            $query->whereIn('menu_id',$menu_id);
        })->order('sort desc')->select()->toArray();
    }

    /**
     * @param $path
     * @return array|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function pathByMenu($path)
    {
        return $this->where('url',$path)->find();
    }
}