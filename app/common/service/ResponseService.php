<?php

declare(strict_types=1);

/**
 * @class json响应服务类
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/

namespace app\common\service;

use think\contract\Arrayable;
use think\exception\HttpResponseException;
use think\Response;

class ResponseService extends BaseService
{
    protected const ERROR_CODE  = 400;

    protected const SUCCESS_CODE  = 200;

    protected const SUCCESS_MSG = 'ok';

    protected const ERROR_MSG = 'error';

    protected $code;

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
     * @param int $code
     * @param $data
     * @param $msg
     * @return HttpResponseException
     */
    public function create($msg, $data=[], int $code=0):HttpResponseException
    {
        if ($data instanceof Arrayable)
        {
            $data =  $data->toArray();
        }

        $result = compact('code','data','msg');

        $response = Response::create($result,'json',$this->code);

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
        if (is_array($msg))
        {
            $data = $msg;

            $msg = self::SUCCESS_MSG;
        }

        $this->code = self::SUCCESS_CODE;

        return $this->create($msg,$data,1);
    }

    /**
     * 创建操作成功响应
     * @param string|array $msg
     * @param $data
     * @return HttpResponseException
     */
    public function error($msg = self::ERROR_MSG , $data =[]):HttpResponseException
    {
        if (is_array($msg))
        {
            $data = $msg;

            $msg = self::ERROR_MSG;
        }

        $this->code = self::ERROR_CODE;

        return $this->create($msg,$data,0);
    }
}