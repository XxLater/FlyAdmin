<?php

declare(strict_types=1);

/**
 * @class 用户服务类
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\service\user;


use app\common\model\user\UserModel;
use app\common\service\BaseService;

class UserService extends BaseService
{
    protected $model;

    public function __construct(UserModel $model)
    {
        $this->model = $model;
    }
}