<?php

declare(strict_types=1);

/**
 * @class 微信服务类
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\service\wechat;


use app\common\service\BaseService;
use EasyWeChat\Factory;
use EasyWeChat\OfficialAccount\Application;
use Overtrue\Socialite\AuthorizeFailedException;

class WeChatService extends BaseService
{
    /**
     * @var \EasyWeChat\OfficialAccount\Application
     */
    protected $service;

    public function __construct()
    {
        $this->service = Factory::officialAccount($this->config());
    }

    /**
     * @return array
     */
    public function config() : array
    {
        $config = system_config(['wechat_app_id','wechat_app_secret']);

        return [
            'app_id' => $config['wechat_app_id'],
            'secret' => $config['wechat_app_secret'],
            'response_type' => 'array',
        ];
    }

    /**
     * @param string $url
     * @return array
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \app\common\exception\ServiceException
     */
    public function jsSdk(string $url):array
    {
        $api_list = ['editAddress', 'openAddress', 'updateTimelineShareData', 'updateAppMessageShareData', 'onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ', 'onMenuShareWeibo', 'onMenuShareQZone', 'startRecord', 'stopRecord', 'onVoiceRecordEnd', 'playVoice', 'pauseVoice', 'stopVoice', 'onVoicePlayEnd', 'uploadVoice', 'downloadVoice', 'chooseImage', 'previewImage', 'uploadImage', 'downloadImage', 'translateVoice', 'getNetworkType', 'openLocation', 'getLocation', 'hideOptionMenu', 'showOptionMenu', 'hideMenuItems', 'showMenuItems', 'hideAllNonBaseMenuItem', 'showAllNonBaseMenuItem', 'closeWindow', 'scanQRCode', 'chooseWXPay', 'openProductSpecificView', 'addCard', 'chooseCard', 'openCard'];

        if (!$url) $this->error('缺少url参数',[],40002);

        $this->service->jssdk->setUrl($url);

        return $this->service->jssdk->buildConfig($api_list,is_debug(),false,false);
    }

    /**
     * @return mixed
     * @throws \app\common\exception\ServiceException
     */
    public function login()
    {
        try {
            return $this->service->oauth->user()->getOriginal();
        } catch (AuthorizeFailedException $exception)
        {
            $this->error('微信登录失败');
        }
    }

    /**
     * @return Application
     */
    public function getService():Application
    {
        return $this->service;
    }

    /**
     * 重定向登录地址
     * @param $redirect_url
     * @param string $scopes
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect($redirect_url,$scopes='snsapi_userinfo')
    {
        return $this->service->oauth->scopes([$scopes])->redirect($redirect_url);
    }
}