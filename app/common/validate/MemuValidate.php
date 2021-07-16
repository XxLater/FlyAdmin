<?php

namespace app\common\validate;

class MenuValidate extends BaseValidate
{
    protected $rule = 
    [
        'title|标题'                  => 'require|max:10',
        'pid|上级id'                  => 'number',
        'icon|图标'                   => 'alphaDash',
        'href|地址'                   => 'alphaDash',
        'sort|排序'                   => 'number',
        'status|状态'                 =>  'number',
        'is_hidden|隐藏'              =>  'number',
    ];

    protected $scene = [
        'create'             => ['title','pid','icon','href','sort','status','is_hidden'],
    ];


}