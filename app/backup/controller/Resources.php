<?php

declare(strict_types=1);

/**
 * @class
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\backup\controller;

use app\admin\service\system\SwiperService;
use app\common\controller\Base;
use app\common\service\system\ConfigService;

class Resources extends Base
{
    public function getSwiperList()
    {
        app('response')->success(SwiperService::instance()->limit(10)->column('image'));
    }

    public function getAppInfo()
    {
        $config = ConfigService::instance()->where(['group'=>'wechat_app'])->column('value','key');
        unset($config['program_app_id']);
        unset($config['program_app_secret']);
        app('response')->success($config);
    }
}