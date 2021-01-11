<?php

declare(strict_types=1);

/**
 * @class
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\controller\admin;


class Index extends AdminBase
{
    public function index():void
    {
        $this->fetch();
    }

    public function console():void
    {
        $this->fetch();
    }
}