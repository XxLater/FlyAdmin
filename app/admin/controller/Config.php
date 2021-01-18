<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\admin\controller;

use app\common\service\system\AnnotationService;
use think\facade\Config as SystemConfig;
/**
 * @title 系统配置
 * Class Config
 * @package app\admin\controller
 */
class Config extends Base
{
    /**
     * @title 后台配置
     * @auth false
     * @menu false
     */
    public function adminConfig()
    {

        $menuService = AnnotationService::create(app()->getAppPath().SystemConfig::get('route.controller_layer'));

        $menuService->getMethod();

        $menu = $menuService->getMenu();

        $data['logo']['image'] = system_config('site_logo');

        $data['logo']['title'] = system_config('site_title');

        $data['links'] = [
            [
                'icon'=>'layui-icon layui-icon-auz',
                'title'=>'开源地址',
                'href'=>'https://github.com/945462788'
            ]
        ];

        $data['other'] = [
            'keepLoad'=>1200,
            'autoHead'=>false
        ];

        $data['colors'] = [
            [
                'id'=>"1",
                'color'=>'#FF5722',
            ],
            [
                'id'=>"2",
                'color'=>'#5FB878',
            ],
            [
                'id'=>"3",
                'color'=>'#1E9FFF'
            ],
            [
                'id'=>"4",
                'color'=>'#FFB800'
            ],
            [
                'id'=>"5",
                'color'=>'darkgray'
            ]
        ];

        $data['menu'] =
            [
                'data'=>(string)url('admin/menu/getAuthMenu'),
                'accordion'=>true,
                'control'=>false,
                'select'=>$menu[0]['child'][0]['id']
            ];

        $data['tab'] = [
            'muiltTab'  => true,
            'keepState' => true,
            'tabMax'    => 30,
            'index'   =>  $menu[0]['child'][0]
        ];

        $data['theme'] = [
            'defaultColor' => 2,
            'defaultMenu'  => 'dark-them',
            'allowCustom'  => true
        ];

        app('response')->create($data);
    }
    public function site()
    {
        $this->fetch();
    }

    public function email()
    {
        $this->fetch();
    }

    public function sms()
    {
        $this->fetch();
    }

    public function upload()
    {
        $this->fetch();
    }

    public function wechat()
    {
        $this->fetch();
    }

    public function wechatApp()
    {
        $this->fetch();
    }

    public function wechatPay()
    {
        $this->fetch();
    }
}