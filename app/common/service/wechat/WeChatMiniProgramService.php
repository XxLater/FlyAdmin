<?php

declare(strict_types=1);

/**
 * @class 微信小程序服务类
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\service\wechat;

use app\common\exception\ServiceException;
use app\common\service\BaseService;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use EasyWeChat\MiniProgram\Application;

class WeChatMiniProgramService extends BaseService
{
    /**
     * @var \EasyWeChat\MiniProgram\Application
     */
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
        $config = system_config(['program_app_id','program_app_secret']);
        return [
            'app_id' => $config[0],
            'secret' => $config[1],
            'response_type' => 'array',
        ];
    }

    /**
     * 用户登陆
     * @param string $code
     * @return mixed
     * @throws InvalidConfigException
     */
    public function login(string $code)
    {
        return $this->service->auth->session($code);
    }

    public function decryptData($session, $iv, $encryptedData):array
    {
        return $this->service->encryptor->decryptData($session,$iv,$encryptedData);
    }

    /**
     * @return Application
     */
    public function getService():Application
    {
        return $this->service;
    }
}