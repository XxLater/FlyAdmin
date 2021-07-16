<?php

namespace app\common\validate;

class RoleValidate extends BaseValidate
{
    protected $rule = 
    [
        // 'menu|菜单权限'              => 'require',
        'title|角色标题'             => 'require|unique:role',
        'status|状态'                => 'number'
    ];
}