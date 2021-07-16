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
use app\common\validate\AttachmentValidate;

class AttachmentModel extends BaseModel
{
    protected $name = 'attachment';

    public function md5ByFile($md5)
    {
        return $this->where('md5',$md5)->find() ?? [];
    }
}