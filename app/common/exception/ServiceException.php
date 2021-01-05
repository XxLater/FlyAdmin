<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\exception;


use think\Exception;

class ServiceException extends Exception
{
    public function __construct($message = "", $data =[] ,$code = 0)
    {
        $this->message = $message;
        $this->code = $code;
        $this->data = $data;
    }
}