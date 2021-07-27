<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/

namespace app\admin\controller;

use app\admin\service\system\SwiperService;
use app\common\service\utils\ConstructorFormService;
use app\common\service\utils\ConstructorTableService;

class Swiper extends Base
{
    protected function initialize()
    {
        $this->service = SwiperService::instance();
    }
    
    public function list()
    {
        if($this->request->isPost())
        {
            [$result['data'],$result['total']] = $this->service->getList();

            app('response')->success($result);
        }
        
        ConstructorTableService::create('轮播图列表')
        ->addDefaultBlockButton()
        ->addDefaultLineButton()
        ->addTextCol('ID','swiper_id')
        ->addImageCol('图片','image')
        ->addEditCol('排序','sort')
        ->addTextCol('创建时间','create_time')
        ->setSortFields('sort')
        ->fetch();
    }

    public function create()
    {
        if($this->request->isPost())
        {
            $param = $this->request->param();

            if($this->service->createData('create',$param))
            {
                app('response')->success('新增成功');
            }
            app('response')->success('新增失败');
        }
        
        ConstructorFormService::create('新增轮播图')
        ->addImage('图片地址','image',true)
        ->addText('排序','sort',true)
        ->fetch();
    }

    public function update()
    {
        $swiperId = $this->request->param('swiper_id');

        $swiper = $this->service->findOrEmpty($swiperId);

        if($swiper->isEmpty()) app('response')->fail('轮播数据不存在');

        if($this->request->isPost())
        {
            $param = $this->request->param();

            if($this->service->updateData($swiperId,'update',$param))
            {
                app('response')->success('新增成功');
            }
            app('response')->success('新增失败');
        }

        ConstructorFormService::create('新增轮播图')
        ->addImage('图片地址','image',true)
        ->addText('排序','sort',true)
        ->setData($swiper,'swiper_id')
        ->fetch();
    }

    public function delete()
    {
        $swiperId = $this->request->param('swiper_id');

        if($result = $this->service->deleteData($swiperId))
        {
            app('response')->success('删除成功,条数:'.$result);
        }

        app('response')->fail('删除失败');
    }

    public function quickEdit()
    {
        [$swiperId,$field,$value] = param_list(['swiper_id'],['field'],['value']);

        if($result = $this->service->quickUpdateData($swiperId,$field,$value))
        {
            app('response')->success('更新成功');
        }

        app('response')->fail('更新失败');
    }
}