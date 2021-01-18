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

class RoleModel extends BaseModel
{
    protected $name = 'role';

    /**
     * @return string
     */
    public function getPk():string
    {
        return 'role_id';
    }
}