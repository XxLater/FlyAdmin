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
use think\Container;

class BaseService
{
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
     * @throws ServiceException
     */
    protected function error(string $msg ,$data=[]):void
    {
       throw new ServiceException($msg,$data);
    }

    public function __call($name, $arguments)
    {
        if (!empty($this->model))
        {
            return call_user_func([$this->model,$name],$arguments);
        }

        $this->error('方法不存在:'.__CLASS__);
        // TODO: Implement __call() method.
    }
}