<?php

declare(strict_types=1);

/**
 * @class
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\model\user;

use think\model\concern\SoftDelete;
use app\common\model\BaseModel;

class UserModel extends BaseModel
{
    protected $name = 'user';

    protected $pk ='user_id';
    
    use SoftDelete;

    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;

    public function getLastLoginTimeAttr($time)
    {
        return date('Y-m-d H:i:s',(int)$time);
    }

    public function getRoleIDAttr($role_id)
    {
        $role = (new RoleModel)->find($role_id);
        return $role['title'] ?? '';
    }

    public function setPasswordAttr($password)
    {
        return md5($password);
    }
    
    
}