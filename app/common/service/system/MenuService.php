<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\service\system;


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
}