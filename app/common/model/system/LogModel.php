<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/
namespace app\common\model\system;

use app\admin\service\user\UserService;
use app\common\model\BaseModel;

class LogModel extends BaseModel
{
    protected $name = 'log';

    protected $pk = 'log_id';

    // public function getUSerIdAttr($userId)
    // {
    //     // return UserService::instance()->where('user_id',$userId)->value('nickname');
    // }
}