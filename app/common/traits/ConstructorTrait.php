<?php 
declare(strict_types=1);

namespace app\common\traits;
use app\common\exception\ServiceException;
use app\common\model\system\ConstructorModel;
use app\common\service\utils\ConstructorFormService;
/**
 * 
 */

 trait ConstructorTrait
 {
     /**
      * 新增
      * @return void
      */
     public function create()
     {
        if($this->request->isPost())
        {
            $param = $this->request->param();

            $this->service->validate($param,'create');

            
        }
        ConstructorFormService::create('测试阿')
        ->setItem($this->constructor)
        ->fetch();
     }
     
     /**
      * 更新
      * @return void
      */
     public function update()
     {

     }

     /**
      * 列表
      * @return void
      */
     public function list()
     {
        
     }

     /**
      * 删除
      * @return void
      */
     public function delete()
     {

     }
 }

 