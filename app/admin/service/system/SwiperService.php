<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\admin\service\system;

use app\admin\model\system\SwiperModel;
use app\admin\validate\system\SwiperValidate;
use app\common\service\BaseService;

class SwiperService extends BaseService
{
    /**
     * @var MenuModel
     */
    protected $model;

    public function __construct(SwiperModel $model,SwiperValidate $validate)
    {
        $this->model = $model;

        $this->validate = $validate;
    }
}