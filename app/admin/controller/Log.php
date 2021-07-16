<?php 
declare(strict_types=1);


namespace app\admin\controller;

use app\common\service\system\LogService;
use app\common\service\utils\ConstructorTableService;

class Log extends Base
{
    public function initialize()
    {
        $this->service = LogService::instance();
    }
    public function list()
    {
        if($this->request->isPost())
        {
            [$result['data'],$result['total']] = $this->service->getList();
            app('response')->success($result);
        }

        ConstructorTableService::create('行为日志')
        ->setCheckBox(false)
        ->addTextCol('模块','module')
        ->addTextCol('请求方式','method',120)
        ->addTextCol('请求地址','href',200)
        ->addTextCol('浏览器','client')
        ->addTextCol('操作IP','ip',120)
        ->addTextCol('操作人','user_id')
        ->addTextCol('请求数据','param')
        ->addTextCol('响应数据','response')
        ->addTextCol('请求时间','create_time',160)
        ->fetch();
    }
}