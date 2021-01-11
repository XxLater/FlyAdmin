<?php

declare(strict_types=1);

/**
 * @class 基础服务类
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/
namespace app\common\service;
use app\common\exception\ServiceException;
use app\common\model\BaseModel;
use think\Container;

/**
 * @method userNameByUser($username)
 */
class BaseService
{
    /**
     * @var BaseModel
     */
    protected $model;

    /**
     * @param mixed ...$args
     * @return BaseService
     */
    public static function instance(...$args):BaseService
    {
        return Container::getInstance()->invokeClass(static::class, $args);
    }

    /**
     * @param string $msg
     * @param array $data
     * @param int $code
     * @throws ServiceException
     */
    protected function error(string $msg ,$data=[],$code=500):void
    {
       throw new ServiceException($msg,$data,$code);
    }

    public function __call($name, $arguments)
    {
        if (!empty($this->model))
        {
            return call_user_func_array([$this->model,$name],$arguments);
        }

        $this->error('方法不存在:'.__CLASS__);
    }
}