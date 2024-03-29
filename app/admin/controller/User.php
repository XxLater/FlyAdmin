<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\admin\controller;

use app\admin\service\user\RoleService;
use app\admin\service\user\UserService;
use app\common\service\utils\ConstructorTableService;
use app\common\service\utils\ConstructorFormService;
/**
 * Class User
 * @package app\admin\controller
 * @title 用户管理
 * @menu true
 * @auth true
 */
class User extends Base
{
    protected function initialize():void
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->service = UserService::instance();
    }

    /**
     * 基本资料
     * @return void
     */
    public function person()
    {
        if($this->request->isPost())
        {
            $param = $this->request->param();

            foreach($param as $key=>$value)
            {
                if(empty($value) && !is_numeric($value))
                {
                    unset($param[$key]);
                }
            }

            if($result = $this->service->updateData($param['user_id'],'person',$param))
            {
                app('response')->success($this->service->find($param['user_id']));
            }

            app('response')->error('保存失败');
        }
        $this->assign('user',$this->service->find(is_login()));
        $this->fetch();
    }

    public function list()
    {
        if($this->request->isPost())
        {
            [$result['data'],$result['total']] = $this->service->getList();
            
            app('response')->success($result);
        }
        
        $roleList = RoleService::instance()->where('status',1)->column('title','role_id');
        ConstructorTableService::create('用户列表')
        ->addDefaultBlockButton()
        ->addDefaultLineButton()
        ->addTextCol('序号','user_id',80)
        ->addImageCol('头像','avatar')
        ->addTextCol('用户昵称','nickname')
        ->addTextCol('用户名','username')
        ->addTextCol('用户角色','role_id')
        ->addSwitchCol('用户状态','status')
        ->addTextCol('登陆时间','last_login_time',160)
        ->addTextCol('上次注册时间','create_time',160)
        ->setSortFields(['last_login_time','create_time','user_id'])
        ->addTextSearch('用户名','username','%like%')
        ->addTimeSearch('上次登陆','last_login_time')
        ->addTimeSearch('注册时间','create_time')
        ->addSelectSearch('角色类型','role_id',$roleList)
        ->addSelectSearch('用户状态','status',['禁用','启用'])
        ->fetch();
    }

    public function create()
    {
        if($this->request->isPost())
        {
            $param  = $this->request->param();

            $result = $this->service->createData('admin_create',$param);

            if($result)
            {
                app('response')->success('创建成功');
            }

            app('response')->fail('创建失败');
        }

        $roleList = RoleService::instance()->where('status',1)->column('title','role_id');

        ConstructorFormService::create('添加用户')
        ->addImage('头像','avatar')
        ->addText('昵称','nickname',true)
        ->addText('登陆名','username',true)
        ->addText('手机号码','mobile')
        ->addSelect('角色','role_id',true,$roleList)
        ->addPassword('密码','password',true)
        ->addConfirm('确认密码','confirm_password','password')
        ->addSwitch('启用','status',false)
        ->fetch();
    }

    public function update()
    {
        $userId = $this->request->param('user_id');

        $user  = $this->service->findOrEmpty($userId);

        if($user->isEmpty()) app('response')->fail('用户不存在');

        $data = $user->getData();

        if($this->request->isPost())
        {
            $param  = $this->request->param();

            $result = $this->service->updateData($param['user_id'],'admin_update_base',$param);

            if($result)
            {
                app('response')->success('更新成功');
            }

            app('response')->fail('更新失败');
        }

        $roleList = RoleService::instance()->where('status',1)->column('title','role_id');
        unset($data['password']);
        ConstructorFormService::create('编辑用户')
        ->addHide('user_id')
        ->addImage('头像','avatar')
        ->addText('昵称','nickname',true)
        ->addText('登陆名','username',true)
        ->addText('手机号码','mobile')
        ->addSelect('角色','role_id',true,$roleList)
        ->addPassword('密码','password',true)
        ->addConfirm('确认密码','confirm_password','password')
        ->addSwitch('启用','status',false)
        ->setData($data)
        ->fetch();
    }

    public function delete()
    {
        $pk = $this->request->param('user_id');

        if($result = $this->service->deleteData($pk,'1'))
        {
            app('response')->success('删除成功,条数:'.$result);
        }

        app('response')->fail('删除失败');
    }

    public function quickEdit()
    {
        [$pk,$field,$value] = param_list(['user_id',null],['field',null],['value',null]);

        if($pk == 1) app('response')->fail('当前用户不能被修改');

        if($result = $this->service->quickUpdateData($pk,$field,$value))
        {
            app('response')->success($result);
        }
        
        app('response')->fail('error');
    }
}