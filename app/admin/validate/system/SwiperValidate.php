<?php

namespace app\admin\validate\system;

use app\common\validate\BaseValidate;

class SwiperValidate extends BaseValidate
{
    protected $rule = [
        'image|图片链接'  => 'require|max:256',
        'sort|排序'      => 'require|number'
    ];

    protected $scene = 
    [
        'create'  => ['image','sort'],
        'update'  => ['image','sort'],
    ];
}