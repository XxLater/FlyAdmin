<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\validate;

class AttachmentValidate extends BaseValidate
{
    protected $rule =   [
        'name'  => 'require|max:64',
        'md5'   => 'require|max:256',
        'type' =>  'require|in:1,2,3,4',
        'path' =>  'require|max:256',
        'status' => 'in:0,1',
    ];
}