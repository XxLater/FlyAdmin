<?php

namespace app\common\validate;

class UserValidate extends BaseValidate
{
    protected $rule = 
    [
        'nickname|昵称'              => 'require|max:10',
        'username|登陆名'             =>'require|min:6|max:12|alphaDash|unique:user,status^nickname',
        'mobile|手机号码'             => 'mobile',
        'password|密码'              => 'require|min:6|max:12|alphaDash',
        'confirm_password|确认密码'   => 'require|confirm:password|alphaDash',
        'role_id|角色'               => 'require|number',
        'avatar|头像'                => 'url',
        'wechat_open_id|微信开放id'   => 'require|alphaDash',
        'unionid|微信开放id'          => 'alphaDash',
        'status|状态'                =>  'require'
    ];

    protected $scene = [
        'admin_create'             => ['nickname','username','password','mobile','confirm_password','password','role_id','avatar','status'],
        'wechat_registered'        => ['nickname','username','password','mobile','password','role_id','avatar','wechat_open_id','unionid','status'],
        'admin_update_base'        => ['nickname','username','password','mobile','confirm_password','password','role_id','avatar','status'],
    ];

    protected function scenePerson()
    {
        return $this->only(['avatar','password','confirm_password'])
                ->remove('password','require')
                ->remove('confirm_password','require');
    }
}