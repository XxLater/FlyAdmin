<?php

declare(strict_types=1);

/**
 * @class
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\controller\admin;


use app\BaseController;
use app\controller\admin\user\User;
use think\exception\HttpResponseException;
use think\facade\View;
use think\Response;

class AdminBase extends BaseController
{
    /**
     * @param string $tpl
     * @param $args
     * @return HttpResponseException
     * @throws HttpResponseException
     */
    protected function fetch($tpl = '' , $args = []):HttpResponseException
    {
        throw new HttpResponseException(Response::create(View::fetch($tpl,$args)));
    }

    /**
     * @param $key
     * @param null $value
     * @return void
     */
    protected function assign($key , $value = null):void
    {
        View::assign($key,$value);
    }
}