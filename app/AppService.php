<?php
declare (strict_types = 1);

namespace app;

use app\common\service\ResponseService;
use think\Service;

/**
 * 应用服务类
 */
class AppService extends Service
{
    public function register()
    {
        // 服务注册

        //响应服务类
        $this->app->bind('response',ResponseService::class);
    }

    public function boot()
    {
        // 服务启动
    }
}
