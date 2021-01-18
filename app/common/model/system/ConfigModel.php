<?php

declare(strict_types=1);

/**
 * @class 系统配置表
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\model\system;


use app\common\model\BaseModel;

class ConfigModel extends BaseModel
{
    protected $name = 'config';

    /**
     * @return string
     */
    public function getPk():string
    {
        return 'config_id';
    }
}