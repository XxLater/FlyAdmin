<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\validate;

class LogValidate extends BaseValidate
{
    protected $rule = 
    [
        'module|模块'                 => 'require|max:20|alphaDash',
        'method|请求类型'              => 'require|max:20|alphaDash',
        'href|请求地址'                => 'require|max:50',
        'client|操作浏览器'             => 'require|max:50',
        'ip|操作ip'                     => 'require',
        'terminal|操作系统'              => 'max:50',
        'user_id|用户id'                => 'require|number',
        // 'param|请求数据'                 => '',
        // 'response|响应数据'              => '',
        'create_time|创建时间'           => 'number'
    ];

    protected $scene = [
        'create'             => ['module','method','href','client','ip','terminal','user_id','param','response','create_time'],
    ];
}