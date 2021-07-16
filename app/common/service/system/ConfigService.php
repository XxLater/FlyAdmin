<?php

declare(strict_types=1);

/**
 * @class
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\service\system;


use app\common\model\system\ConfigModel;
use app\common\service\BaseService;

class ConfigService extends BaseService
{
    protected $model;

    protected $data = [];

    public function __construct(ConfigModel $model)
    {
        $this->model = $model;

        $this->data = cache('system_config'.is_debug() ? '12345' : '');

        if (!$this->data)
        {
            $this->data = $this->model->where('status',1)->column('value','key');

            cache('system_config',$this->data);
        }
    }

    /**
     * @param $name
     * @param string $default
     * @return array|mixed|string
     */
    public function get($name,$default='')
    {
        if (is_array($name))
        {
            $data = [];
            foreach ($name as $key=>$item)
            {
                if (is_array($item))
                {
                    $data[$key] = $this->getCache($item[0],$item[1] ?? '');
                }else
                {
                    $data[$key] = $this->getCache($item);
                }
            }
            return $data;
        }

        return $this->getCache($name,$default);
    }

    /**
     * @param $name
     * @param string $default
     * @return mixed|string
     */
    public function getCache($name,$default='')
    {
        return $this->data[$name] ?? $default;
    }

    /**
     * @param $key
     * @param $value
     * @return void
     */
    public function setCache($key,$value):void
    {
        $this->data[$key] = $value;
        
        cache('system_config',$this->data);
    }
}