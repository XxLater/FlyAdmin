<?php
namespace app;

// 应用请求对象类
class Request extends \think\Request
{

    /**
     * @用户id
     * @var mixed|int
     */
    public $user_id;
    /**
     * @用户角色id
     * @var mixed |int
     */
    public $role_id;
}
