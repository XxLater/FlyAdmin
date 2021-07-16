<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\model\user;

use app\common\model\BaseModel;

class RoleModel extends BaseModel
{
    protected $name = 'role';

    protected $pk = 'role_id';

    public function setMenuAttr($value)
    {
        return implode(',',$value);
    }
}