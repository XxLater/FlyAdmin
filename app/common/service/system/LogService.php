<?php

declare(strict_types=1);

/**
 * @class 系统日志服务类
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\service\system;

use app\common\model\system\LogModel;
use app\common\service\BaseService;
use app\common\validate\LogValidate;
use app\Request;
use think\exception\ValidateException;
use think\Response;
use think\response\Html;

/**
 * @method userIdByUser($user_id)
 */
class LogService extends BaseService
{
    public function __construct(LogModel $model,LogValidate $logValidate)
    {
        $this->model = $model;
        $this->validate = $logValidate;
    }

    public function create(Request $request,Response $response)
    {
        if($response instanceof Html) return false;

        $flag = $this->model
        ->where(['user_id'=>$request->user_id,'href'=>get_path()])
        ->whereTime('create_time','between',[strtotime('-60 seconds'),time()])
        ->findOrEmpty();

        if($flag->isEmpty() == false) return false;

        $responseData = $response->getData();

        if(isset($responseData['data']['data']) && isset($responseData['data']['total'])) return false;

        $data['module'] = app('http')->getName();

        $data['method'] = strtoupper($request->method());

        $data['param'] = json_encode($request->param(),JSON_UNESCAPED_UNICODE);

        $data['href'] = get_path();
        
        $data['client'] = get_client();

        $data['ip'] = $request->header("x-forwarded-for") ? explode(',',$request->header("x-forwarded-for"))[0] : $request->ip();

        $data['user_id'] = $request->user_id;

        $data['response'] = json_encode($responseData,JSON_UNESCAPED_UNICODE);

        try
        {
            $this->validate('create',$data);
            return $this->model->save($data);
        } catch (ValidateException $e)
        {
            $this->error($e->getError());
        }
    }
}