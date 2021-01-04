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

        $this->data = cache('system_config');

        if (!$this->data)
        {
            $this->data = $this->model->where('status',1)->column('value','key');

            cache('system_config',$this->data);
        }
    }

    /**
     * @param $name
     * @return array|mixed|string
     */
    public function get($name)
    {
        if (is_array($name))
        {
            $data = [];
            foreach ($name as $key)
            {
                if ($key)
                {
                    $data[$key] = $this->getCache($key);
                }
            }
            return $data;
        }

        return $this->getCache($name);
    }

    /**
     * @param $name
     * @return mixed|string
     */
    public function getCache($name)
    {
        return $this->data[$name] ?? '';
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