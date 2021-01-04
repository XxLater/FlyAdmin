<?php

declare(strict_types=1);

/**
 * @class
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\controller;


use app\BaseController;
use app\common\service\ConfigService;

class Index extends BaseController
{
    /**
     * 测试
     */
    public function index()
    {
        [$code,$session_key] = param_list(['code',''],['session_key','']);

        p(compact('code','session_key'));
    }
}