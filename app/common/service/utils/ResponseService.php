<?php

declare(strict_types=1);

/**
 * @class json响应服务类
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/

namespace app\common\service\utils;

use app\common\service\BaseService;
use think\contract\Arrayable;
use think\exception\HttpResponseException;
use think\Response;

class ResponseService extends BaseService
{
    protected const ERROR_CODE  = 0;

    protected const SUCCESS_CODE  = 1;

    protected const SUCCESS_MSG = 'ok';

    protected const ERROR_MSG = 'error';

    protected $code =200;

    /**
     * 设置响应码
     * @param $code
     * @return $this
     */
    public function code($code):ResponseService
    {
        $this->code = $code;

        return $this;
    }

    /**
     * 创建响应实列
     * @param $data
     * @return HttpResponseException
     */
    public function create($data=[]):HttpResponseException
    {
        $response = Response::create($data,'json',$this->code);

        throw new HttpResponseException($response);
    }

    /**
     * 创建操作成功响应
     * @param string|array $msg
     * @param $data
     * @return HttpResponseException
     */
    public function success($msg = self::SUCCESS_MSG , $data =[]):HttpResponseException
    {
        if ($msg instanceof Arrayable)
        {
            $msg = $msg->toArray();
        }

        if (is_array($msg))
        {
            $data = $msg;

            $msg = self::SUCCESS_MSG;
        }

        $code = self::SUCCESS_CODE;

        return $this->create(compact('code','msg','data'));
    }

    /**
     * 创建操作失败响应
     * @param string|array $msg
     * @param array $data
     * @param int $code
     * @return HttpResponseException
     */
    public function fail(string $msg = self::ERROR_MSG,  $data = [] ,int $code = self::ERROR_CODE):HttpResponseException
    {
        if ($msg instanceof Arrayable)
        {
            $msg = $msg->toArray();
        }

        if (is_array($msg))
        {
            $data = $msg;

            $msg = self::ERROR_MSG;
        }

        return $this->create(compact('code','msg','data'));
    }
}