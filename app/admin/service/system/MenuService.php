<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\admin\service\system;

use app\common\model\system\MenuModel;
use app\common\service\BaseService;

class MenuService extends BaseService
{
    /**
     * @var MenuModel
     */
    protected $model;

    public function __construct(MenuModel $model)
    {
        $this->model = $model;
    }

    public function addDefaultMenu($pid=0,$basePath='')
    {
        $parentMenu = $this->model->find($pid);

        $pid = $parentMenu['id'] ?? $pid;

        $basePath = explode('/',$basePath);

        $basePath = '/'.$basePath[1].'/'.$basePath[2].'/';

        $defaultMenuData = ['create'=>'新增','update'=>'编辑','quickEdit'=>'快速编辑','delete'=>'删除'];

        $menuData = [];

        $sort = 100;

        foreach($defaultMenuData as $key=>$value)
        {
            $menuData[] = ['title'=>$value,'href'=>$basePath.$key,'pid'=>$pid,'status'=>1,'is_hidden'=>1,'type'=>3,'sort'=>$sort];

            $sort --;
        }

        p($menuData);

        return $this->model->saveAll($menuData);
    }
}