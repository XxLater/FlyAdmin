<?php

declare(strict_types=1);

/**
 * @class 系统
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\admin\controller;

use app\common\service\system\ConfigService;
use app\common\service\utils\ConstructorFormService;

/**
 * @title 系统配置
 * Class Config
 * @package app\admin\controller
 */
class Config extends Base
{
    /**
     * 系统配置
     */
    public function site()
    {
        if($this->request->isPost())
        {
            $this->update();
        }
        $data = ConfigService::instance()->where('group','system')->column('value','key');
        ConstructorFormService::create('网站配置')
            ->addImage('网站logo','site_logo',true)
            ->addText('网站标题','site_title',true)
            ->addText('网站关键词','site_keyword')
            ->addTextarea('网站描述','site_description')
            ->addText('最大上传文件大小(mb)','file_size')
            ->addSwitch('登陆是否需要验证码','has_verify_code')
            ->addTag('允许上传文件后缀','file_ext',true)
            ->setData($data)
            ->fetch();
    }

    /**
     * 公众号配置
     * @return void
     */
    public function wechat()
    {
        if($this->request->isPost())
        {
            $this->update();
        }
        $data = ConfigService::instance()->where('group','wechat')->column('value','key');
        ConstructorFormService::create('小程序配置')
            ->addText('公众号ID','wechat_app_id',true)
            ->addText('公众号密钥','wechat_app_secret',true)
            ->setData($data)
            ->fetch();
    }

    /**
     * 小程序配置
     * @return void
     */
    public function wechatApp()
    {
        if($this->request->isPost())
        {
            $this->update();
        }

        $data = ConfigService::instance()->where('group','wechat_app')->column('value','key');
        ConstructorFormService::create('小程序配置')
            ->addText('小程序ID','program_app_id',true)
            ->addText('小程序密钥','program_app_secret',true)
            ->addText('项目名称','app_title',true)
            ->addText('分享名称','share_title',true)
            ->addImage('分享海报图','share_background_image',true)
            ->addImage('肯德基海报图','kfc_background_image',true)
            ->addImage('麦当劳海报图','m_background_image',true)
            ->addImage('电影票海报图','movie_background_image',true)
            ->setData($data)
            ->fetch();
    }

    /**
     * 更新配置
     * @return void
     */
    public function update()
    {
        $param = $this->request->param();

        $total = 0;

        $service = ConfigService::instance();

        foreach($param as $key=>$value)
        {
            $total += $service->where('key',$key)->update(['value'=>$value]);
        }

        if($total ==0) app('response')->fail('error');

        app('response')->success('ok');
    }

    /**
     */
    public function adminConfig()
    {
        $menu = cache('system.auth_menu_'.$this->request->role_id);
        $data['logo']['image'] = system_config('site_logo');

        $data['logo']['title'] = system_config('site_title');

        $data['links'] = [
            [
                'icon'=>'layui-icon layui-icon-auz',
                'title'=>'开源地址',
                'href'=>'https://github.com/945462788'
            ]
        ];

        $data['colors'] = [
            [
                'id'=>"1",
                'color'=>'#5FB878',
            ],
            [
                'id'=>"2",
                'color'=>'#FF5722',
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
                'select'=>$menu[0]['child'][0]['menu_id']
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
}