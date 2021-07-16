<?php
declare(strict_types=1);

namespace app\common\model\system;

use app\common\model\BaseModel;
use EasyWeChat\Kernel\Clauses\Clause;

Class ConstructorModel extends BaseModel
{
    protected $name = 'constructor';

    /**
     * @return string
     */
    public function getPk():string
    {
        return 'id';
    }
}