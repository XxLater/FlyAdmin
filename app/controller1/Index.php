<?php

declare(strict_types=1);

/**
 * @class
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\controller1;


use app\BaseController;
use app\common\service\utils\ConstructorFormService;

class Index extends BaseController
{
    /**
     * 测试
     * @throws \app\common\exception\ServiceException
     */
    public function index()
    {
        $data = ['title'=>'test','menu_id'=>1,'status'=>0];
        ConstructorFormService::create('test')
            ->addText('标题','title',true)
            ->addHideText('menu_id')
            ->addSwitch('开关','status')
            ->formData($data,'menu_id')
            ->fetch();
    }
}