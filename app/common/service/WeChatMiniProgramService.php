<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\service;


use EasyWeChat\Factory;

class WeChatMiniProgramService extends BaseService
{
    protected $service;

    public function __construct()
    {
        $this->service = Factory::miniProgram($this->getConfig());
    }


    /**
     * 获取配置
     * @return array
     */
    protected function getConfig():array
    {
        return [
            'app_id' => '',
            'secret' => '',
            'response_type' => 'array',
        ];
    }
}