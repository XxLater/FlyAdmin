<?php 

namespace app\backup\controller;

use app\BaseController;
use app\common\service\utils\QrcodeService;

class Index extends BaseController
{
    public function index()
    {
        $service = QrcodeService::instance();
        
        $path = $service->setScale(4)->create('https://www.jianshu.com/p/e237dc762520');
        
        echo '<img src="'.$path.'">';

        // $this->fetch();
    }
}