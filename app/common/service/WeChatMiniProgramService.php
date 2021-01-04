<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\service;

use app\common\exception\ServiceException;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;

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
            'app_id' => 'wx4e248c819fec6cba',
            'secret' => '3d93085606ce459f8f77a39d5756cdd2',
            'response_type' => 'array',
        ];
    }

    /**
     * 用户登陆
     * @param string $code
     * @return mixed
     * @throws InvalidConfigException|ServiceException
     */
    public function login(string $code)
    {
        return $this->responseCheck($this->service->auth->session($code));
    }

    /**
     * @param $response
     * @return mixed
     * @throws ServiceException
     */
    public function responseCheck($response)
    {
        if (!isset($response['errcode']) || $response['errcode'] !== 0)
        {
            $this->error('微信小程序登陆失败',$response);
        }
        return $response;
    }
}